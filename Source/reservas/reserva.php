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

$mensagem = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário e evita SQL Injection usando prepare statements
    $sala = $_POST['sala'] ?? '';
    $data = $_POST['data'] ?? '';
    $horario = $_POST['horario'] ?? '';

    // Verifica se todos os campos foram preenchidos
    if (empty($sala) || empty($data) || empty($horario)) {
        $mensagem = "<p class='error-msg'>Por favor, preencha todos os campos.</p>";
    } else {
        // Verifica se já existe uma reserva no mesmo horário e sala
        $sql_check = "SELECT * FROM reservas WHERE sala = ? AND data = ? AND horario = ?";
        $stmt_check = $con->prepare($sql_check);
        $stmt_check->bind_param("sss", $sala, $data, $horario);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        // Se já existir uma reserva, não permitir a nova reserva
        if ($result_check->num_rows > 0) {
            $mensagem = "<p class='error-msg'>Já existe uma reserva para esta sala no mesmo horário.</p>";
        } else {
            // Prepara a consulta SQL para inserir a nova reserva
            $sql_insert = "INSERT INTO reservas (sala, data, horario) VALUES (?, ?, ?)";

            $stmt_insert = $con->prepare($sql_insert);

            if ($stmt_insert === false) {
                die("<p>Erro na preparação da consulta: " . $con->error . "</p>");
            }

            // Conecta os valores aos parâmetros do SQL
            $stmt_insert->bind_param("sss", $sala, $data, $horario);

            // Executa a consulta e verifica se foi bem-sucedida
            if ($stmt_insert->execute()) {
                $mensagem = "<p class='success-msg'>Reserva realizada com sucesso!</p>";
            } else {
                $mensagem = "<p class='error-msg'>Erro ao realizar reserva: " . $stmt_insert->error . "</p>";
            }

            // Fecha a declaração de inserção
            $stmt_insert->close();
        }

        // Fecha a declaração de verificação
        $stmt_check->close();
    }
}

// Fecha a conexão
$con->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campuspace - Fazer Reserva</title>
    <link rel="stylesheet" href="../reservas/reserva_styles/reserva_styles.css">
</head>
<body>

        <!-- Incluindo o Header -->
        <?php include '../includes/header.php'; ?>

    <div class="container">
        <h1>Fazer uma Reserva</h1>

        <!-- Exibe a mensagem de sucesso ou erro -->
        <?php echo $mensagem; ?>

        <!-- Formulário de reserva -->
        <form action="reserva.php" method="POST">
            <div class="form-group">
                <label for="sala">Sala:</label>
                <select name="sala" id="sala" required>
                    <option value="">Selecione uma sala</option>
                    <option value="Sala estudo">sala para estudo</option>
                    <option value="Laboratório quimica">Laboratório de quimica</option>
                    <option value="Laboratório informatica">Laboratório de informatica</option>
                    <option value="Quadra areia">Quadra de areia</option>
                    <option value="Quadra poliesportiva">quadra poliesportiva</option>

                </select>
            </div>

            <div class="form-group">
                <label for="data">Data:</label>
                <input type="date" name="data" id="data" required>
            </div>

            <div class="form-group">
                <label for="horario">Horário:</label>
                <input type="time" name="horario" id="horario" required>
            </div>

            <!-- Contêiner para centralizar o botão -->
            <div class="btn-container">
                <button type="submit" class="btn">Reservar</button>
                <button type="button" class="btn" onclick="window.location.href='reservas_list.php'">Locais reservados</button>
            </div>
        </form>
    </div>
</body>
</html>
