<?php
include "../../../front/conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar os dados enviados pela solicitação AJAX
    $medico = $_POST['medico'];
    $horario = $_POST['horario'];
    $idPaciente = $_POST['idPaciente']; // Supondo que você tenha o ID do paciente disponível
    $idMedico = $_POST['idMedico']; // Supondo que você tenha o ID do médico disponível

    // Realizar a inserção no banco de dados
    $sqlInserirConsulta = "INSERT INTO projetophp.agendamentos (id_medico, id_paciente, horario) VALUES ($idMedico, $idPaciente, '$horario')";

    if (mysqli_query($conn, $sqlInserirConsulta)) {
        echo 'Consulta agendada com sucesso!';
    } else {
        echo 'Erro ao agendar consulta: ' . mysqli_error($conn);
    }
} else {
    // Responder caso alguém tente acessar diretamente este arquivo PHP
    echo 'Acesso não autorizado.';
}
?>
