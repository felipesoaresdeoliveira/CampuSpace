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

// Consulta todas as reservas
$sql = "SELECT sala, data, horario FROM reservas ORDER BY data, horario";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campuspace - Lista de Reservas</title>
    <link rel="stylesheet" href="./reserva_styles/styles_list.css">
</head>
<body>
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
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['sala']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data'])); ?></td>
                            <td><?php echo $row['horario']; ?></td>
                            <td>
                                <!-- Botão para voltar e já preencher a sala -->
                                <a href="reserva.php?sala=<?php echo urlencode($row['sala']); ?>" class="btn">Voltar e Reservar</a>
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
</body>
</html>