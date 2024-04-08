<?php
// Verifica se os campos estão vazios
if (empty($_POST['email']) || empty($_POST['senha'])) {
    // Redireciona de volta para index.php com um parâmetro GET indicando erro
    header("Location: ../index.php?login=erro");
    exit(); // Termina a execução do script após o redirecionamento
}

// Conecta ao banco de dados
require_once 'C:/xampp/htdocs/aulas/CondoTec/models/conexao.php';
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Obtém as credenciais do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta SQL para verificar as credenciais
$sql = "SELECT id, nome FROM usuarios WHERE email = :email AND senha = :senha";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha);
$stmt->execute();

// Verifica se encontrou um usuário com as credenciais fornecidas
if ($stmt->rowCount() > 0) {
    // Obtém o nome do usuário
    $row = $stmt->fetch();
    $nomeUsuario = $row['nome'];
    $id = $row['id'];
    
    // Inicia a sessão e armazena o nome do usuário
    session_start();
    $_SESSION['nomeUsuario'] = $nomeUsuario;
    $_SESSION['id'] = $id;
    // Redireciona para a página home
    header("Location: ../views/home.php");
    exit();
} else {
    // Redireciona de volta para a página de login com um parâmetro de erro
    header("Location: ../index.php?login=erro");
    exit();
}
?>
