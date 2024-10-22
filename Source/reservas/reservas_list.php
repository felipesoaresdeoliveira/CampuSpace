<?php
// Dados de conexão com o banco de dados
$servidor = "localhost:3306";
$usuario = "root";
$senha = "";
$banco = "sistema";

// Conecta ao banco de dados
$con = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica a conexão
if ($con->connect_error) {
    die("<p>Ocorreu um problema ao conectar ao banco de dados: " . $con->connect_error . "</p>");
}

// Consulta todas as reservas, incluindo a imagem do local
$sql = "SELECT r.sala, r.data, r.horario, l.foto 
        FROM reservas r 
        JOIN locais l ON r.sala = l.nome 
        ORDER BY r.data, r.horario";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campuspace - Lista de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./reserva_styles/styles_list.css">
</head>
<body>
<?php include '../includes/header.php'; ?>


    <div class="container">
        <h1>Lista de Reservas</h1>

        <!-- Verifica se há reservas e exibe -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sala</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Imagem</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['sala']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data'])); ?></td>
                            <td><?php echo $row['horario']; ?></td>
                            <td>
                                <!-- Exibe a imagem da sala -->
                                <?php if (!empty($row['foto'])): ?>
                                    <img src="../img/locais/<?php echo $row['foto']; ?>" alt="<?php echo $row['sala']; ?>" class="img-thumbnail" style="width: 50px; height: 50px;">
                                <?php else: ?>
                                    <p>Sem imagem</p>
                                <?php endif; ?>
                            </td>
                            <td>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Não há reservas no momento.</p>
        <?php endif; ?>

        <!-- Botão para ir à página de reserva -->
        <a href="reserva.php" class="btn">Fazer uma Nova Reserva</a>
    </div>

    <?php $con->close(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
