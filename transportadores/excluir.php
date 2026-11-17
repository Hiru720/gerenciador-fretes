<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int)($_POST['id'] ?? 0);

try {
    $pdo->prepare('DELETE FROM transportadores WHERE id = ?')->execute([$id]);
    flash('success', 'Transportador excluído.');
} catch (PDOException $e) {
    flash('danger', 'Esse transportador está em algum frete e não pode ser excluído.');
}
redirecionar('/transportadores/index.php');
