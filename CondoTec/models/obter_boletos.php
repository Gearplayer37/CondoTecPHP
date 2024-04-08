<?php
// Inclua o arquivo de configuração do banco de dados
require_once 'C:/xampp/htdocs/aulas/CondoTec/models/conexao.php';

// Conecte-se ao banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Consulta SQL para selecionar os boletos
$query = $pdo->query("SELECT * FROM boletos");

// Inicialize um array para armazenar os boletos
$boletos = array();

// Loop através dos resultados da consulta e adicione cada boleto ao array
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $boletos[] = $row;
}

// Retorna os boletos em formato JSON
echo json_encode($boletos);
?>
