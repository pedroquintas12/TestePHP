<?php
include "../../../front/conexao.php";
session_start();

$horario = $_POST['horario'];
$idPaciente = $_SESSION['id_paciente'];
$id_medico = isset($_POST['id_medico']) ? $_POST['id_medico'] : null;

if ($id_medico === null) {
    echo "Erro ao agendar: Id do médico não definido.";
} else {
    // Verificar se o horário está disponível
    $sql = "SELECT id FROM projetophp.agendamentos WHERE horario = '$horario' AND disponivel = true";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Horário já agendado, faça o tratamento adequado (ex: exiba uma mensagem de erro)
        $message = "Horário já agendado. Escolha outro horário.";
    } else {
        // Horário disponível, agendar
        $sql = "INSERT INTO projetophp.agendamentos (medico_id, paciente_id, horario, disponivel) VALUES ('$id_medico', '$idPaciente', '$horario', false)";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Agendamento realizado com sucesso!";
        } else {
            $message = "Erro ao agendar: " . $conn->error;
        }
    }
}

header("Location: telapaciente.php?message=" . urlencode($message));
exit();
?>
