<?php
// Funções de apoio usadas em várias telas

const UFS = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA',
             'PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];

// Escapa texto para exibir no HTML com segurança
function e($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

// Guarda uma mensagem para aparecer na próxima tela
function flash($tipo, $mensagem) {
    $_SESSION['flash'] = ['tipo' => $tipo, 'msg' => $mensagem];
}

// Redireciona para outra página do sistema
function redirecionar($caminho) {
    header('Location: ' . BASE_URL . $caminho);
    exit;
}

function moeda($valor) {
    return 'R$ ' . number_format((float)$valor, 2, ',', '.');
}

function dataBR($data) {
    return date('d/m/Y', strtotime($data));
}

// Marca o item do menu da página atual
function ativo($pasta) {
    return basename(dirname($_SERVER['SCRIPT_NAME'])) === $pasta ? 'active' : '';
}

// Texto curto de um endereço (usado nos selects e listas)
function rotuloEndereco($end) {
    $numero = $end['numero'] !== '' ? ', ' . $end['numero'] : '';
    return $end['rua'] . $numero . ' - ' . $end['cidade'] . '/' . $end['estado'];
}

// Busca os itens de todos os fretes de um dia (usado na tela e no CSV do relatório)
function linhasRelatorio($pdo, $data) {
    $sql = "SELECT f.id AS frete, f.data_frete, t.nome AS transportador, t.placa,
                   CONCAT(o.cidade, '/', o.estado) AS origem,
                   CONCAT(d.cidade, '/', d.estado) AS destino,
                   p.nome AS produto, fp.quantidade, p.peso, p.valor
            FROM fretes f
            JOIN transportadores t ON t.id = f.transportador_id
            JOIN enderecos o ON o.id = f.origem_id
            JOIN enderecos d ON d.id = f.destino_id
            JOIN frete_produtos fp ON fp.frete_id = f.id
            JOIN produtos p ON p.id = fp.produto_id
            WHERE f.data_frete = ?
            ORDER BY f.id, p.nome";
    $st = $pdo->prepare($sql);
    $st->execute([$data]);
    return $st->fetchAll();
}
