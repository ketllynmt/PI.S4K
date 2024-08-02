<?php
$servername = "localhost";// Nome do servidor do banco de dados
$database = "s4k";// Nome do banco de dados
$db_username = "root";  // Nome de usuário para acessar o banco de dados
$db_password = ""; // Senha para acessar o banco de dados

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
