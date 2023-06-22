<?php
// db_connection.php contém as configurações de conexão com o banco de dados
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o email já está cadastrado
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo 'O email já está cadastrado.';
        exit;
    }

    // Inserir novo usuário na tabela de usuários
    $query = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Usuário registrado com sucesso!';
    } else {
        echo 'Erro ao registrar o usuário. Tente novamente.';
    }
}
?>
