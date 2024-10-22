<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campuspace - Reserve seu Espaço no IFPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<header class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Campuspace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
            </ul>
        </div>
    </div>
</header>


       
    <!-- Hero Section -->
    <section class="hero-section text-white text-center py-5">
        <div class="container">
            <h1>Bem-vindo ao Campuspace</h1>
            <p class="lead">Gerencie e reserve espaços no IFPR de forma simples e eficiente.</p>
            <a href="loguin/login.php" class="btn btn-light btn-lg">Começar</a>
        </div>
    </section>

    <!-- Sobre o Campuspace -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="img/marca-ifpr.jpg" alt="Campuspace" class="img-fluid rounded shadow-sm">
                </div>
                <div class="col-md-6">
                    <h2>Sobre o Campuspace</h2>
                    <p>O Campuspace é um sistema inovador para reserva de espaços no IFPR. Com ele, você pode gerenciar e reservar salas de aula, laboratórios, e outros ambientes de maneira prática e sem complicações.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços -->
    <section id="services" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Nossos Serviços</h2>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="card-title">Reserva de Salas</h3>
                            <p class="card-text">Faça a reserva de salas de aula com antecedência e evite conflitos de horário.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="card-title">Laboratórios</h3>
                            <p class="card-text">Gerencie a disponibilidade e o uso dos laboratórios de forma eficiente.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="card-title">Quadras</h3>
                            <p class="card-text">Reserve quadras para treinos e jogos no campus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Incluindo o Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
