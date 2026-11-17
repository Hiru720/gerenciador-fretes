<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int)($_GET['id'] ?? 0);
$en = ['id' => '', 'rua' => '', 'numero' => '', 'bairro' => '', 'cidade' => '', 'estado' => '', 'cep' => ''];

if ($id) {
    $st = $pdo->prepare('SELECT * FROM enderecos WHERE id = ?');
    $st->execute([$id]);
    $en = $st->fetch();
    if (!$en) {
        flash('danger', 'Endereço não encontrado.');
        redirecionar('/enderecos/index.php');
    }
}

$titulo = $id ? 'Editar endereço' : 'Novo endereço';
require_once __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-3"><?= $titulo ?></h1>
<div class="card"><div class="card-body">
    <form action="salvar.php" method="post">
        <input type="hidden" name="id" value="<?= e($en['id']) ?>">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label" for="rua">Rua</label>
                <input type="text" class="form-control" id="rua" name="rua" maxlength="150" value="<?= e($en['rua']) ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label" for="numero">Número</label>
                <input type="text" class="form-control" id="numero" name="numero" maxlength="10" value="<?= e($en['numero']) ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="cep">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" maxlength="9" data-mascara="cep" value="<?= e($en['cep']) ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label" for="bairro">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" maxlength="80" value="<?= e($en['bairro']) ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label" for="cidade">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" maxlength="80" value="<?= e($en['cidade']) ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label" for="estado">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="">Escolha</option>
                    <?php foreach (UFS as $uf): ?>
                        <option value="<?= $uf ?>" <?= $en['estado'] === $uf ? 'selected' : '' ?>><?= $uf ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Salvar endereço</button>
            <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
