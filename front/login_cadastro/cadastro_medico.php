<?php
include "../../../front/conexao.php";
// Capturar os dados do formulário
if(isset($_POST['submit'])){
$nomesobrenome = $_POST['nomesobrenome'];
$email = $_POST['email'];
$numero = $_POST['numero'];
$localtrabalho = $_POST['localtrabalho'];
$crm = $_POST['crm'];
$especializacao = $_POST['especializacao'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

if ($conn->connect_error) {
  die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifique se o nome de usuário já existe
$sqlVerificaUsuario = "SELECT * FROM projetophp.medicos WHERE nome_usuario = '$usuario'";
$resultUsuario = $conn->query($sqlVerificaUsuario);

if ($resultUsuario->num_rows > 0) {
    echo "Nome de usuário já existe. Escolha outro.";
    $conn->close();
    exit();
}

// Preparar a instrução SQL para inserir os dados no banco de dados
$sql = "INSERT INTO projetophp.medicos (nomeSobrenome , email, numero_telefone, endereco_de_trabalho, crm, nome_usuario, senha, especialidade)
        VALUES ('$nomesobrenome', '$email', '$numero', '$localtrabalho', '$crm', '$usuario', '$senha','$especializacao' )";

// Executar a instrução SQL
if ($conn->query($sql) === TRUE) {
  header("Location: ../../front/login_cadastro/login_medico.php");
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Cadastro para Médicos</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="cadastro.css">
</head>
<body>
<form action="cadastro_medico.php" method="post">
  <div class="container cadastro-container">
    <h1 class="title has-text-centered">Cadastro de Médico</h1>
    <div class="field">
      <label class="nomecompleto">Nome e Sobrenome</label>
      <div class="control">
        <input class="input" type="text" name="nomesobrenome" placeholder="Seu nome e Sobrenome">
      </div>
    </div>

    <div class="field">
      <label class="email">E-mail</label>
      <div class="control">
        <input class="input" type="email" name="email" placeholder="Seu e-mail">
      </div>
    </div>

    <div class="field">
      <label class="numero">Número de Telefone</label>
      <div class="control">
        <input class="input" type="tel" name="numero" placeholder="Seu número de telefone">
      </div>
    </div>

    <div class="field">
      <label class="localtrabalho">Local de Trabalho</label>
      <div class="control">
        <input class="input" type="text" name="localtrabalho" placeholder="Seu local de trabalho">
      </div>
    </div>

    <div class="field">
      <label class="crm">CRM (Registro Médico)</label>
      <div class="control">
        <input class="input" type="text" name="crm" placeholder="Seu número de CRM">
      </div>
    </div>

    <div class="field">
      <label class="especificacao">Especialização</label>
      <div class="control">
        <div class="select is-fullwidth">
          <select name="especializacao">
            <option value="clinico">Clínico Geral</option>
            <option value="pediatra">Pediatra</option>
            <option value="cardiologista">Cardiologista</option>
            <!-- Adicione mais opções conforme necessário -->
          </select>
        </div>
      </div>
    </div>

    <div class="field">
      <label class="usuario">Nome de Usuário</label>
      <div class="control">
        <input class="input" type="text" name="usuario" placeholder="Seu nome de usuário">
      </div>
    </div>

    <div class="field">
      <label class="senha">Insira uma Senha</label>
      <div class="control">
        <input class="input" type="password" name="senha" placeholder="Sua Senha de acesso">
      </div>
    </div>

    <div class="field">
      <div class="control">
        <button class="button is-primary is-fullwidth" type="submit" name="submit">Finalizar</button>
      </div>
    </div>
  </div>
</form>
<script src="cadastro.js"></script>
</body>
</html>
