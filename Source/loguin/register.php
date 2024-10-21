<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

    // Verifica o domínio do e-mail
    if (strpos($email, '@estudantes.ifpr.edu.br') !== false) {
        $tipo = 'aluno';
    } elseif (strpos($email, '@gmail.com') !== false) {
        $tipo = 'admin';
    } else {
        echo "Email inválido. Apenas domínios do IFPR são permitidos.";
        exit;
    }

    // Conecta ao banco de dados
    $servidor = "localhost:3306";
    $usuario = "root";
    $senhaDB = "";
    $banco = "sistema";

    $con = new mysqli($servidor, $usuario, $senhaDB, $banco);
    if ($con->connect_error) {
        die("Erro de conexão: " . $con->connect_error);
    }

    // Insere o usuário no banco de dados
    $stmt = $con->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $senha, $tipo);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
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
    <title>Registro de Usuário</title>
</head>
<body>
    <h2>Registrar</h2>
    <form action="register.php" method="post">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
