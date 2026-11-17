<?php
require_once __DIR__ . '/../includes/init.php';

$id = (int)($_POST['id'] ?? 0);

try {
    $pdo->beginTransaction();
    $pdo->prepare('DELETE FROM frete_produtos WHERE frete_id = ?')->execute([$id]);
    $pdo->prepare('DELETE FROM fretes WHERE id = ?')->execute([$id]);
    $pdo->commit();
    flash('success', 'Frete excluído.');
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    flash('danger', 'Não foi possível excluir o frete.');
}
redirecionar('/fretes/index.php');
