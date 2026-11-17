<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int)($_POST['id'] ?? 0);

try {
    $pdo->prepare('DELETE FROM produtos WHERE id = ?')->execute([$id]);
    flash('success', 'Produto excluído.');
} catch (PDOException $e) {
    flash('danger', 'Esse produto está em algum frete e não pode ser excluído.');
}
redirecionar('/produtos/index.php');
