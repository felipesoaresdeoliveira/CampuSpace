<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Conecta ao banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema";
$con = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica conexão
if ($con->connect_error) {
    die("Erro de conexão: " . $con->connect_error);
}

// Busca informações do usuário
$stmt = $con->prepare("SELECT nome, email, foto, tipo FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$stmt->bind_result($nome, $email, $foto, $tipo);
$stmt->fetch();
$stmt->close();

// Processa alterações no perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];
    $nova_foto = $_FILES['foto']['name'];
    $nova_senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;

    // Atualiza foto se enviada
    if (!empty($nova_foto)) {
        $diretorio = "img/usuarios/";
        $caminho_foto = $diretorio . basename($nova_foto);

        // Move a nova foto para o diretório
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)) {
            $stmt = $con->prepare("UPDATE usuarios SET foto = ? WHERE id = ?");
            $stmt->bind_param("si", $nova_foto, $_SESSION['usuario_id']);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Atualiza nome e email
    $stmt = $con->prepare("UPDATE usuarios SET nome = ?, email = ?" . ($nova_senha ? ", senha = ?" : "") . " WHERE id = ?");
    if ($nova_senha) {
        $stmt->bind_param("sssi", $novo_nome, $novo_email, $nova_senha, $_SESSION['usuario_id']);
    } else {
        $stmt->bind_param("ssi", $novo_nome, $novo_email, $_SESSION['usuario_id']);
    }
    $stmt->execute();
    $stmt->close();

    // Atualiza a sessão
    $_SESSION['usuario_nome'] = $novo_nome;

    echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = 'editar_usuario.php';</script>";
}

$con->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Campuspace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 20px auto;
            display: block;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h3 class="text-center">Editar Perfil</h3>
        <form action="editar_usuario.php" method="POST" enctype="multipart/form-data">
            <div class="text-center">
                <img src="img/usuarios/<?php echo htmlspecialchars($foto); ?>" alt="Foto de Perfil" class="profile-img">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Alterar Foto:</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite a nova senha (opcional)">
            </div>
            <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
            <a href="usuarios_dashboard.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        </form>
    </div>
</body>
</html>
