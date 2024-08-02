<?php
// Ativar a exibição de erros para depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Inicializa a variável de filtro
$id_cliente_pesquisa = isset($_POST['id_cliente']) ? (int)$_POST['id_cliente'] : null;

// Se existir um ID para pesquisar, faz a busca filtrada
if ($id_cliente_pesquisa) {
    $sql = "SELECT * FROM cliente WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente_pesquisa);
    $stmt->execute();
    $result = $stmt->get_result();
    $clientes = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    // Caso contrário, exibe todos os clientes
    $sql = "SELECT * FROM cliente";
    $result = $conn->query($sql);
    $clientes = $result->fetch_all(MYSQLI_ASSOC);
}

// Função para excluir um cliente
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_cliente'])) {
    $id_cliente = (int)$_GET['id_cliente'];
    $sql = "DELETE FROM cliente WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $stmt->close();
    header("Location: painel.php"); // Redireciona após exclusão
    exit();
}

// Se existir um ID para editar, busca as informações do cliente
$clienteToEdit = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id_cliente'])) {
    $id_cliente = (int)$_GET['id_cliente'];
    $sql = "SELECT * FROM cliente WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();
    $clienteToEdit = $result->fetch_assoc();
    $stmt->close();
}

// Atualiza um cliente se o formulário de edição for enviado
if (isset($_POST['update'])) {
    $id_cliente = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    $sql = "UPDATE cliente SET nome = ?, email = ?, mensagem = ? WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $email, $mensagem, $id_cliente);
    $stmt->execute();
    $stmt->close();
    header("Location: painel.php"); // Redireciona após atualização
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gestão</title>
    <link rel="stylesheet" href="painel.css"> <!-- Inclua o CSS -->
</head>
<body>
    <div class="container">
        <h1>Painel de Gerenciamento</h1>

        <!-- Formulário de Pesquisa -->
        <form action="painel.php" method="post">
            <p>
                <label for="id_cliente">Pesquisar por ID:</label>
                <input type="number" id="id_cliente" name="id_cliente" min="1" value="<?php echo isset($_POST['id_cliente']) ? htmlspecialchars($_POST['id_cliente']) : ''; ?>">
                <button type="submit">Pesquisar</button>
            </p>
        </form>

        <!-- Tabela de Clientes -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Mensagem</th>
             
                </tr>
            </thead>
            <tbody>
                <?php if ($clientes): ?>
                    <?php foreach ($clientes as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['mensagem']); ?></td>
                        <td>
                            <a href="painel.php?action=edit&id_cliente=<?php echo $row['id_cliente']; ?>" class="edit-link">
                                <button class="edit-btn">Editar</button>
                            </a>
                            <a href="painel.php?action=delete&id_cliente=<?php echo $row['id_cliente']; ?>" class="delete-link" onclick="return confirm('Tem certeza que deseja excluir?');">
                                <button class="delete-btn">Excluir</button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum cliente encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Formulário de Edição (aparece se $clienteToEdit estiver definido) -->
        <?php if ($clienteToEdit): ?>
        <h2>Editar Cliente</h2>
        <form action="painel.php" method="post">
            <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($clienteToEdit['id_cliente']); ?>">
            <p>
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($clienteToEdit['nome']); ?>" required>
            </p>
            <p>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($clienteToEdit['email']); ?>" required>
            </p>
            <p>
                <label>Mensagem:</label>
                <textarea name="mensagem" required><?php echo htmlspecialchars($clienteToEdit['mensagem']); ?></textarea>
            </p>
            <p>
                <button type="submit" name="update">Atualizar</button>
            </p>
        </form>
        <?php endif; ?>

        <p class="navigation-buttons">
            <a href="painel.php" class="back-link">Voltar</a>
            <a href="formulario.php" class="exit-link">Sair</a>
        </p>
    </div>
</body>
</html>
