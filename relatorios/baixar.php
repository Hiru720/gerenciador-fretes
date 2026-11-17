<?php
// Gera o arquivo CSV (abre no Excel) com os fretes do dia escolhido
require_once __DIR__ . '/../includes/init.php';

$data = $_GET['data'] ?? '';
if (!DateTime::createFromFormat('Y-m-d', $data)) {
    flash('danger', 'Escolha uma data válida.');
    redirecionar('/relatorios/index.php');
}

$linhas = linhasRelatorio($pdo, $data);

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="relatorio_fretes_' . $data . '.csv"');

echo "\xEF\xBB\xBF"; // para o Excel entender os acentos
$saida = fopen('php://output', 'w');

fputcsv($saida, ['Frete', 'Data', 'Transportador', 'Placa', 'Origem', 'Destino', 'Produto', 'Quantidade', 'Peso unit. (kg)', 'Valor unit. (R$)'], ';', '"', '\\');

foreach ($linhas as $l) {
    fputcsv($saida, [
        $l['frete'],
        dataBR($l['data_frete']),
        $l['transportador'],
        $l['placa'],
        $l['origem'],
        $l['destino'],
        $l['produto'],
        $l['quantidade'],
        number_format($l['peso'], 2, ',', ''),
        number_format($l['valor'], 2, ',', ''),
    ], ';', '"', '\\');
}

fclose($saida);
exit;
