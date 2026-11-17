<?php
$titulo = 'Início';
require_once __DIR__ . '/includes/header.php';

$total = [
    'Produtos'        => $pdo->query('SELECT COUNT(*) FROM produtos')->fetchColumn(),
    'Endereços'       => $pdo->query('SELECT COUNT(*) FROM enderecos')->fetchColumn(),
    'Transportadores' => $pdo->query('SELECT COUNT(*) FROM transportadores')->fetchColumn(),
    'Fretes'          => $pdo->query('SELECT COUNT(*) FROM fretes')->fetchColumn(),
];

$recentes = $pdo->query("SELECT f.id, f.data_frete, t.nome AS transportador,
                                o.cidade AS o_cidade, d.cidade AS d_cidade
                         FROM fretes f
                         JOIN transportadores t ON t.id = f.transportador_id
                         JOIN enderecos o ON o.id = f.origem_id
                         JOIN enderecos d ON d.id = f.destino_id
                         ORDER BY f.id DESC LIMIT 5")->fetchAll();
?>
<h1 class="h3 mb-3">Painel</h1>

<div class="row g-3 mb-4">
<?php foreach ($total as $nome => $qtd): ?>
    <div class="col-6 col-md-3">
        <div class="card"><div class="card-body">
            <div class="numero-grande"><?= (int)$qtd ?></div>
            <div class="text-muted"><?= $nome ?></div>
        </div></div>
    </div>
<?php endforeach; ?>
</div>

<div class="mb-4">
    <a href="<?= BASE_URL ?>/produtos/form.php" class="btn btn-primary">Novo produto</a>
    <a href="<?= BASE_URL ?>/enderecos/form.php" class="btn btn-primary">Novo endereço</a>
    <a href="<?= BASE_URL ?>/transportadores/form.php" class="btn btn-primary">Novo transportador</a>
    <a href="<?= BASE_URL ?>/fretes/form.php" class="btn btn-amber">Gerar frete</a>
</div>

<h2 class="h5">Últimos fretes</h2>
<?php if (!$recentes): ?>
    <div class="alert alert-light border">Ainda não há fretes. Cadastre produtos, endereços e um transportador, depois clique em "Gerar frete".</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover bg-white">
            <thead><tr><th>Nº</th><th>Data</th><th>Transportador</th><th>Rota</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($recentes as $r): ?>
                <tr>
                    <td>#<?= $r['id'] ?></td>
                    <td><?= dataBR($r['data_frete']) ?></td>
                    <td><?= e($r['transportador']) ?></td>
                    <td><?= e($r['o_cidade']) ?> para <?= e($r['d_cidade']) ?></td>
                    <td class="text-end"><a href="<?= BASE_URL ?>/fretes/ver.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary">Ver</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
