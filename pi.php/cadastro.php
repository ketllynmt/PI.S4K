<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Dados de conexão com o banco de dados
    require_once('conexao.php'); // Inclui a conexão

    // Prepara a consulta SQL para inserir os dados na tabela 'cliente'
    $sql = "INSERT INTO cliente (nome, email, mensagem) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        die("Falha na preparação da consulta: " . $conn->error);
    }

    // Associa os parâmetros e executa a consulta
    $stmt->bind_param("sss", $username, $email, password_hash($password, PASSWORD_DEFAULT));

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fecha a consulta
    $stmt->close();
    // Não fecha a conexão aqui; ela será fechada no final do script ou em outro lugar apropriado.
}
?>
