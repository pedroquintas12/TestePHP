<?php
include "../../../front/conexao.php";

// Verifica se há consultas agendadas
$sql = "SELECT c.id, c.horario, p.nome_completo AS nome_paciente, m.nomeSobrenome AS nome_medico
FROM projetophp.agendamentos AS c
INNER JOIN projetophp.pacientes AS p ON c.paciente_id = p.id_paciente
INNER JOIN projetophp.medicos AS m ON c.medico_id = m.id_medico;"; // Somente consultas futuras

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