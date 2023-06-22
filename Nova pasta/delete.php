<?php
// Verificar se o usuário está autenticado, caso contrário, redirecionar para a página de login
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit;
}

// db_connection.php contém as configurações de conexão com o banco de dados
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $tarefa_id = $_GET['id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Verificar se a tarefa pertence ao usuário atual
    $query = "SELECT * FROM tarefas WHERE id = '$tarefa_id' AND usuario_id = '$usuario_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Executar a consulta SQL para excluir a tarefa
        $query = "DELETE FROM tarefas WHERE id = '$tarefa_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header('Location: main.php');
            exit;
        } else {
            echo 'Erro ao excluir a tarefa. Tente novamente.';
        }
    } else {
        echo 'A tarefa não existe ou não pertence a você.';
        exit;
    }
}
?>
