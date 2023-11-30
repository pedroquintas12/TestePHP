<?php
session_start();

// Função para verificar se o usuário está logado
function verificarLogin() {
    if (!isset($_SESSION['id_paciente'])) {
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
verificarPermissao('paciente');

$id_paciente = $_SESSION['id_paciente'];

include "../../../front/conexao.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Atendimento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="telamedico.css"> <!-- Importe seu arquivo de estilo CSS, se houver -->
    <style>
        /* Adicione estilos adicionais conforme necessário */
        .card {
            margin-bottom: 20px;
        }

        .subtitle {
            font-size: 1.5rem;
        }

        .prontuario {
            white-space: pre-line;
        }
    </style>
</head>
<body>

    <section class="section">
        <div class="container">
            <h1 class="title">Detalhes do Atendimento</h1>

            <?php
            // Recupera os detalhes dos atendimentos
            $sqlDetalhes = "SELECT m.nomeSobrenome AS nome_medico, m.especialidade, m.endereco_de_trabalho AS local_atendimento,
                             c.horario, c.prontuario, c.id, c.tempo_consulta
                            FROM projetophp.agendamentos AS c
                            INNER JOIN projetophp.medicos AS m ON c.medico_id = m.id_medico
                            WHERE c.paciente_id = $id_paciente";

            $resultDetalhes = $conn->query($sqlDetalhes);

            if ($resultDetalhes->num_rows > 0) {
                $consultaAnterior = null;

                while ($rowDetalhes = $resultDetalhes->fetch_assoc()) {
                    $nome_medico = $rowDetalhes['nome_medico'];
                    $especialidade = $rowDetalhes['especialidade'];
                    $local_atendimento = $rowDetalhes['local_atendimento'];
                    $horario_atendimento = $rowDetalhes['horario'];
                    $tempo_consulta = $rowDetalhes ['tempo_consulta'];
                    $prontuario_medico = $rowDetalhes['prontuario'];
                    $id_consulta = $rowDetalhes['id'];

                    // Verifica se mudou o número da consulta
                    if ($id_consulta != $consultaAnterior) {
                        if ($consultaAnterior !== null) {
                            echo "</div>"; // Fecha a div anterior se não for a primeira consulta
                        }

                        echo "<div class='card'>"; // Abre uma nova div para a consulta
                        $consultaAnterior = $id_consulta;
                    }
            ?>

                    <div class="card-content">
                        <div class="content">
                            <h1>CONSULTA <?php echo $id_consulta ?></h1>
                            <p><strong>Médico:</strong> Dr. <?php echo $nome_medico; ?></p>
                            <p><strong>Especialidade:</strong> <?php echo $especialidade; ?></p>
                            <p><strong>Local:</strong> <?php echo $local_atendimento; ?></p>
                            <p><strong>Horário:</strong> <?php echo $horario_atendimento; ?></p>
                         <?php echo  "<p><strong>Tempo de consulta: </strong>". gmdate("H:i:s", $tempo_consulta) . "</p>"?>

                        </div>
                    </div>

                    <div class="card-content">
                        <div class="content">
                            <h2 class="subtitle">Prontuário</h2>
                            <p class="prontuario"><?php echo $prontuario_medico; ?></p>
                        </div>
                    </div>

            <?php
                }

                echo "</div>"; // Fecha a última div
            } else {
                // Redireciona se não houver detalhes do atendimento
                header("Location: telapaciente.php");
                exit();
            }
            ?>
        </div>
    </section>

</body>
</html>

<?php
$conn->close();
?>
