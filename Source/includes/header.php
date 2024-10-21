<header class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Campuspace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../reservas/reserva.php">Saiba Mais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./loguin/login.php">
                        <?php echo isset($_SESSION['user']) ? 'Sair' : 'Entrar'; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
