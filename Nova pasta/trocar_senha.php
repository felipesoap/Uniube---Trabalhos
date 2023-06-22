<?php
// Verificar se o usuário está autenticado, caso contrário, redirecionar para a página de login
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit;
}

// db_connection.php contém as configurações de conexão com o banco de dados
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $senha_antiga = $_POST['senha_antiga'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verificar se a senha antiga está correta
    $query = "SELECT senha FROM usuarios WHERE id = '$usuario_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $senha_atual = $row['senha'];

    if (!password_verify($senha_antiga, $senha_atual)) {
        echo 'A senha antiga está incorreta.';
        exit;
    }

    // Verificar se a nova senha atende aos critérios de criação
    if (strlen($nova_senha) < 6 || !preg_match('/[A-Z]/', $nova_senha) || !preg_match('/[0-9]/', $nova_senha)) {
        echo 'A nova senha não atende aos critérios de criação.';
        exit;
    }

    // Verificar se a confirmação da nova senha coincide
    if ($nova_senha !== $confirmar_senha) {
        echo 'A confirmação da nova senha não coincide.';
        exit;
    }

    // Atualizar a senha do usuário no banco de dados
    $nova_senha = password_hash($nova_senha, PASSWORD_DEFAULT);
    $query = "UPDATE usuarios SET senha = '$nova_senha' WHERE id = '$usuario_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Senha alterada com sucesso!';
    } else {
        echo 'Erro ao alterar a senha. Tente novamente.';
    }
}
?>
