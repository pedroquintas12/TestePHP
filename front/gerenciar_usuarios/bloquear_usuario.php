<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_POST["usuario_id"];

    // Atualize o estado de bloqueio no banco de dados
    $sql = "UPDATE projetophp.medicos SET bloqueado = 1 WHERE id = $usuario_id";
    mysqli_query($conn, $sql);

    // Redirecione de volta para a página de gerenciamento de usuários
    header("Location: usuarios.php");
    exit();
}
