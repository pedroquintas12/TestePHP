<?php
include "conexao.php";
// Recupere os dados do formulário
$nomeCompleto = $_GET['nomecompleto'];
$email = $_POST['email'];
$numeroTelefone = $_POST['numero'];
$endereco = $_POST['endereco'];
$nomeUsuario = $_POST['usuario'];

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifique se o nome de usuário já existe
$sqlVerificaUsuario = "SELECT * FROM projetophp.usuarios WHERE nome_usuario = '$nomeUsuario'";
$resultUsuario = $conn->query($sqlVerificaUsuario);

if ($resultUsuario->num_rows > 0) {
    echo "Nome de usuário já existe. Escolha outro.";
    $conn->close();
    exit();
}

// Insira os dados no banco de dados
$sqlInserirUsuario = "INSERT INTO projetophp.usuarios (nome_completo, email, numero_telefone, endereco, nome_usuario) 
                      VALUES ('$nomeCompleto', '$email', '$numeroTelefone', '$endereco', '$nomeUsuario')";

if ($conn->query($sqlInserirUsuario) === TRUE) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>
