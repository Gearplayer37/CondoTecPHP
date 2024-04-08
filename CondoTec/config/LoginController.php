<?php

require_once('C:/xampp/htdocs/aulas/CondoTec/models/conexao.php');

class LoginController
{
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $password = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            // Check if any of the fields are empty
            if (empty($nome) || empty($email) || empty($password) || empty($confirmar_senha)) {
                echo "Please fill in all fields.";
                return;
            }

            // Optionally, check if the passwords match
            if ($password !== $confirmar_senha) {
                echo "Passwords do not match.";
                return;
            }

            $this->addUser($nome, $email, $password);
        }
    }

    public function addUser($nome, $email, $password)
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $password);

        if ($stmt->execute()) {
            echo "User added successfully";
        } else {
            echo "Error adding user";
        }
    }
}

?>
