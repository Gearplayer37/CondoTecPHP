<?php
session_start(); // Inicializa a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['nomeUsuario'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: ../models/login.php");
    exit();
}

require_once('../models/conexao.php');

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Obtém o ID do usuário logado
$id_usuario = $_SESSION['id'];

// Consulta para obter os carros registrados pelo usuário
$query = $pdo->prepare("SELECT * FROM carros_garagem WHERE usuario_id = :id_usuario");
$query->bindParam(':id_usuario', $id_usuario);
$query->execute();
$carros = $query->fetchAll(PDO::FETCH_ASSOC);

// Verifica se houve algum erro na consulta
if (!$carros) {
    $mensagem_erro = "Não foi possível recuperar os carros registrados.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Carros</title>
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
    <link rel="stylesheet" href="../assets/estilo.css"> <!-- Arquivo CSS para estilos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <style>
        .menu {
            position: fixed;
            top: 210px; 
            bottom: 45px; 
            left: 0;
            overflow-y: auto;
            padding-right: 15px;
        }

        .conteudo {
            margin-left: 250px;
            padding-top: 20px; /* Altura do header */
            padding-bottom: 20px; /* Altura do footer */
            padding-left: 15px; /* Compensação de margem do Bootstrap */
        }
    </style>
</head>
<body>
    <header id="topo">
        <div class="margem_topo">
            <img src="../assets/img/condominio1.png" width="150" height="150"/>
            <h1>Condo<strong class="branco">TEC</strong> </h1>
        </div>
    </header>
    <div class="container app">
        <div class="row">
            <div class="col-md-3 menu list-group-item">
                <ul class="list-group">
                        <li class="list-group-item" onclick="window.location.href='suporte.php'">Suporte</li>
                        <li class="list-group-item" onclick="window.location.href='visualizar_sup.php'">Visualizar Suporte</li>
                        <li class="list-group-item" onclick="window.location.href='garagem.php'">Cadastre seu carro</li>
                        <li class="list-group-item active" onclick="window.location.href = 'mostrar_carros.php'">Ver Meus Carros</li>
                        <li class="list-group-item" onclick="window.location.href='../views/home.php';">Home</li>
                    <br/>
                    <br/>
                    <form action="../models/logoff.php" method="post">
                        <button type="submit">Sair</button>
                    </form>
                </ul>
            </div>
            <div class="container conteudo">
                <div class="col-md-9" style="margin-left: 200px;">
                    <div class="container pagina">
                        <div class="row">
                            <div class="col">
                                <h1>Meus Carros Registrados</h1>
                                <?php if (isset($mensagem_erro)): ?>
                                    <p><?php echo $mensagem_erro; ?></p>
                                <?php else: ?>
                                    <div class="car-list">
                                        <?php foreach ($carros as $carro): ?>
                                            <div class="car">
                                                <h2><?php echo $carro['marca'] . ' ' . $carro['modelo']; ?></h2>
                                                <p>Cor: <?php echo $carro['cor']; ?></p>
                                                <p>Placa: <?php echo $carro['placa']; ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
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
