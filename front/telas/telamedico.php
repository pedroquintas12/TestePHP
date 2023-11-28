<?php
session_start();

// Função para verificar se o usuário está logado
function verificarLogin() {
    if (!isset($_SESSION['id_medico'])) {
        header("Location: ../../front/login_cadastro/login_medico.php"); // Redirecionar para a página de login se o usuário não estiver logado
        exit();
    }
}

// Função para verificar as permissões do usuário
function verificarPermissao($tipo_permitido) {
    if ($_SESSION['tipo_usuario'] !== $tipo_permitido) {
        echo "Você não tem permissão para acessar esta página.";
        exit();
    }
}

// Verificar se o usuário está logado
verificarLogin();

// Verificar se o usuário é um paciente
verificarPermissao('medico');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela do Médico</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
  <section class="section">
    <div class="container">
      <h1 class="title">Pacientes e Prontuários</h1>
      <div class="columns">
        <div class="column is-one-third">
          <div class="box" name="caixa_paciente">
            <h2 class="subtitle">Paciente 1: Carlos</h2>
            <p>Atendido pelo Dr. Médico A</p>
            <p>Prontuário:</p>
            <div class="content" name="prontuario">
              <textarea id="prontuario-carlos" class="textarea" placeholder="Editar Prontuário do Carlos..."></textarea>
              <button class="button is-primary" onclick="salvarProntuario('prontuario-carlos')">Salvar</button>
            </div>
          </div>
          <!-- Adicione mais blocos de pacientes conforme necessário -->
        </div>
      </div>
    </div>
  </section>
  <script>
    function salvarProntuario(idTextarea) {
      const prontuario = document.getElementById(idTextarea).value;
      localStorage.setItem(idTextarea, prontuario);
      alert('Prontuário salvo com sucesso!');
    }
  </script>
</body>
</html>
