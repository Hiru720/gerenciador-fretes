<?php
// Carrega sessão, conexão e funções. Todo arquivo PHP do sistema começa por aqui.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/funcoes.php';
