<?php
// Configuração de conexão com o banco (padrão do XAMPP: usuário root, sem senha)
define('BASE_URL', '/Fretes');

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=fretes_db;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Erro ao conectar no banco: ' . $e->getMessage());
}
