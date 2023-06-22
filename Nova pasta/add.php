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
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_conclusao = $_POST['data_conclusao'];

    // Preparar a consulta SQL para adicionar a tarefa
    $query = "INSERT INTO tarefas (usuario_id, titulo, descricao, data_conclusao) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'isss', $usuario_id, $titulo, $descricao, $data_conclusao);

    // Executar a consulta preparada
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Redirecionar para a página principal
        header('Location: main.php');
        exit;
    } else {
        echo 'Erro ao adicionar a tarefa. Tente novamente.';
    }
}
?>
