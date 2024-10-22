<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Conecta ao banco de dados
$servidor = "localhost:3306";
$usuario = "root";
$senha = "";
$banco = "sistema";
$con = new mysqli($servidor, $usuario, $senha, $banco);
if ($con->connect_error) {
    die("Erro de conexão: " . $con->connect_error);
}

// Query para pegar as informações do usuário
$stmt = $con->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$stmt->bind_result($nome);
$stmt->fetch();
$stmt->close();

// Query para pegar as informações dos locais
$locais = $con->query("SELECT id, nome, descricao, foto FROM locais");
$con->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Usuário - Campuspace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../reservas/reserva_styles/dashboard.css">
</head>
<body>

    <!-- Incluindo o Header -->
    <?php include '../includes/header.php'; ?>

    <!-- Seção de Boas-vindas -->
    <section class="welcome-section text-white text-center py-5">
        <div class="container">
            <h1>Olá, <?php echo isset($nome) ? htmlspecialchars($nome) : 'Visitante'; ?>!</h1>
            <p class="lead">Aqui você pode visualizar os locais disponíveis e fazer suas reservas.</p>
        </div>
    </section>

    <!-- Locais Disponíveis -->
    <section class="locais-section py-5">
        <div class="container">
            <h2 class="text-center mb-4">Locais Disponíveis</h2>
            <div class="row g-4">
                <?php while ($local = $locais->fetch_assoc()) { ?>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <img src="../img/locais/<?php echo $local['foto']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($local['nome']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($local['nome']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($local['descricao']); ?></p>
                                <!-- Redirecionamento para a página de reserva com o ID do local -->
                                <a href="../reservas/reserva.php?local_id=<?php echo $local['id']; ?>" class="btn btn-primary">Reservar</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Incluindo o Footer -->
    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
