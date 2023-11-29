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
                  FROM projetophp.medicos AS m where nome_usuario != 'ADMIN' and bloqueado !='1'";

          $resultado = mysqli_query($conn, $sql);

          if (mysqli_num_rows($resultado) > 0) {
            while ($linha = mysqli_fetch_assoc($resultado)) {
              echo "<div class='column is-one-third'>";
              echo "<div class='medico-card card' name='medico{$linha['id_medico']}' onclick=\"mostrarHorarios('Dr.{$linha['nomeSobrenome']}', {$linha['id_medico']})\">";
              echo "<div class='card-content'>";
              echo "<p class='title'>Dr.{$linha['nomeSobrenome']}</p>";
              echo "<p class='subtitle'>{$linha['especialidade']}</p>";
              echo "<p>Horário: Seg-Sex, 9h - 17h</p>";
              echo "<p>Local: {$linha['endereco_de_trabalho']} / {$linha['especialidade']}</p>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
            }
          }
        ?>
      </div>
    </div>
  </section>

  <section class="section" id="horariosDisponiveis" style="display: none;">
    <div class="container">
      <h2 class="subtitle" id="medicoSelecionado"></h2>
      <div class="columns is-multiline" id="listaHorarios">
        <!-- Os horários serão adicionados aqui -->
      </div>
    </div>
  </section>

  <script>
  const horariosMedicos = {
    <?php
      $sql_horarios = "SELECT nomeSobrenome, horarios_disponiveis FROM projetophp.medicos";
      $stmt = $conn->prepare($sql_horarios);
      $stmt->execute();
      $stmt->bind_result($nomeSobrenome, $horarios_disponiveis);

      $i = 0;

      while ($stmt->fetch()) {
        $medico = "Dr.$nomeSobrenome";
        $horarios = json_encode(explode(',', $horarios_disponiveis));
        echo "'$medico': " . $horarios;

        if ($i < $num_rows - 1) {
          echo ",";
        }
        $i++;
      }

      $stmt->close();
    ?>
  }
    function mostrarHorarios(medico, idMedico) {
      const horarios = horariosMedicos[medico];

      // Mostrar os horários disponíveis
      const horariosDisponiveis = document.getElementById('horariosDisponiveis');
      horariosDisponiveis.style.display = 'block';
      
      // Mostrar o nome do médico selecionado
      const medicoSelecionado = document.getElementById('medicoSelecionado');
      medicoSelecionado.textContent = `Horários Disponíveis - ${medico}`;
      
      // Limpar a lista de horários
      const listaHorarios = document.getElementById('listaHorarios');
      listaHorarios.innerHTML = '';
      
      // Adicionar os horários como botões clicáveis
      horarios.forEach(horario => {
        const novoHorario = document.createElement('div');
        novoHorario.classList.add('column', 'is-one-quarter');
        novoHorario.innerHTML = `
          <button class="button is-primary is-fullwidth" onclick="agendarConsulta(${idMedico}, '${medico}', '${horario}')">${horario}</button>
        `;
        listaHorarios.appendChild(novoHorario);
      });
    }

    function agendarConsulta(idMedico, medico, horario) {
      alert(`Consulta agendada com ${medico} (ID: ${idMedico}) para as ${horario}`);
      // Aqui você pode adicionar lógica para agendar a consulta no sistema
    }
  </script>
</body>
</html>
