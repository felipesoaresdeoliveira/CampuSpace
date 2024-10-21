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


// Fecha a declaração e a conexão
//use nas proximas paginas para fechar a conexão com o banco de dados e a declaração de consulta ao banco de dados.
//$stmt->close();
//$con->close();
?>