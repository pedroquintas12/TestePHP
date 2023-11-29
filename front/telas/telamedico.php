<?php
session_start();

// Função para verificar se o usuário está logado
function verificarLogin() {
    if (!isset($_SESSION['id_medico'])) {
        header("Location: ../../front/login_cadastro/login.php"); // Redirecionar para a página de login se o usuário não estiver logado
        exit();
    }
}

// Função para verificar as permissões do usuário
function verificarPermissao($tipo_permitido) {
    if ($_SESSION['tipo_usuario'] !== $tipo_permitido) {
        echo "Você não tem permissão para acessar esta página.";
        exit();
    }
}

// Verificar se o usuário está logado
verificarLogin();

// Verificar se o usuário é um paciente
verificarPermissao('medico');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Seu código de cabeçalho aqui -->
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Pacientes e Prontuários</h1>
            <div class="columns">
                <div class="column is-one-third">
                    <?php include "consultas_agendadas.php"; ?>
                </div>
            </div>
        </div>
    </section>
    <script>
        function salvarProntuario(idTextarea) {
            const prontuario = document.getElementById(idTextarea).value;
            localStorage.setItem(idTextarea, prontuario);
            alert('Prontuário salvo com sucesso!');
        }

        function prontuariosalvo() {
            window.location.href = "prontuario.html"
        }
    </script>
</body>
</html>
