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
        include "../../front/login_cadastro/conexao.php";

          $sql = "SELECT m.id_medico, m.nomeSobrenome, m.especialidade,endereco_de_trabalho
          FROM projetophp.medicos AS m";

      $resultado = mysqli_query($conn, $sql);

   if (mysqli_num_rows($resultado) > 0) {
    while ($linha = mysqli_fetch_assoc($resultado)) {
     echo   "<div class='column is-one-third'>";
     echo     "<div class='medico-card card' name='medic  o1'('Dr.".$linha["nomeSobrenome"].")>";
     echo       "<div class='card-content'>";
     echo         "<p class='title'>Dr.". $linha["nomeSobrenome"]."</p>";
     echo         "<p class='subtitle'>". $linha["especialidade"]."</p>";
     echo         "<p>Horário: Seg-Sex, 9h - 17h</p>";
     echo         "<p>Local:". $linha["endereco_de_trabalho"]." /".$linha["especialidade"]. "</p>";
     echo       "</div>";
     echo     "</div>";
     echo   "</div>";
    }
  }
          ?>
        <!-- Adicione mais cards para outros médicos -->
      </div>
    </div>
  </section>
  <script src="telapaciente.js"></script>
</body>
</html>
