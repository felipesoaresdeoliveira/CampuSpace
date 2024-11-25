<header style="background-color: #006837; color: #ffffff; padding: 15px 20px; font-family: Arial, sans-serif; position: relative;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
        <!-- Logo -->
        <a href="../reservas/usuarios_dashboard.php" style="font-size: 1.5rem; color: #ffffff; font-weight: bold; text-decoration: none;">Campuspace</a>

        <!-- Menu de navegação -->
        <div style="display: flex; gap: 20px;">
            <a href="../reservas/usuarios_dashboard.php" style="color: #ffffff; text-decoration: none;">Início</a>
            <a href="../reservas/reserva.php" style="color: #ffffff; text-decoration: none;">Saiba Mais</a>
        </div>

        <!-- Foto do usuário (bolinha) e Login -->
        <div style="display: flex; gap: 20px; align-items: center;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #bbb; display: flex; align-items: center; justify-content: center;">
                <img src="path_to_user_image.jpg" alt="Foto de perfil" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
            </div>
            <?php if (!isset($_COOKIE['username'])): ?>
                <a href="../login.php" style="padding: 8px 16px; background-color: #FFD700; color: #333333; text-decoration: none; border-radius: 5px;">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Menu de navegação responsivo -->
    <button style="background-color: transparent; border: none; cursor: pointer; display: none;" onclick="toggleMenu()">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav text-center">
            <li class="nav-item">
                <a href="../reservas/usuarios_dashboard.php" class="nav-link">Início</a>
            </li>
            <li class="nav-item">
                <a href="../reservas/reserva.php" class="nav-link">Saiba Mais</a>
            </li>
        </ul>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.querySelector('.navbar-collapse');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</header>

<?php
// Verifica se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conecta ao banco de dados
    $conn = new mysqli('localhost', 'username', 'password', 'database');

    // Verifica a conexão
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Obtém os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta o banco de dados
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Verifica se o usuário existe
    if ($result->num_rows > 0) {
        // Armazena o login em cookies
        setcookie('username', $username, time() + (86400 * 30), "/"); // 86400 = 1 day
        header('Location: ../reservas/usuarios_dashboard.php');
    } else {
        echo 'Login inválido';
    }

    // Fecha a conexão
    $conn->close();
}
?>
