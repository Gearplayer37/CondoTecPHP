<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="stylesheet" href="../assets/estilo.css">
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
</head>
<body>
    <div class="margem">
        <div class="caixa_geral">
            <h1>Fazer Login</h1>
            <form action="../models/login.php" method="post">
                <div class="cadastro_caixa">
                    <input name="email" type="email" class="cadastro_texto" placeholder="E-mail" required>
                </div>
                <div class="cadastro_caixa">
                    <input id="senha" name="senha" type="password" class="cadastro_texto" placeholder="Senha" required>
                    <button type="button" id="togglePasswordVisibility" class="mostrar_senha">
                        <span class="aberto"></span>
                        <span class="fechado"></span>
                    </button>
                </div>
                <?php if (isset($_GET['login']) && $_GET['login'] == 'erro') {?>
                <div class="text-danger">
                    Usuário ou senha inválidos
                </div>
                <?php } ?>
                <button type="submit" class="bnt_cadastro">Entrar</button>
                <br/><br/>
                <h3>Não possui cadastro?</h3>
                <button onclick="window.location.href='cadastrar.php'" class="bnt_fazerCadastro">Novo Cadastro</button>
            </form>
        </div>
    </div>
    <footer>
        <div id="roda">
            &copy;Politicas,Central de agendamentos, Redes Sociais, Trabalhe conosco - Todos direitos reservados - CondoTec
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePasswordButton = document.getElementById('togglePasswordVisibility');
            const passwordInput = document.getElementById('senha');

            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Alterna a classe 'visible' no botão de alternância
                this.classList.toggle('visible');
            });
        });
    </script>
</body>
</html>
