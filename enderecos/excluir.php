<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int)($_POST['id'] ?? 0);

try {
    $pdo->prepare('DELETE FROM enderecos WHERE id = ?')->execute([$id]);
    flash('success', 'Endereço excluído.');
} catch (PDOException $e) {
    flash('danger', 'Esse endereço está em algum frete e não pode ser excluído.');
}
redirecionar('/enderecos/index.php');
