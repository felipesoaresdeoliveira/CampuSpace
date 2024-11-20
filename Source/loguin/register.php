<?php
session_start();

// Dados de conexão com o banco de dados
$servidor = "localhost:3306";
$usuario = "root";
$senha = "";
$banco = "sistema";

// Conecta ao banco de dados
$con = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica a conexão
if ($con->connect_error) {
    die("Erro ao conectar: " . $con->connect_error);
}

// Variável para armazenar a mensagem de erro/sucesso
$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';

    // Verifica se todos os campos foram preenchidos
    if (empty($nome) || empty($email) || empty($senha) || empty($confirma_senha)) {
        $mensagem = "<p class='error-msg'>Por favor, preencha todos os campos.</p>";
    } elseif ($senha !== $confirma_senha) {
        // Verifica se as senhas são iguais
        $mensagem = "<p class='error-msg'>As senhas não correspondem.</p>";
    } else {
        // Verifica se o email já está registrado
        $sql_verifica_email = "SELECT id FROM usuarios WHERE email = ?";
        $stmt_verifica = $con->prepare($sql_verifica_email);
        $stmt_verifica->bind_param("s", $email);
        $stmt_verifica->execute();
        $resultado = $stmt_verifica->get_result();
        
        if ($resultado->num_rows > 0) {
            $mensagem = "<p class='error-msg'>Este email já está registrado.</p>";
        } else {
            // Verifica o domínio do email para determinar o tipo de usuário
            if (strpos($email, '@estudantes.ifpr.edu') !== false) {
                $tipo = 'aluno';
            } elseif (strpos($email, '@gmail.com') !== false) {
                $tipo = 'admin';
            } else {
                $tipo = 'aluno'; // Padrão para domínios desconhecidos
            }

            // Hashear a senha antes de inserir no banco
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

            // Insere os dados no banco
            $sql_insert = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
            $stmt_insert = $con->prepare($sql_insert);
            $stmt_insert->bind_param("ssss", $nome, $email, $senha_hashed, $tipo);

            if ($stmt_insert->execute()) {
                $_SESSION['usuario_nome'] = $nome;
                $_SESSION['tipo'] = $tipo;

                // Redireciona para a dashboard correta com base no tipo de usuário
                if ($tipo == 'admin') {
                    header("Location: ../adms/index_adm.php");
                } else {
                    header("Location: ../reservas/usuarios_dashboard.php");
                }
                exit();
            } else {
                $mensagem = "<p class='error-msg'>Erro ao registrar: " . $stmt_insert->error . "</p>";
            }

            $stmt_insert->close();
        }
        $stmt_verifica->close();
    }
}

// Fecha a conexão com o banco de dados
$con->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
    <link rel="stylesheet" href="../loguin/styles/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-msg { color: red; }
        .success-msg { color: green; }
        body { padding: 2rem; }
        form { max-width: 500px; margin: auto; }
    </style>
</head>
<body>

    <h1>Registro de Usuário</h1>

    <!-- Exibe a mensagem de erro ou sucesso -->
    <?php echo $mensagem; ?>

    <!-- Formulário de registro -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirma_senha">Confirmar Senha:</label>
            <input type="password" name="confirma_senha" id="confirma_senha" class="form-control" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>

</body>
</html>
