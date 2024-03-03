<?php

// Detalhes da conexão ao banco de dados
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "database";

// Opções de PDO (opcional)
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// Criar conexão PDO
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $options);
} catch (PDOException $e) {
    // Exibir mensagem de erro
    echo "Falha na conexão: " . $e->getMessage();
    die();
}

?>