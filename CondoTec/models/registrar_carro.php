<?php
session_start(); // Inicializa a sessão

require_once 'C:/xampp/htdocs/aulas/CondoTec/models/conexao.php';

$conexao = new Conexao();
$pdo = $conexao->conectar();

// Inicializa as variáveis de mensagem
$mensagem_sucesso = '';
$mensagem_erro = '';

// Verifica se os dados do carro foram enviados via POST
if(isset($_POST['marca']) && isset($_POST['modelo']) && isset($_POST['cor']) && isset($_POST['placa'])) {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $cor = $_POST['cor'];
    $placa = $_POST['placa'];
    
    // Obtém o ID do usuário logado
    $id_usuario = $_SESSION['id'];

    // Tenta inserir o novo carro na garagem
    try {
        $query = $pdo->prepare("INSERT INTO carros_garagem (marca, modelo, cor, placa, usuario_id) VALUES (:marca, :modelo, :cor, :placa, :usuario_id)");
        $query->bindParam(':marca', $marca);
        $query->bindParam(':modelo', $modelo);
        $query->bindParam(':cor', $cor);
        $query->bindParam(':placa', $placa);
        $query->bindParam(':usuario_id', $id_usuario);

        $query->execute();
        
        // Verifica se a inserção foi bem-sucedida antes de exibir a mensagem
        if ($query->rowCount() > 0) {
            $mensagem_sucesso = "Carro registrado na garagem com sucesso.";
        } else {
            $mensagem_erro = "Erro ao registrar o carro na garagem.";
        }
    } catch(PDOException $e) {
        // Captura a exceção e exibe uma mensagem de erro amigável
        if ($e->getCode() == '45000') {
            $mensagem_erro = "Você já possui o limite máximo de carros registrados na garagem.";
        } else {
            $mensagem_erro = "Erro ao registrar o carro na garagem: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Registrar Carro</title>
    <link rel="stylesheet" href="../assets/estilo.css">
</head>
<body>
    <header id="topo">
        <div class="margem_topo">
            <img src="../assets/img/condominio1.png" width="150" height="150"/>
            <h1>Condo<strong class="branco">TEC</strong> </h1>
        </div>
    </header>
    <div class="col-md-9"> 
        <div class="container pagina">
            <div class="row">
                <div class="col">
                <h2>Registrar Carro</h2>
    
                <!-- Exibir mensagens de sucesso ou erro, se houver -->
                <?php if(!empty($mensagem_sucesso)): ?>
                    <div class="mensagem sucesso"><?php echo $mensagem_sucesso; ?></div>
                <?php endif; ?>
                
                <?php if(!empty($mensagem_erro)): ?>
                    <div class="mensagem erro"><?php echo $mensagem_erro; ?></div>
                <?php endif; ?>
    
                <!-- Botão para voltar -->
                <button onclick="window.location.href = '../views/home.php';">Voltar</button>  
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <div id="roda">
            &copy;Politicas,Central de agendamentos, Redes Sociais, Trabalhe conosco - Todos direitos reservados - CondoTec
        </div>
    </footer>
</body>
</html>
