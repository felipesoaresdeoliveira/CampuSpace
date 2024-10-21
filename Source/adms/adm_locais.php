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

$mensagem = "";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $foto = $_FILES['foto']['name'] ?? '';

    // Verifica se todos os campos foram preenchidos
    if (empty($nome) || empty($descricao)) {
        $mensagem = "<p class='error-msg'>Por favor, preencha todos os campos.</p>";
    } else {
        // Upload da foto
        $target_dir = "../img/locais/";
        $target_file = $target_dir . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);

        // Prepara a consulta SQL para inserir o novo local
        $sql_insert = "INSERT INTO locais (nome, descricao, foto) VALUES (?, ?, ?)";

        $stmt = $con->prepare($sql_insert);
        $stmt->bind_param("sss", $nome, $descricao, $foto);

        if ($stmt->execute()) {
            $mensagem = "<p class='success-msg'>Local adicionado com sucesso!</p>";
        } else {
            $mensagem = "<p class='error-msg'>Erro ao adicionar local: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Locais - Administrador</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

    <!-- Incluindo o Header -->
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h1>Adicionar Local</h1>

        <!-- Exibe a mensagem de sucesso ou erro -->
        <?php echo $mensagem; ?>

        <!-- Formulário de adição de locais -->
        <form action="adm_locais.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome do Local:</label>
                <input type="text" name="nome" id="nome" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" required></textarea>
            </div>

            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" name="foto" id="foto" required>
            </div>

            <button type="submit" class="btn">Adicionar Local</button>
            

        </form>
    </div>

    <a href="index_adm.php"><button>Voltar</button></a>

    <?php include '../includes/footer.php'; ?>

</body>
</html>
