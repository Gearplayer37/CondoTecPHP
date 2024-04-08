<?php
session_start(); // Inicializa a sessão

require_once('C:/xampp/htdocs/aulas/CondoTec/models/conexao.php');

$conexao = new Conexao();
$pdo = $conexao->conectar();

if(isset($_POST['numero_apartamento'])) {
    $numero_apartamento = $_POST['numero_apartamento'];
    
    // Check if 'idUsuario' is set in the session
    if (!isset($_SESSION['id'])) {
        echo "Erro: 'idUsuario' não está definido na sessão.";
        exit;
    }
    $id_usuario = $_SESSION['id'];

    // Verifica se o número do apartamento já está em uso por qualquer usuário
    $check = $pdo->prepare("SELECT * FROM apartamentos WHERE numero_apartamento = :numero_apartamento");
    $check->bindParam(':numero_apartamento', $numero_apartamento);
    $check->execute();

    if($check->rowCount() > 0) {
        echo "Este número de apartamento já está em uso.";
    } else {
        // Insere o número do apartamento na tabela
        $query = $pdo->prepare("INSERT INTO apartamentos (id, numero_apartamento) VALUES (:id, :numero_apartamento)");
        $query->bindParam(':id', $id_usuario);
        $query->bindParam(':numero_apartamento', $numero_apartamento);

        if($query->execute()) {
            echo "Número do apartamento registrado com sucesso.";

            // Redireciona o usuário de volta para a página inicial
            header("Location: ../views/home.php");
            exit();
        } else {
            echo "Erro ao registrar o número do apartamento: " . $pdo->errorInfo()[2];
        }
    }
}
?>