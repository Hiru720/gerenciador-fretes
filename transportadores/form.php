<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int)($_GET['id'] ?? 0);
$t = ['id' => '', 'nome' => '', 'cnpj' => '', 'telefone' => '', 'placa' => ''];

if ($id) {
    $st = $pdo->prepare('SELECT * FROM transportadores WHERE id = ?');
    $st->execute([$id]);
    $t = $st->fetch();
    if (!$t) {
        flash('danger', 'Transportador não encontrado.');
        redirecionar('/transportadores/index.php');
    }
}

$titulo = $id ? 'Editar transportador' : 'Novo transportador';
require_once __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-3"><?= $titulo ?></h1>
<div class="card"><div class="card-body">
    <form action="salvar.php" method="post">
        <input type="hidden" name="id" value="<?= e($t['id']) ?>">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="nome">Nome / Razão social</label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="100" value="<?= e($t['nome']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="cnpj">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" maxlength="18" data-mascara="cnpj" value="<?= e($t['cnpj']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" maxlength="15" data-mascara="telefone" value="<?= e($t['telefone']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="placa">Placa do veículo</label>
                <input type="text" class="form-control" id="placa" name="placa" maxlength="8" data-mascara="placa" value="<?= e($t['placa']) ?>">
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Salvar transportador</button>
            <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
