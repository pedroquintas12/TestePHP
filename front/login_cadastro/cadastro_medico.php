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

// Capturar os dados do formulário
if(isset($_POST['submit'])){
    // Recuperar os dados do formulário
    $nomesobrenome = $_POST['nomesobrenome'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $localtrabalho = $_POST['localtrabalho'];
    $crm = $_POST['crm'];
    $especializacao = $_POST['especializacao'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Validar o nome de usuário
    if (empty($usuario)) {
        addError("Por favor, preencha o campo Nome de Usuário.");
    } else {
        // Verificar a conexão
        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Verificar se o nome de usuário já existe
        $sqlVerificaUsuario = "SELECT * FROM projetophp.medicos WHERE nome_usuario = '$usuario'";
        $resultUsuario = $conn->query($sqlVerificaUsuario);

        if ($resultUsuario->num_rows > 0) {
            addError("Nome de usuário já existe. Escolha outro.");
        }
    }

    // Validar o nome e sobrenome
    if (empty($nomesobrenome)) {
        addError("Por favor, preencha o campo Nome e Sobrenome.");
    }

    // Validar o email
    if (empty($email)) {
        addError("Por favor, preencha o campo Email.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        addError("Formato de email inválido.");
    }

    // Validar o número de telefone
    if (empty($numero)) {
        addError("Por favor, preencha o campo Número de Telefone.");
    }

    // Validar o local de trabalho
    if (empty($localtrabalho)) {
        addError("Por favor, preencha o campo Local de Trabalho.");
    }

    // Validar o CRM
    if (empty($crm)) {
        addError("Por favor, preencha o campo CRM (Registro Médico).");
    }

    // Validar a especialização
    if (empty($especializacao)) {
        addError("Por favor, selecione uma Especialização.");
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
        // Inserir os dados no banco de dados
        $sqlInserirMedico = "INSERT INTO projetophp.medicos (nomeSobrenome, email, numero_telefone, endereco_de_trabalho, crm, nome_usuario, senha, especialidade)
                            VALUES ('$nomesobrenome', '$email', '$numero', '$localtrabalho', '$crm', '$usuario', '$senha', '$especializacao')";

        if ($conn->query($sqlInserirMedico) === TRUE) {
            echo "Cadastro realizado com sucesso!";
            header("Location: ../../front/login_cadastro/login.php");
            exit(); // Adicionado para evitar a execução de código adicional após o redirecionamento
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
