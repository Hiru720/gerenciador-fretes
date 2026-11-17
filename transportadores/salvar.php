<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('/transportadores/index.php');
}

$id       = (int)($_POST['id'] ?? 0);
$nome     = trim($_POST['nome'] ?? '');
$cnpj     = trim($_POST['cnpj'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$placa    = strtoupper(trim($_POST['placa'] ?? ''));

if ($nome === '') {
    flash('danger', 'Informe o nome do transportador.');
    redirecionar('/transportadores/form.php' . ($id ? '?id=' . $id : ''));
}

if ($id) {
    $st = $pdo->prepare('UPDATE transportadores SET nome = ?, cnpj = ?, telefone = ?, placa = ? WHERE id = ?');
    $st->execute([$nome, $cnpj, $telefone, $placa, $id]);
} else {
    $st = $pdo->prepare('INSERT INTO transportadores (nome, cnpj, telefone, placa) VALUES (?, ?, ?, ?)');
    $st->execute([$nome, $cnpj, $telefone, $placa]);
}

flash('success', 'Transportador salvo com sucesso!');
redirecionar('/transportadores/index.php');
