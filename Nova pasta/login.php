<?php
// db_connection.php contém as configurações de conexão com o banco de dados
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar as credenciais do usuário no banco de dados
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Executar a consulta SQL para verificar as credenciais
    $query = "SELECT id, nome FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['usuario_nome'] = $row['nome'];
        header('Location: main.php');
        exit;
    } else {
        echo 'Credenciais inválidas. Tente novamente.';
    }
}

?>

