<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="./estilo.css">

<body>
    

<header class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Campuspace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservas/reserva.php">Reservas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="loguin.php">
                        <?php echo isset($_SESSION['user']) ? 'Sair' : 'Entrar'; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>



</body>
</html>