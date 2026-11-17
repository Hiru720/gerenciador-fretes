<?php
$titulo = 'Transportadores';
require_once __DIR__ . '/../includes/header.php';
$transportadores = $pdo->query('SELECT * FROM transportadores ORDER BY nome')->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Transportadores</h1>
    <a href="form.php" class="btn btn-primary">Novo transportador</a>
</div>

<?php if (!$transportadores): ?>
    <div class="alert alert-light border">Nenhum transportador cadastrado ainda. Clique em "Novo transportador" para começar.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
            <thead>
                <tr><th>Nome</th><th>CNPJ</th><th>Telefone</th><th>Placa</th><th class="text-end">Ações</th></tr>
            </thead>
            <tbody>
            <?php foreach ($transportadores as $t): ?>
                <tr>
                    <td><?= e($t['nome']) ?></td>
                    <td><?= e($t['cnpj']) ?></td>
                    <td><?= e($t['telefone']) ?></td>
                    <td><?= e($t['placa']) ?></td>
                    <td class="text-end">
                        <a href="form.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form action="excluir.php" method="post" class="d-inline" onsubmit="return confirm('Excluir este transportador?');">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
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
