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
        $row = mysqli_fetch_assoc($result);
    } else {
        echo 'A tarefa não existe ou não pertence a você.';
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarefa_id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_conclusao = $_POST['data_conclusao'];

    // Executar a consulta SQL para atualizar a tarefa
    $query = "UPDATE tarefas SET titulo = '$titulo', descricao = '$descricao', data_conclusao = '$data_conclusao' WHERE id = '$tarefa_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: main.php');
        exit;
    } else {
        echo 'Erro ao atualizar a tarefa. Tente novamente.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TarefasJa - Editar Tarefa</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Tarefa</h1>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="text" name="titulo" placeholder="Título" value="<?php echo $row['titulo']; ?>" required>
            <textarea name="descricao" placeholder="Descrição"><?php echo $row['descricao']; ?></textarea>
            <input type="date" name="data_conclusao" value="<?php echo $row['data_conclusao']; ?>" required>
            <input type="submit" value="Atualizar">
        </form>
    </div>
</body>
</html>
