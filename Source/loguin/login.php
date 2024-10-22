<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Conecta ao banco de dados
    $servidor = "localhost:3306";
    $usuario = "root";
    $senhaDB = "";
    $banco = "sistema";

    $con = new mysqli($servidor, $usuario, $senhaDB, $banco);
    if ($con->connect_error) {
        die("Erro de conexão: " . $con->connect_error);
    }

    // Busca o usuário no banco, incluindo o nome
    $stmt = $con->prepare("SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $nome, $hash_senha, $tipo);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($senha, $hash_senha)) {
        // Login bem-sucedido
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_nome'] = $nome;  // Armazena o nome do usuário
        $_SESSION['tipo'] = $tipo;

        // Redireciona com base no tipo de usuário
        if ($tipo == 'admin') {
            header("Location: ../adms/index_adm.php");
        } else {
            header("Location: ../reservas/usuarios_dashboard.php");
        }
        exit();
    } else {
        echo "<p class='error-msg'>Email ou senha incorretos.</p>";
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Campuspace</title>
    <link rel="stylesheet" href="../loguin/styles/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="links">
                <a href="../loguin/register.php">Registrar</a>
                <a href="../index.php">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
