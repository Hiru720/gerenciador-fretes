<?php
$titulo = 'Relatório';
require_once __DIR__ . '/../includes/header.php';

$data = $_GET['data'] ?? date('Y-m-d');
if (!DateTime::createFromFormat('Y-m-d', $data)) {
    $data = date('Y-m-d');
}
$linhas = linhasRelatorio($pdo, $data);
?>
<h1 class="h3 mb-3">Relatório de fretes por dia</h1>

<div class="card mb-3"><div class="card-body">
    <form method="get" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label" for="data">Escolha o dia</label>
            <input type="date" class="form-control" id="data" name="data" value="<?= e($data) ?>" required>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Ver relatório</button>
        </div>
        <?php if ($linhas): ?>
        <div class="col-auto">
            <a href="baixar.php?data=<?= e($data) ?>" class="btn btn-amber">Baixar relatório (CSV)</a>
        </div>
        <?php endif; ?>
    </form>
</div></div>

<?php if (!$linhas): ?>
    <div class="alert alert-light border">Nenhum frete encontrado em <?= dataBR($data) ?>.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
            <thead>
                <tr><th>Frete</th><th>Transportador</th><th>Origem</th><th>Destino</th><th>Produto</th><th>Qtd</th><th>Valor unit.</th></tr>
            </thead>
            <tbody>
            <?php foreach ($linhas as $l): ?>
                <tr>
                    <td>#<?= $l['frete'] ?></td>
                    <td><?= e($l['transportador']) ?></td>
                    <td><?= e($l['origem']) ?></td>
                    <td><?= e($l['destino']) ?></td>
                    <td><?= e($l['produto']) ?></td>
                    <td><?= (int)$l['quantidade'] ?></td>
                    <td><?= moeda($l['valor']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
