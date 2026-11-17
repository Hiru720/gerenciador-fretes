<?php
$titulo = 'Novo frete';
$scripts = ['fretes.js'];
require_once __DIR__ . '/../includes/header.php';

$transportadores = $pdo->query('SELECT id, nome, placa FROM transportadores ORDER BY nome')->fetchAll();
$enderecos       = $pdo->query('SELECT * FROM enderecos ORDER BY cidade, rua')->fetchAll();
$produtos        = $pdo->query('SELECT id, nome FROM produtos ORDER BY nome')->fetchAll();

// Lista do que ainda falta cadastrar
$faltando = [];
if (!$transportadores)       $faltando[] = '1 transportador';
if (count($enderecos) < 2)   $faltando[] = '2 endereços (origem e destino)';
if (!$produtos)              $faltando[] = '1 produto';
?>
<h1 class="h3 mb-3">Gerar novo frete</h1>

<?php if ($faltando): ?>
    <div class="alert alert-warning">
        Antes de gerar um frete, cadastre: <strong><?= e(implode(', ', $faltando)) ?></strong>.
    </div>
<?php else: ?>
<form action="salvar.php" method="post">
    <div class="card mb-3"><div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="transportador_id">Transportador</label>
                <select class="form-select" id="transportador_id" name="transportador_id" required>
                    <option value="">Escolha o transportador</option>
                    <?php foreach ($transportadores as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= e($t['nome']) ?><?= $t['placa'] ? ' (' . e($t['placa']) . ')' : '' ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="data_frete">Data do frete</label>
                <input type="date" class="form-control" id="data_frete" name="data_frete" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="origem_id">Endereço de origem</label>
                <select class="form-select" id="origem_id" name="origem_id" required>
                    <option value="">Escolha a origem</option>
                    <?php foreach ($enderecos as $en): ?>
                        <option value="<?= $en['id'] ?>"><?= e(rotuloEndereco($en)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="destino_id">Endereço de destino</label>
                <select class="form-select" id="destino_id" name="destino_id" required>
                    <option value="">Escolha o destino</option>
                    <?php foreach ($enderecos as $en): ?>
                        <option value="<?= $en['id'] ?>"><?= e(rotuloEndereco($en)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div></div>

    <div class="card mb-3"><div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 m-0">Produtos deste frete</h2>
            <button type="button" id="btnAdicionar" class="btn btn-sm btn-outline-primary">Adicionar produto</button>
        </div>
        <div id="listaProdutos"></div>
    </div></div>

    <button class="btn btn-amber">Gerar frete</button>
    <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
</form>

<!-- Modelo da linha de produto: o JavaScript copia isto a cada clique em "Adicionar produto" -->
<template id="modeloLinha">
    <div class="row g-2 align-items-end linha-produto mb-2">
        <div class="col-md-7">
            <label class="form-label">Produto</label>
            <select name="produto_id[]" class="form-select" required>
                <option value="">Escolha o produto</option>
                <?php foreach ($produtos as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= e($p['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Quantidade</label>
            <input type="number" name="quantidade[]" class="form-control" min="1" value="1" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-danger w-100 btn-remover">Remover</button>
        </div>
    </div>
</template>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
