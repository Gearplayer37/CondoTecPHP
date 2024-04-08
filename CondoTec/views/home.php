<?php
session_start();
require_once('../models/conexao.php');

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
$id_usuario = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Consulta para obter o número do apartamento do usuário logado
$query = $pdo->prepare("SELECT numero_apartamento FROM apartamentos WHERE id = :id");
$query->bindParam(':id', $id_usuario);
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

// Verifica se a consulta retornou algum resultado
if ($resultado && isset($resultado['numero_apartamento'])) {
    $numero_apartamento = $resultado['numero_apartamento'];
} else {
    $numero_apartamento = "Número de apartamento não registrado";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
    <link rel="stylesheet" href="../assets/estilo.css">
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
            padding-top: 20px; 
            padding-bottom: 20px; 
            padding-left: 15px; 
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
                        <li class="list-group-item" onclick="window.location.href = 'mostrar_carros.php'">Ver Meus Carros</li>
                        <li class="list-group-item active" onclick="window.location.href='../views/home.php';">Home</li>
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
                                <h1>Bem vindo, <?php echo isset($_SESSION['nomeUsuario']) ? $_SESSION['nomeUsuario'] : 'Usuário'; ?> apartamento: <?php echo isset($numero_apartamento) ? $numero_apartamento : ''; ?> </h1>
                                <h2>Número de registro: <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?></h2>
                                <div class="list-group">
                                    <li class="list-group-item" id="btnVisualizarBoletos">Visualizar Boletos</li>

                                </div>
                                <div id="listaBoletos"></div>

                                <div class="list-group-item">
                                
                                    <?php if (isset($numero_apartamento) && $numero_apartamento == "Número de apartamento não registrado"): ?>
                                    <!-- Mostrar o formulário de registro apenas se o usuário ainda não tiver registrado um apartamento -->
                                    <form action="../models/registrar_ap.php" method="post">
                                    <h4>Ainda não registrou o número do apartamento?</h4>
                                        <div class="cadastro_caixa2">
                                            <input name="numero_apartamento" class="cadastro_texto" placeholder="insira o número aqui">
                                        </div>
                                        <div>
                                            <button type="submit" class="bnt_fazerCadastro">Registrar</button>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script>
    var boletosVisiveis = false; // Variável para controlar o estado de exibição dos boletos

    document.getElementById('btnVisualizarBoletos').addEventListener('click', function() {
        boletosVisiveis = !boletosVisiveis; // Alternar entre true e false ao clicar
        if (boletosVisiveis) {
            obterBoletos(); // Chamar a função para obter os boletos apenas se eles devem ser exibidos
        } else {
            document.getElementById('listaBoletos').innerHTML = ''; // Limpar a lista de boletos ao ocultar
        }
    });

    function obterBoletos() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../models/obter_boletos.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var boletos = JSON.parse(xhr.responseText);
                exibirBoletos(boletos);
            }
        };
        xhr.send();
    }

    function exibirBoletos(boletos) {
        var listaBoletos = document.getElementById('listaBoletos');
        listaBoletos.innerHTML = ''; // Limpa o conteúdo anterior
        for (var i = 0; i < boletos.length; i++) {
            var boleto = boletos[i];
            var dataPagamento = boleto.data_pagamento ? ' - Pagamento: ' + boleto.data_pagamento : ''; // Verifica se há data de pagamento
            listaBoletos.innerHTML += '<p>' + boleto.nome_pagador + ' - R$ ' + boleto.valor + ' - ' + boleto.status + ' - Vencimento: ' + boleto.data_vencimento + dataPagamento + '</p>';
        }
    }
</script>
<footer>
    <div id="roda">
        &copy;Politicas,Central de agendamentos, Redes Sociais, Trabalhe conosco - Todos direitos reservados - CondoTec
    </div>
</footer>
</body>
</html>
