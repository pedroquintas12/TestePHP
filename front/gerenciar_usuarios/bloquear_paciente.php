<?php
include "../../../front/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_POST["usuario_id"];

    // Atualize o estado de bloqueio no banco de dados
    $sql = "UPDATE projetophp.pacientes SET bloqueado = 1 WHERE id_paciente = $usuario_id";
    mysqli_query($conn, $sql);

    // Redirecione de volta para a página de gerenciamento de usuários
    header("Location: usuarios.php");
    exit();
}
