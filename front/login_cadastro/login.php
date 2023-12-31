<?php
include "../../../front/conexao.php";

// Função para adicionar mensagens de erro à sessão
function addError($message) {
    $_SESSION['errors'][] = "<span style='color: red;'>$message</span>";
}

if (isset($_POST['submit'])) {
    $nomeUsuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Iniciar a sessão e definir variáveis de sessão
    session_start();

    // Validar o nome de usuário
    if (empty($nomeUsuario)) {
        addError("Por favor, preencha o campo Nome de Usuário.");
    }

    // Validar a senha
    if (empty($senha)) {
        addError("Por favor, preencha o campo Senha.");
    }

    // Verificar se há erros na validação
    if (!empty($_SESSION['errors'])) {
        // Se houver erros, exibir as mensagens de erro no local apropriado no formulário
        echo "<div class='errors'>";
        foreach ($_SESSION['errors'] as $error) {
            echo $error . "<br>";
        }
        echo "</div>";
        unset($_SESSION['errors']); // Remover a variável 'errors' da sessão
    } else {
        // Consulta para verificar se o nome de usuário e a senha correspondem
        $sqlVerificaLoginMedico = "SELECT * FROM projetophp.medicos WHERE nome_usuario = '$nomeUsuario' AND senha = '$senha'";
        $resultLoginMedico = $conn->query($sqlVerificaLoginMedico);

        $sqlVerificaLoginPaciente = "SELECT * FROM projetophp.pacientes WHERE nome_usuario = '$nomeUsuario' AND senha = '$senha'";
        $resultLoginPaciente = $conn->query($sqlVerificaLoginPaciente);

        // Verificar se o usuário é um administrador
        if ($nomeUsuario == 'ADMIN') {
            $_SESSION['tipo_usuario'] = 'ADMIN';
            header("Location: ../../front/gerenciar_usuarios/usuarios.php");
            exit(); // Adicionado para evitar a execução de código adicional após o redirecionamento
        } elseif ($resultLoginMedico->num_rows > 0) {
            $rowMedico = $resultLoginMedico->fetch_assoc();
            $_SESSION['id_medico'] = $rowMedico['id_medico'];
            $_SESSION['tipo_usuario'] = 'medico';
            header("Location: ../../front/telas/telamedico.php");
            exit(); // Adicionado para evitar a execução de código adicional após o redirecionamento
        } elseif ($resultLoginPaciente->num_rows > 0) {
            $rowPaciente = $resultLoginPaciente->fetch_assoc();
            $_SESSION['id_paciente'] = $rowPaciente['id_paciente'];
            $_SESSION['tipo_usuario'] = 'paciente';
            header("Location: ../../front/telas/telapaciente.php");
            exit(); // Adicionado para evitar a execução de código adicional após o redirecionamento
        } else {
            // Usuário não encontrado ou senha incorreta
            // Adicione aqui a lógica para lidar com tentativas de login mal-sucedidas
            echo ("Usuário ou senha incorretos. Tente novamente.");
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
<form action="login.php" method="post">
  <div class="container login-container">
    <h1 class="title has-text-centered">Login</h1>
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

    <p class="has-text-centered">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
  </div>
</form>

  <script src="login.js"></script>
</body>
</html>
