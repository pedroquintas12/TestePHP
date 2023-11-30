<?php
session_start();

// Função para verificar se o usuário está logado
function verificarLogin() {
    if (!isset($_SESSION['id_medico'])) {
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

// Verificar se o usuário é um médico
verificarPermissao('medico');

$id_medico = $_SESSION['id_medico'];

include "../../../front/conexao.php";

// Recupera o prontuário do paciente selecionado
if (isset($_GET['id_consulta'])) {

  $idConsulta = $_GET['id_consulta']; // Correção aqui

  $sql = "SELECT a.prontuario, p.nome_completo AS nome_paciente
  FROM projetophp.agendamentos AS a
  INNER JOIN projetophp.pacientes AS p ON a.paciente_id = p.id_paciente
  WHERE a.id = ? AND a.medico_id = ?";
    
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idConsulta, $id_medico);

$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
die('Erro na execução da consulta: ' . $stmt->error);
}

if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$prontuario_paciente = $row['prontuario'];
$nome_paciente = $row['nome_paciente'];
} else {
// Redireciona se a consulta não pertencer ao médico logado
header("Location: telamedico.php");
exit();
}

$stmt->close();

} else {
  // Redireciona se o ID da consulta não estiver definido
  header("Location: telamedico.php");
  exit();
}
// Salva o prontuário no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prontuario_novo = $_POST['prontuario_novo'];

    $updateSql = "UPDATE projetophp.agendamentos SET prontuario = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $prontuario_novo, $idConsulta);
      $stmt->execute();

    // Recarrega a página após salvar o prontuário
    header("Location: prontuario.php?id_consulta=$id_consulta");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Prontuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Visualização de Prontuários</h1>
            <div class="columns">
                <div class="column is-one-third">
                    <div class="box">
                    <h2 class="subtitle">Paciente: <?php echo $nome_paciente; ?></h2>
                        <form method="post">
                            <p>Prontuário:</p>
                            <div class="content">
                                  <textarea class='textarea' name='prontuario_novo' placeholder='Editar Prontuário do <?php echo $nome_paciente; ?>'><?php echo $prontuario_paciente; ?></textarea>
                            </div>
                            <button type="submit" class="button is-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>