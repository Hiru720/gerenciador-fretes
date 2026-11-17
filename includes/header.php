<?php require_once __DIR__ . '/init.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'Gerenciador de Fretes') ?> - Fretes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/estilo.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark barra">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/index.php">Gerenciador de Fretes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link <?= ativo('produtos') ?>" href="<?= BASE_URL ?>/produtos/index.php">Produtos</a></li>
                <li class="nav-item"><a class="nav-link <?= ativo('enderecos') ?>" href="<?= BASE_URL ?>/enderecos/index.php">Endereços</a></li>
                <li class="nav-item"><a class="nav-link <?= ativo('transportadores') ?>" href="<?= BASE_URL ?>/transportadores/index.php">Transportadores</a></li>
                <li class="nav-item"><a class="nav-link <?= ativo('fretes') ?>" href="<?= BASE_URL ?>/fretes/index.php">Fretes</a></li>
                <li class="nav-item"><a class="nav-link <?= ativo('relatorios') ?>" href="<?= BASE_URL ?>/relatorios/index.php">Relatório</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">
<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-<?= e($_SESSION['flash']['tipo']) ?> alert-dismissible fade show" role="alert">
        <?= e($_SESSION['flash']['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
