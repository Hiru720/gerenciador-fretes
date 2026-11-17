<?php
$titulo = 'Endereços';
require_once __DIR__ . '/../includes/header.php';
$enderecos = $pdo->query('SELECT * FROM enderecos ORDER BY cidade, rua')->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Endereços</h1>
    <a href="form.php" class="btn btn-primary">Novo endereço</a>
</div>

<?php if (!$enderecos): ?>
    <div class="alert alert-light border">Nenhum endereço cadastrado ainda. Cadastre pelo menos dois (origem e destino) para gerar um frete.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
            <thead>
                <tr><th>Rua</th><th>Nº</th><th>Bairro</th><th>Cidade/UF</th><th>CEP</th><th class="text-end">Ações</th></tr>
            </thead>
            <tbody>
            <?php foreach ($enderecos as $en): ?>
                <tr>
                    <td><?= e($en['rua']) ?></td>
                    <td><?= e($en['numero']) ?></td>
                    <td><?= e($en['bairro']) ?></td>
                    <td><?= e($en['cidade']) ?>/<?= e($en['estado']) ?></td>
                    <td><?= e($en['cep']) ?></td>
                    <td class="text-end">
                        <a href="form.php?id=<?= $en['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form action="excluir.php" method="post" class="d-inline" onsubmit="return confirm('Excluir este endereço?');">
                            <input type="hidden" name="id" value="<?= $en['id'] ?>">
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
