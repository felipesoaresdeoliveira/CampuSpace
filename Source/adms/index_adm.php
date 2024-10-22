<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] != 'admin') {
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

// Total de usuários
$result = $con->query("SELECT COUNT(*) AS total_usuarios FROM usuarios");
$total_usuarios = $result->fetch_assoc()['total_usuarios'];

// Total de salas usadas
$result = $con->query("SELECT COUNT(DISTINCT sala) AS total_salas_usadas FROM reservas");
$total_salas_usadas = $result->fetch_assoc()['total_salas_usadas'];

// Salas mais usadas
$salas_usadas = $con->query("SELECT sala, COUNT(*) AS vezes_reservada FROM reservas GROUP BY sala ORDER BY vezes_reservada DESC LIMIT 5");

// Horários mais frequentes
$horarios_frequentes = $con->query("SELECT horario, COUNT(*) AS frequencia FROM reservas GROUP BY horario ORDER BY frequencia DESC LIMIT 5");

$con->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Administrador</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<a href="adm_locais.php"><button>Gerenciar Locais</button></a>

    <h2>Estatísticas do Sistema</h2>
    <p>Total de Usuários: <?php echo $total_usuarios; ?></p>
    <p>Total de Salas Usadas: <?php echo $total_salas_usadas; ?></p>

    <h3>Salas Mais Usadas</h3>
    <canvas id="salasChart" width="400" height="200"></canvas>

    <h3>Horários Mais Frequentes</h3>
    <canvas id="horariosChart" width="400" height="200"></canvas>

    <script>
        // Gráfico de Salas Mais Usadas
        var ctxSalas = document.getElementById('salasChart').getContext('2d');
        var salasChart = new Chart(ctxSalas, {
            type: 'bar',
            data: {
                labels: [<?php $salas_usadas->data_seek(0); while($row = $salas_usadas->fetch_assoc()) { echo '"' . $row['sala'] . '", '; } ?>],
                datasets: [{
                    label: 'Reservas',
                    data: [<?php $salas_usadas->data_seek(0); while($row = $salas_usadas->fetch_assoc()) { echo $row['vezes_reservada'] . ', '; } ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Horários Mais Frequentes
        var ctxHorarios = document.getElementById('horariosChart').getContext('2d');
        var horariosChart = new Chart(ctxHorarios, {
            type: 'bar',
            data: {
                labels: [<?php $horarios_frequentes->data_seek(0); while($row = $horarios_frequentes->fetch_assoc()) { echo '"' . $row['horario'] . '", '; } ?>],
                datasets: [{
                    label: 'Frequência',
                    data: [<?php $horarios_frequentes->data_seek(0); while($row = $horarios_frequentes->fetch_assoc()) { echo $row['frequencia'] . ', '; } ?>],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
