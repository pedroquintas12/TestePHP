<?php
// Inicie a sessão (certifique-se de chamar session_start() antes de qualquer saída HTML)
session_start();

// Verifique se o usuário está logado como ADMIN
if ($_SESSION['tipo_usuario'] !== 'ADMIN') {
  // Se não for um administrador, redirecione para uma página de erro ou exiba uma mensagem de erro
  echo "<p>Você não tem permissão para acessar esta página. Faça o login como ADMIN.</p>";
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Usuários</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <link rel="stylesheet" href="usuarios.css">
</head>
<body>

  <section class="section">
    <div class="container">
      <h1 class="title">Gerenciar Usuários</h1>
  <?php
include "../../../front/conexao.php";

      $sql2 = "SELECT
      id_paciente,
      nome_completo,
      permissao,
      bloqueado,
      nome_usuario
      from projetophp.pacientes 
      where nome_usuario != 'ADMIN';
";

      $sql="SELECT
      id_medico,
      nomeSobrenome,
      permissao,
      bloqueado,
      nome_usuario
      from projetophp.medicos
      where nome_usuario != 'ADMIN';";

$resultado = $conn->query($sql);

      if (mysqli_num_rows($resultado) > 0) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
          echo "<div class='user-card card'>";
          echo "<div class='card-content'>";
          echo "<p class='title'>Dr." . $linha["nomeSobrenome"] . "</p>";
          echo "<p class='subtitle'>". $linha["permissao"]."</p>";
      
          if ($linha["bloqueado"] == 1) {
              echo "<p class='is-blocked'>Usuário Bloqueado</p>";
              // Botão para reativar o usuário
              echo "<form method='post' action='reativar_usuario.php'>";
              echo "<input type='hidden' name='usuario_id' value='" . $linha["id_medico"] . "'>";
              echo "<button type='submit' class='button is-success'>Reativar</button>";
              echo "</form>";
          } else {
              echo "<div class='buttons'>";
              echo "<button class='button is-success'>Ativar</button>";
              echo "<form method='post' action='bloquear_usuario.php'>";
              echo "<input type='hidden' name='usuario_id' value='" . $linha["id_medico"] . "'>";
              echo "<button type='submit' class='button is-warning'>Bloquear</button>";
              echo "</form>";
              echo "</div>";
          }
          echo "</div>";
          echo "</div>";
        }
      }
          
          $resultado2 = $conn->query($sql2);
          
      if (mysqli_num_rows($resultado2) > 0) {
        while ($linha2 = mysqli_fetch_assoc($resultado2)){
          echo "<div class='user-card card'>";
          echo "<div class='card-content'>";
          echo "<p class='title'>Paciente " . $linha2["nome_completo"] . "</p>";
          echo "<p class='subtitle'>".$linha2["permissao"]."</p>";
      
          if ($linha2["bloqueado"] == 1) {
              echo "<p class='is-blocked'>Usuário Bloqueado</p>";
              // Botão para reativar o usuário
              echo "<form method='post' action='reativar_paciente.php'>";
              echo "<input type='hidden' name='usuario_id' value='" . $linha2["id_paciente"] . "'>";
              echo "<button type='submit' class='button is-success'>Reativar</button>";
              echo "</form>";
          } else {
              echo "<div class='buttons'>";
              echo "<button class='button is-success'>Ativar</button>";
              echo "<form method='post' action='bloquear_paciente.php'>";
              echo "<input type='hidden' name='usuario_id' value='" . $linha2["id_paciente"] . "'>";
              echo "<button type='submit' class='button is-warning'>Bloquear</button>";
              echo "</form>";
              echo "</div>";
          }
      
          echo "</div>";
          echo "</div>";
        
      } 
}
?>
      <!-- Outros usuários seriam listados da mesma forma -->

    </div>
  </section>

  <script src="usuarios.js"></script>
</body>
</html>
