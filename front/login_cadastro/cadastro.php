<?php

include "../../../front/conexao.php";

// Inicializa a sessão (se ainda não estiver iniciada)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Função para adicionar mensagens de erro à sessão
function addError($message) {
    $_SESSION['errors'][] = "<span style='color: red;'>$message</span>";
}

if (isset($_POST['submit'])) {
    // Recupere os dados do formulário
    $nomeCompleto = $_POST['nomecompleto'];
    $email = $_POST['email'];
    $numeroTelefone = $_POST['numero'];
    $endereco = $_POST['endereco'];
    $nomeUsuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Validar o nome de usuário
    if (empty($nomeUsuario)) {
        addError("Por favor, preencha o campo Nome de Usuário.");
    } else {
        // Verifique a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $sqlVerificaUsuarioMedico = "SELECT * FROM projetophp.medicos WHERE nome_usuario = '$nomeUsuario'";
        $resultUsuarioMedico = $conn->query($sqlVerificaUsuarioMedico);
        
        // Verificar se o nome de usuário já existe em pacientes
        $sqlVerificaUsuarioPaciente = "SELECT * FROM projetophp.pacientes WHERE nome_usuario = '$nomeUsuario'";
        $resultUsuarioPaciente = $conn->query($sqlVerificaUsuarioPaciente);
        
        // Verificar se o nome de usuário já existe em ambas as tabelas
        if ($resultUsuarioMedico->num_rows > 0) {
            addError("Nome de usuário já existe. Escolha outro.");
        } elseif ($resultUsuarioPaciente->num_rows > 0) {
            addError("Nome de usuário já existe. Escolha outro.");
        } 
      }

    // Validar o nome completo
    if (empty($nomeCompleto)) {
        addError("Por favor, preencha o campo Nome e Sobrenome.");
    }

    // Validar o email
    if (empty($email)) {
        addError("Por favor, preencha o campo Email.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        addError("Formato de email inválido.");
    }

    // Validar o número de telefone
    if (empty($numeroTelefone)) {
        addError("Por favor, preencha o campo Número de Telefone.");
    }

    // Validar o endereço
    if (empty($endereco)) {
        addError("Por favor, preencha o campo Endereço.");
    }

    // Validar o nome de usuário
    if (empty($nomeUsuario)) {
        addError("Por favor, preencha o campo Nome de Usuário.");
    }

    // Validar a senha
    if (empty($senha)) {
        addError("Por favor, preencha o campo Senha.");
    }

    // Verifica se há erros na validação
    if (!empty($_SESSION['errors'])) {
      // Se houver erros, exibe as mensagens de erro no local apropriado no formulário
      echo "<div class='errors'>";
      foreach ($_SESSION['errors'] as $error) {
          echo $error . "<br>";
      }
      echo "</div>";
      session_destroy();
  } else {
 

      // Insira os dados no banco de dados
      $sqlInserirUsuario = "INSERT INTO projetophp.pacientes (nome_completo, email, numero_telefone, endereco, nome_usuario, senha) 
                            VALUES ('$nomeCompleto', '$email', '$numeroTelefone', '$endereco', '$nomeUsuario', '$senha')";

      if ($conn->query($sqlInserirUsuario) === TRUE) {
          echo "Cadastro realizado com sucesso!";
          header("Location: ../../front/login_cadastro/login.php");
      } else {
          echo "Erro ao cadastrar: " . $conn->error;
      }

      $conn->close();
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Cadastro</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="cadastro.css">
</head>
<body>
  
<form action="cadastro.php" method="post">
  <div class="container cadastro-container">
    <h1 class="title has-text-centered">Cadastro</h1>
    
    <div class="field">
      <label class="nomecompleto">Nome e Sobrenome</label>
      <div class="control">
        <input class="input" type="text" name="nomecompleto" placeholder="Seu Nome e Sobrenome">
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
      <label class="endereco">Endereço</label>
      <div class="control">
        <input class="input" type="text" name="endereco" placeholder="Seu endereço">
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
    
    </form>
    <div class="field">
      <div class="control">
        <button class="button is-primary is-fullwidth" type="submit" name="submit">Finalizar</button>
      </div>
    </div>
  </div>
  <script src="cadastro.js"></script>
</body>
</html>
