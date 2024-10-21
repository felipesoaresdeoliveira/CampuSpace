<?php
session_start();
require '../db/conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['user'] = $usuario['id'];
        header('Location: ../index.php');
    } else {
        $erro = 'Usuário ou senha inválidos';
    }
}
?>
<form method="POST" action="loguin.php">
    <input type="email" name="email" required placeholder="Digite seu e-mail">
    <input type="password" name="senha" required placeholder="Digite sua senha">
    <button type="submit">Entrar</button>
    <?php if (isset($erro)): ?>
        <p><?php echo $erro; ?></p>
    <?php endif; ?>
</form>
