<?php
$titulo = 'Fretes';
require_once __DIR__ . '/../includes/header.php';

$sql = "SELECT f.id, f.data_frete, t.nome AS transportador,
               o.cidade AS o_cidade, o.estado AS o_estado,
               d.cidade AS d_cidade, d.estado AS d_estado,
               (SELECT COALESCE(SUM(quantidade), 0) FROM frete_produtos WHERE frete_id = f.id) AS itens
        FROM fretes f
        JOIN transportadores t ON t.id = f.transportador_id
        JOIN enderecos o ON o.id = f.origem_id
        JOIN enderecos d ON d.id = f.destino_id
        ORDER BY f.data_frete DESC, f.id DESC";
$fretes = $pdo->query($sql)->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Fretes</h1>
    <a href="form.php" class="btn btn-amber">Gerar novo frete</a>
</div>

<?php if (!$fretes): ?>
    <div class="alert alert-light border">Nenhum frete gerado ainda. Clique em "Gerar novo frete" para criar o primeiro.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
            <thead>
                <tr><th>Nº</th><th>Data</th><th>Transportador</th><th>Origem</th><th>Destino</th><th>Itens</th><th class="text-end">Ações</th></tr>
            </thead>
            <tbody>
            <?php foreach ($fretes as $f): ?>
                <tr>
                    <td>#<?= $f['id'] ?></td>
                    <td><?= dataBR($f['data_frete']) ?></td>
                    <td><?= e($f['transportador']) ?></td>
                    <td><?= e($f['o_cidade']) ?>/<?= e($f['o_estado']) ?></td>
                    <td><?= e($f['d_cidade']) ?>/<?= e($f['d_estado']) ?></td>
                    <td><?= (int)$f['itens'] ?></td>
                    <td class="text-end">
                        <a href="ver.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                        <form action="excluir.php" method="post" class="d-inline" onsubmit="return confirm('Excluir este frete?');">
                            <input type="hidden" name="id" value="<?= $f['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
