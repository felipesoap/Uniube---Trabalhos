<?php
// Configurações de conexão com o banco de dados MySQL
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'TarefasJa';

// Conexão com o banco de dados
$conn = mysqli_connect($host, $user, $password, $database);

// Verificar se ocorreu um erro na conexão
if (mysqli_connect_errno()) {
    die('Falha na conexão com o banco de dados: ' . mysqli_connect_error());
}
?>
