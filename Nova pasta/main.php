<?php
// Verificar se o usuário está autenticado, caso contrário, redirecionar para a página de login
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit;
}

// db_connection.php contém as configurações de conexão com o banco de dados
require_once 'db_connection.php';

// Função para obter todas as tarefas do usuário atual
function getTasks($conn, $usuario_id) {
    $query = "SELECT * FROM tarefas WHERE usuario_id = '$usuario_id' ORDER BY data_criacao DESC";
    $result = mysqli_query($conn, $query);
    $tasks = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $row;
        }
    }

    return $tasks;
}

// Obter as tarefas do usuário atual
$usuario_id = $_SESSION['usuario_id'];
$tasks = getTasks($conn, $usuario_id);

?>
<!DOCTYPE html>
<html>
<head>
    <title>TarefasJa - Gerenciar Tarefas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?></h1>

        <h2>Minhas Tarefas</h2>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Data de Criação</th>
                    <th>Data de Conclusão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo $task['titulo']; ?></td>
                        <td><?php echo $task['descricao']; ?></td>
                        <td><?php echo $task['data_criacao']; ?></td>
                        <td><?php echo $task['data_conclusao']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $task['id']; ?>">Editar</a>
                            <a href="delete.php?id=<?php echo $task['id']; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Adicionar Tarefa</h2>
        <form action="add.php" method="post">
            <input type="text" name="titulo" placeholder="Título" required>
            <textarea name="descricao" placeholder="Descrição"></textarea>
            <input type="date" name="data_conclusao" required>
            <input type="submit" value="Adicionar">
        </form>

        <!-- Adicione o link ou botão para fazer logout -->
<a href="logout.php">Logout</a>

    </div>
    <script>
    // Função para exibir um pop-up de sucesso
function exibirPopUp(mensagem) {
  alert(mensagem);
}

// Adicionar Tarefa
document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault(); // Impede o envio do formulário

  // Lógica para adicionar a tarefa

  // Exibir pop-up de sucesso
  exibirPopUp('Tarefa adicionada com sucesso!');
});

// Editar Tarefa
document.querySelectorAll('a.edit').forEach(function(link) {
  link.addEventListener('click', function(event) {
    event.preventDefault(); // Impede o redirecionamento

    // Lógica para editar a tarefa

    // Exibir pop-up de sucesso
    exibirPopUp('Tarefa editada com sucesso!');
  });
});

// Excluir Tarefa
document.querySelectorAll('a.delete').forEach(function(link) {
  link.addEventListener('click', function(event) {
    event.preventDefault(); // Impede o redirecionamento

    // Lógica para excluir a tarefa

    // Exibir pop-up de sucesso
    exibirPopUp('Tarefa excluída com sucesso!');
  });
});
</script>
<!-- Adicione o link ou botão para fazer logout -->


</body>
</html>
