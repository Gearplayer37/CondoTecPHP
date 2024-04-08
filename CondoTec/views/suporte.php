<?php
session_start();
require_once('../models/conexao.php');
require_once('../models/suporte_crud.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['nomeUsuario'])) {
    // Se não estiver logado, redireciona de volta para a página de login
    header("Location: ../models/login.php");
    exit();
}

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Obtém o ID do usuário logado
$id_usuario = $_SESSION['id'];

// Consulta para obter o número do apartamento do usuário logado
$query = $pdo->prepare("SELECT numero_apartamento FROM apartamentos WHERE id = :id");
$query->bindParam(':id', $id_usuario);
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

// Verifica se a consulta retornou algum resultado
if ($resultado) {
    $numero_apartamento = $resultado['numero_apartamento'];
} else {
    $numero_apartamento = "Número de apartamento não registrado";
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Cria uma instância da classe Suporte e preenche os atributos
    $suporte = new Suporte();
    $suporte->__set('categoria', $_POST['categoria']);
    $suporte->__set('informacao', $_POST['informacao']);
    $suporte->__set('descricao', $_POST['descricao']);
    $suporte->__set('carater', $_POST['carater']);

    // Cria uma instância do Suporte_crud para inserir os dados
    $suporte_crud = new Suporte_crud($conexao, $suporte);
    $suporte_crud->inserir();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="stylesheet" href="../assets/estilo.css">
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
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
                        <li class="list-group-item active" onclick="window.location.href='suporte.php'">Suporte</li>
                        <li class="list-group-item" onclick="window.location.href='visualizar_sup.php'">Visualizar Suporte</li>
                        <li class="list-group-item" onclick="window.location.href='garagem.php'">Cadastre seu carro</li>
                        <li class="list-group-item" onclick="window.location.href = 'mostrar_carros.php'">Ver Meus Carros</li>
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
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div>
                                        <h3>Solicitado por <?php echo $_SESSION['nomeUsuario']; ?> Apartamento: <?php echo $numero_apartamento; ?> </h3>
                                        <h4>Número de registro: <?php echo $_SESSION['id']; ?></h4>
                                    </div>
                                    <h3>Categoria</h3>
                                    <select name="categoria" class="cadastro_caixa">
                                        <option></option>
                                        <option>Água</option>
                                        <option>Eletricidade</option>
                                        <option>Garagem</option>
                                        <option>Manutenção</option>
                                        <option>Salão</option>
                                    </select>
                                    <br/>
                                    <h3>Informe sobre o que se trata</h3>
                                    <div class="cadastro_caixa">
                                        <input class="cadastro_texto" name="informacao" placeholder="Informação...">
                                    </div>
                                    <br/>
                                    <h3>Descrição</h3>
                                    <div class="cadastro_caixa">
                                        <textarea class="cadastro_texto" name="descricao" placeholder="Informe seu problema..."></textarea>
                                    </div>
                                    <br/>
                                    <h3>Carater</h3>
                                    <select name="carater" class="cadastro_caixa">
                                        <option></option>
                                        <option>Normal</option>
                                        <option>Urgencia</option>
                                    </select>
                                    <br/><br/>
                                    <button type="submit">Registrar</button>
                                </form>
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
