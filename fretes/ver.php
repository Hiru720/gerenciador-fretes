<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int)($_GET['id'] ?? 0);

$st = $pdo->prepare('SELECT f.*, t.nome AS transportador, t.placa, t.telefone
                     FROM fretes f JOIN transportadores t ON t.id = f.transportador_id
                     WHERE f.id = ?');
$st->execute([$id]);
$frete = $st->fetch();
if (!$frete) {
    flash('danger', 'Frete não encontrado.');
    redirecionar('/fretes/index.php');
}

$stEnd = $pdo->prepare('SELECT * FROM enderecos WHERE id = ?');
$stEnd->execute([$frete['origem_id']]);
$origem = $stEnd->fetch();
$stEnd->execute([$frete['destino_id']]);
$destino = $stEnd->fetch();

$stItens = $pdo->prepare('SELECT p.nome, p.peso, p.valor, fp.quantidade
                          FROM frete_produtos fp JOIN produtos p ON p.id = fp.produto_id
                          WHERE fp.frete_id = ? ORDER BY p.nome');
$stItens->execute([$id]);
$itens = $stItens->fetchAll();

$pesoTotal = 0;
$valorTotal = 0;
foreach ($itens as $it) {
    $pesoTotal  += $it['peso'] * $it['quantidade'];
    $valorTotal += $it['valor'] * $it['quantidade'];
}

$titulo = 'Frete #' . $id;
require_once __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Frete #<?= $id ?></h1>
    <a href="index.php" class="btn btn-outline-secondary">Voltar para a lista</a>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card h-100"><div class="card-body">
            <h2 class="h6 text-muted">Transportador</h2>
            <p class="mb-1 fw-semibold"><?= e($frete['transportador']) ?></p>
            <p class="mb-1">Placa: <?= e($frete['placa'] ?: '-') ?></p>
            <p class="mb-0">Telefone: <?= e($frete['telefone'] ?: '-') ?></p>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card h-100"><div class="card-body">
            <h2 class="h6 text-muted">Origem</h2>
            <p class="mb-1 fw-semibold"><?= e(rotuloEndereco($origem)) ?></p>
            <p class="mb-0"><?= e($origem['bairro']) ?> - CEP <?= e($origem['cep'] ?: '-') ?></p>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card h-100"><div class="card-body">
            <h2 class="h6 text-muted">Destino</h2>
            <p class="mb-1 fw-semibold"><?= e(rotuloEndereco($destino)) ?></p>
            <p class="mb-0"><?= e($destino['bairro']) ?> - CEP <?= e($destino['cep'] ?: '-') ?></p>
        </div></div>
    </div>
</div>

<p>Data do frete: <strong><?= dataBR($frete['data_frete']) ?></strong></p>

<div class="table-responsive">
    <table class="table align-middle bg-white">
        <thead>
            <tr><th>Produto</th><th>Qtd</th><th>Peso unit. (kg)</th><th>Valor unit.</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
        <?php foreach ($itens as $it): ?>
            <tr>
                <td><?= e($it['nome']) ?></td>
                <td><?= (int)$it['quantidade'] ?></td>
                <td><?= number_format($it['peso'], 2, ',', '.') ?></td>
                <td><?= moeda($it['valor']) ?></td>
                <td><?= moeda($it['valor'] * $it['quantidade']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="fw-semibold">
                <td colspan="2">Totais</td>
                <td><?= number_format($pesoTotal, 2, ',', '.') ?> kg</td>
                <td></td>
                <td><?= moeda($valorTotal) ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
