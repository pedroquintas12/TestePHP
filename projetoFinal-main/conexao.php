<?php
    $servidor = "localhost";
    $usuario = "id21615508_pedro";
    $senha = "Pedro001305?";
    $database = "id21615508_projetophp";
    

    // Cria uma conexão com o banco de dados
    $conn = new mysqli($servidor, $usuario, $senha, $database);

    // Verifica se a conexão foi bem-sucedida
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    ?>