<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro de Carros na Garagem</title>
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
                        <li class="list-group-item active" onclick="window.location.href='garagem.php'">Cadastre seu carro</li>
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
                                <h1>Cadastro de Carros na Garagem</h1>
                                <form action="../models/registrar_carro.php" method="post">
                                    <div class="cadastro_caixa">
                                        <input class="cadastro_texto" type="text" id="marca" name="marca" placeholder="Marca" required>
                                    </div>
                                    <div class="cadastro_caixa">
                                        <input class="cadastro_texto" type="text" id="modelo" name="modelo" placeholder="Modelo" required>
                                    </div>
                                    <div class="cadastro_caixa">
                                        <input class="cadastro_texto" type="text" id="cor" name="cor" placeholder="Cor" required>
                                    </div>
                                    <div class="cadastro_caixa">
                                        <input class="cadastro_texto" type="text" id="placa" name="placa" placeholder="Placa" required>
                                    </div>
                                    <div >
                                        <button class="bnt_fazerCadastro2" type="submit">Registrar Carro</button>
                                    </div>
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
