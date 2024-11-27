<?php
// Conectar ao banco de dados MySQL
$servername = "localhost";
$username = "root"; // substitua pelo seu nome de usuário
$password = ""; // substitua pela sua senha
$dbname = "clientes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter dados do formulário
$nome = $_POST['name'];
$email = $_POST['email'];
$telefone = $_POST['phone'];
$nome_usuario = $_POST['username'];
$senha = $_POST['password'];
$genero = $_POST['gender'];

// Validar se as senhas coincidem
if ($_POST['password'] != $_POST['confirm-password']) {
    die("As senhas não coincidem.");
}

// Hash da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir dados no banco de dados
$sql = "INSERT INTO clientes (nome, email, telefone, nome_usuario, senha, genero) 
        VALUES ('$nome', '$email', '$telefone', '$nome_usuario', '$senha_hash', '$genero')";

if ($conn->query($sql) === TRUE) {
    echo "Novo cliente cadastrado com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
