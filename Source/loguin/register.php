<?php
require '../db/conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
    $stmt->execute([$nome, $email, $senha]);

    header('Location: loguin.php');
}
?>
<form method="POST" action="register.php">
    <input type="text" name="nome" required placeholder="Nome completo">
    <input type="email" name="email" required placeholder="E-mail">
    <input type="password" name="senha" required placeholder="Senha">
    <button type="submit">Registrar</button>
</form>
