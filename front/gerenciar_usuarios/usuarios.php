
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
  include "conexao.php";

      $sql = "SELECT nomeSobrenome,id_medico,bloqueado FROM projetophp.medicos";

      $resultado = mysqli_query($conn, $sql);

      if (mysqli_num_rows($resultado) > 0) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
          echo "<div class='user-card card'>";
          echo "<div class='card-content'>";
          echo "<p class='title'>Dr." . $linha["nomeSobrenome"] . "</p>";
          echo "<p class='subtitle'>Médico</p>";
      
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
?>
      <!-- Outros usuários seriam listados da mesma forma -->

    </div>
  </section>

  <script src="usuarios.js"></script>
</body>
</html>
