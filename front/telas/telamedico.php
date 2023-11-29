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

$id_medico = $_SESSION['id_medico'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela do Médico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Pacientes e Prontuários</h1>
            <div class="columns">
                <div class="column is-one-third">
                    <?php
                    include "../../../front/conexao.php";

                    $sql = "SELECT c.id, c.horario, p.nome_completo AS nome_paciente, m.nomeSobrenome AS nome_medico
                            FROM projetophp.agendamentos AS c
                            INNER JOIN projetophp.pacientes AS p ON c.paciente_id = p.id_paciente
                            INNER JOIN projetophp.medicos AS m ON c.medico_id = m.id_medico where medico_id = $id_medico ";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='box'>";
                            echo "<h2 class='subtitle'>Consulta #" . $row['id'] . ": " . $row['nome_paciente'] . "</h2>";
                            echo "<p>Horário: " . $row['horario'] . "</p>";
                            echo "<p>Atendido pelo Dr. " . $row['nome_medico'] . "</p>";
                            echo "<p>Prontuário:</p>";
                            echo "<div class='content' name='prontuario'>";
                            echo "<textarea class='textarea' placeholder='Editar Prontuário do " . $row['nome_paciente'] . "...'></textarea>";
                            echo "<button onclick='prontuariosalvo()'>Visualizar Prontuário</button>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Não há consultas agendadas.</p>";
                    }

                    $conn->close();
                    ?>
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
            window.location.href = "prontuario.html";
        }
    </script>
</body>
</html>
