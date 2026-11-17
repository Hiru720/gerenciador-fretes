<?php
$titulo = 'Produtos';
require_once __DIR__ . '/../includes/header.php';
$produtos = $pdo->query('SELECT * FROM produtos ORDER BY nome')->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Produtos</h1>
    <a href="form.php" class="btn btn-primary">Novo produto</a>
</div>

<?php if (!$produtos): ?>
    <div class="alert alert-light border">Nenhum produto cadastrado ainda. Clique em "Novo produto" para começar.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
            <thead>
                <tr><th>Nome</th><th>Descrição</th><th>Peso (kg)</th><th>Valor</th><th class="text-end">Ações</th></tr>
            </thead>
            <tbody>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= e($p['nome']) ?></td>
                    <td><?= e($p['descricao']) ?></td>
                    <td><?= number_format($p['peso'], 2, ',', '.') ?></td>
                    <td><?= moeda($p['valor']) ?></td>
                    <td class="text-end">
                        <a href="form.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form action="excluir.php" method="post" class="d-inline" onsubmit="return confirm('Excluir este produto?');">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
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
