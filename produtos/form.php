<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int)($_GET['id'] ?? 0);
$p = ['id' => '', 'nome' => '', 'descricao' => '', 'peso' => '', 'valor' => ''];

if ($id) {
    $st = $pdo->prepare('SELECT * FROM produtos WHERE id = ?');
    $st->execute([$id]);
    $p = $st->fetch();
    if (!$p) {
        flash('danger', 'Produto não encontrado.');
        redirecionar('/produtos/index.php');
    }
}

$titulo = $id ? 'Editar produto' : 'Novo produto';
require_once __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-3"><?= $titulo ?></h1>
<div class="card"><div class="card-body">
    <form action="salvar.php" method="post">
        <input type="hidden" name="id" value="<?= e($p['id']) ?>">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label" for="nome">Nome do produto</label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="100" value="<?= e($p['nome']) ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label" for="peso">Peso (kg)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="peso" name="peso" value="<?= e($p['peso']) ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label" for="valor">Valor (R$)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="valor" name="valor" value="<?= e($p['valor']) ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= e($p['descricao']) ?></textarea>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Salvar produto</button>
            <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
