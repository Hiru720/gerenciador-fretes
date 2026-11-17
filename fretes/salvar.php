<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('/fretes/index.php');
}

$transportador = (int)($_POST['transportador_id'] ?? 0);
$origem        = (int)($_POST['origem_id'] ?? 0);
$destino       = (int)($_POST['destino_id'] ?? 0);
$data          = $_POST['data_frete'] ?? '';
$produtos      = $_POST['produto_id'] ?? [];
$quantidades   = $_POST['quantidade'] ?? [];

// Validações básicas
$dataValida = DateTime::createFromFormat('Y-m-d', $data);
if (!$transportador || !$origem || !$destino || !$dataValida) {
    flash('danger', 'Preencha transportador, origem, destino e data.');
    redirecionar('/fretes/form.php');
}
if ($origem === $destino) {
    flash('danger', 'A origem e o destino precisam ser endereços diferentes.');
    redirecionar('/fretes/form.php');
}

// Monta a lista de itens (ignora linhas sem produto)
$itens = [];
foreach ($produtos as $i => $produtoId) {
    $produtoId = (int)$produtoId;
    if ($produtoId > 0) {
        $itens[] = ['produto' => $produtoId, 'qtd' => max(1, (int)($quantidades[$i] ?? 1))];
    }
}
if (!$itens) {
    flash('danger', 'Adicione pelo menos um produto ao frete.');
    redirecionar('/fretes/form.php');
}

try {
    $pdo->beginTransaction();

    $st = $pdo->prepare('INSERT INTO fretes (transportador_id, origem_id, destino_id, data_frete) VALUES (?, ?, ?, ?)');
    $st->execute([$transportador, $origem, $destino, $data]);
    $freteId = $pdo->lastInsertId();

    // 1 frete -> vários produtos (ligação 1 para muitos)
    $stItem = $pdo->prepare('INSERT INTO frete_produtos (frete_id, produto_id, quantidade) VALUES (?, ?, ?)');
    foreach ($itens as $item) {
        $stItem->execute([$freteId, $item['produto'], $item['qtd']]);
    }

    $pdo->commit();
    flash('success', 'Frete #' . $freteId . ' gerado com sucesso!');
    redirecionar('/fretes/ver.php?id=' . $freteId);
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    flash('danger', 'Não foi possível gerar o frete. Tente novamente.');
    redirecionar('/fretes/form.php');
}
