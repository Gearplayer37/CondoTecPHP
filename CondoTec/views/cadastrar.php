<?php
// Inclua o arquivo que contém a definição da classe LoginController
require_once 'C:/xampp/htdocs/aulas/CondoTec/config/LoginController.php';

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Cria uma instância do LoginController para lidar com o cadastro
    $loginController = new LoginController();
    // Aqui você pode manipular os dados do formulário se necessário
}
?>

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
            <h1>Fazer Cadastro</h1>
            <form action="" method="post">
                <div class="cadastro_caixa">
                    <input name="nome" type="text" class="cadastro_texto" placeholder="Nome" required>
                </div>
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
                <div class="cadastro_caixa">
                    <input id="confirmar_senha" name="confirmar_senha" type="password" class="cadastro_texto" placeholder="Confirmar senha" required>
                    <button type="button" id="toggleConfirmPasswordVisibility" class="mostrar_senha">
                        <span class="aberto"></span>
                        <span class="fechado"></span>
                    </button>
                </div>
                <button type="submit" class="bnt_cadastro">Cadastrar</button>
            </form>
            <button onclick="window.location.href='index.php'" class="bnt_fazerCadastro">Voltar</button>
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
            const toggleConfirmPasswordButton = document.getElementById('toggleConfirmPasswordVisibility');
            const confirmPasswordInput = document.getElementById('confirmar_senha');

            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Alterna a classe 'visible' no botão de alternância
                this.classList.toggle('visible');
            });

            toggleConfirmPasswordButton.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);

                // Alterna a classe 'visible' no botão de alternância
                this.classList.toggle('visible');
            });
        });
    </script>
</body>
</html>
