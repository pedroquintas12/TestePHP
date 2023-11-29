<?php
session_start();

// Função para verificar se o usuário está logado
function verificarLogin() {
    if (!isset($_SESSION['id_paciente'])) {
        header("Location: ../../front/login_cadastro/login.php"); // Redirecionar para a página de login se o usuário não estiver logado
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
verificarPermissao('paciente');
$idPaciente = $_SESSION['id_paciente'];
?>
  <!DOCTYPE html>
  <html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Paciente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="telapaciente.css">
  </head>
  <body>
    <section class="section">
      <div class="container">
        <h1 class="title">Página do Paciente</h1>

        <!-- Médicos e Especialidades -->
        <h2 class="subtitle">Médicos e Especialidades</h2>
        <div class="columns is-multiline">
          <!-- Card de Médico -->

          <?php
include "../../../front/conexao.php";

$sql = "SELECT m.id_medico, m.nomeSobrenome, m.especialidade, m.endereco_de_trabalho, m.nome_usuario, m.bloqueado
FROM projetophp.medicos AS m WHERE nome_usuario != 'ADMIN' AND bloqueado != '1'";

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) > 0) {
    while ($linha = mysqli_fetch_assoc($resultado)) {
      
        echo "<div class='column is-one-third'>";
        echo "<div class='medico-card card' name='{$linha['id_medico']}' onclick=\"mostrarHorarios('Dr.{$linha['nomeSobrenome']}', {$linha['id_medico']})\">";
        echo "<div class='card-content'>";
        echo "<p class='title'>Dr.{$linha['nomeSobrenome']}</p>";
        echo "<p class='subtitle'>{$linha['especialidade']}</p>";
        echo "<p>Horário: Seg-Sex, 9h - 17h</p>";
        echo "<p>Local: {$linha['endereco_de_trabalho']} / {$linha['especialidade']}</p>";
        echo "</div>";
        echo "</div>";
        // Botões de agendamento
        echo "<form action='agendamento.php' method='post'>";
        echo "<input type='hidden' name='id_medico' value='{$linha['id_medico']}'>"; // Adiciona um campo oculto com o id_medico
        echo "<label for='hora4'>09:00</label>";
        echo "<input type='radio' id='hora4' name='horario' value='09:00'>";
        echo "<label for='hora5'>10:00</label>";
        echo "<input type='radio' id='hora5' name='horario' value='10:00'>";
        echo "<label for='hora6'>11:30</label>";
        echo "<input type='radio' id='hora6' name='horario' value='11:30'>";
        echo "<button class='button is-primary' type='submit'>Agendar</button>";
        echo "</form>";

        echo "</div>";
    }
}

?>
        
        </div>
      </div>
      <?php
      if (isset($_GET['message'])) {
          $message = urldecode($_GET['message']);
          echo "<p>$message</p>";
      }
      ?>
    </section>
  </body>
  </html>
