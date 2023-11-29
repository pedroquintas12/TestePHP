<?php
include "../../../front/conexao.php";

if (isset($_POST['submit'])) {
    $nomeUsuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Consulta para verificar se o nome de usuário e a senha correspondem
    $sqlVerificaLogin = "SELECT * FROM projetophp.medicos WHERE nome_usuario = '$nomeUsuario' AND senha = '$senha'";
    $resultLogin = $conn->query($sqlVerificaLogin);

    if ($resultLogin->num_rows > 0) {
        $row = $resultLogin->fetch_assoc();

        // Iniciar a sessão e definir variáveis de sessão
        session_start();
       // Verificar se o usuário é um administrador
    if ($nomeUsuario == 'ADMIN') {
      $_SESSION['tipo_usuario'] = 'ADMIN';
      header("Location: ../../front/gerenciar_usuarios/usuarios.php");
  } else {
      $_SESSION['id_medico'] = $row['id_medico'];
      $_SESSION['tipo_usuario'] = 'medico';
      header("Location: ../../front/telas/telamedico.php");
}
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
