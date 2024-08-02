<?php
include('conexao.php'); // Inclua a conexão com o banco de dados

session_start(); // Inicia a sessão

$error = "";

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o e-mail e a senha foram preenchidos
    if (empty($email)) {
        $error = "Preencha seu e-mail";
    } elseif (empty($senha)) {
        $error = "Preencha sua senha";
    } else {
        // Prepara a consulta para verificar o usuário
        $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $senha);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se o usuário foi encontrado
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();

            // Inicia a sessão e redireciona para o painel
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['email'] = $usuario['email'];
            header("Location: painel.php");
            exit();
        } else {
            $error = "E-mail ou senha incorretos";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="container">
    <h1> Acesse sua conta de ADM</h1>
        <p>Esta página está disponível exclusivamente para administradores com autorização adequada, que possuem permissões específicas para acessar o painel de gerenciamento.</p>
        <form action="" method="POST">
            <p>
                <label>E-mail</label>
                <input type="email" name="email" required>
            </p>
            <p>
                <label>Senha</label>
                <input type="password" name="senha" required>
            </p>
            <p>
                <button type="submit">Entrar</button>
            </p>
        </form>
        <?php
        if ($error) {
            echo "<div class='error-box'>$error</div>";
        }
        ?>
    </div>
</body>
</html>
