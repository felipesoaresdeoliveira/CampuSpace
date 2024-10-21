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

    // Busca o usuário no banco
    $stmt = $con->prepare("SELECT id, senha, tipo FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hash_senha, $tipo);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($senha, $hash_senha)) {
        // Login bem-sucedido
        $_SESSION['usuario_id'] = $id;
        $_SESSION['tipo'] = $tipo;

        // Redireciona com base no tipo de usuário
        if ($tipo == 'admin') {
            header("Location: ../adms/index_adm.php");
        } else {
            header("Location: usuario_dashboard.php");
        }
    } else {
        echo "Email ou senha incorretos.";
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
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <a href="../loguin/register.php">Registrar</a><br>
        <a href="../index.php">Voltar</a><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
