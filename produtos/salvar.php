<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('/produtos/index.php');
}

$id        = (int)($_POST['id'] ?? 0);
$nome      = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$peso      = (float)str_replace(',', '.', $_POST['peso'] ?? '0');
$valor     = (float)str_replace(',', '.', $_POST['valor'] ?? '0');

if ($nome === '') {
    flash('danger', 'Informe o nome do produto.');
    redirecionar('/produtos/form.php' . ($id ? '?id=' . $id : ''));
}

if ($id) {
    $st = $pdo->prepare('UPDATE produtos SET nome = ?, descricao = ?, peso = ?, valor = ? WHERE id = ?');
    $st->execute([$nome, $descricao, $peso, $valor, $id]);
} else {
    $st = $pdo->prepare('INSERT INTO produtos (nome, descricao, peso, valor) VALUES (?, ?, ?, ?)');
    $st->execute([$nome, $descricao, $peso, $valor]);
}

flash('success', 'Produto salvo com sucesso!');
redirecionar('/produtos/index.php');
