<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('/enderecos/index.php');
}

$id     = (int)($_POST['id'] ?? 0);
$rua    = trim($_POST['rua'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$bairro = trim($_POST['bairro'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$estado = $_POST['estado'] ?? '';
$cep    = trim($_POST['cep'] ?? '');

if ($rua === '' || $cidade === '' || !in_array($estado, UFS, true)) {
    flash('danger', 'Preencha rua, cidade e estado.');
    redirecionar('/enderecos/form.php' . ($id ? '?id=' . $id : ''));
}

if ($id) {
    $st = $pdo->prepare('UPDATE enderecos SET rua = ?, numero = ?, bairro = ?, cidade = ?, estado = ?, cep = ? WHERE id = ?');
    $st->execute([$rua, $numero, $bairro, $cidade, $estado, $cep, $id]);
} else {
    $st = $pdo->prepare('INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?)');
    $st->execute([$rua, $numero, $bairro, $cidade, $estado, $cep]);
}

flash('success', 'Endereço salvo com sucesso!');
redirecionar('/enderecos/index.php');
