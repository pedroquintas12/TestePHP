<?php
include "conexao.php";

if (isset($_POST['submit'])) {
    $nomeUsuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Consulta para verificar se o nome de usuário e a senha correspondem
    $sqlVerificaLogin = "SELECT * FROM projetophp.medicos WHERE nome_usuario = '$nomeUsuario' AND senha = '$senha'";
    $resultLogin = $conn->query($sqlVerificaLogin);

    if ($resultLogin->num_rows > 0) {
        print_r( "Login bem-sucedido!");
    } else {
      print_r( "nome de usuario ou senha incorretos!");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="login.css">
</head>
<body>
<form action="login_medico.php" method="post">
  <div class="container login-container">
    <h1 class="title has-text-centered">Login medicos</h1>
    <div class="field"> 
      <label class="label">Usuario</label>
      <div class="control">
        <input class="input" type="text" name="usuario" placeholder="Seu usuario">
      </div>
    </div>

    <div class="field">
      <label class="label">Senha</label>
      <div class="control">
        <input class="input" type="password" name="senha" placeholder="Sua senha">
      </div>
    </div>

    <div class="field">
      <div class="control">
        <button class="button is-primary is-fullwidth" name="submit" type="submit" >Entrar</button>
      </div>
    </div>

    <p class="has-text-centered">Não tem uma conta? <a href="cadastro_medico.php">Cadastre-se</a></p>
  </div>
</form>
  <script src="login.js"></script>
</body>
</html>
