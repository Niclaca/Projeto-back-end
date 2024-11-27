<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Substitua pelo seu usuário do MySQL
$password = ""; // Substitua pela sua senha do MySQL
$dbname = "cadastro_artistas";

// Criar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Coletando os dados do formulário
    $nome = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefone = $conn->real_escape_string($_POST['phone']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // A senha será tratada abaixo (hash)
    $genero_musical = $conn->real_escape_string($_POST['music-genre']);
    $biografia = $conn->real_escape_string($_POST['biography']);
    $link_musica = $conn->real_escape_string($_POST['music-link']);
    $website = $conn->real_escape_string($_POST['website']);

    // Tratamento da senha (hash)
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Verificar se o arquivo de imagem foi enviado
    if (isset($_FILES['profile-photo']) && $_FILES['profile-photo']['error'] == 0) {
        $foto_perfil = "uploads/" . basename($_FILES['profile-photo']['name']);

        // Verificar se o diretório 'uploads' existe, caso contrário, criar
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true); // Cria o diretório com permissões adequadas
        }

        // Movendo o arquivo para a pasta 'uploads'
        if (!move_uploaded_file($_FILES['profile-photo']['tmp_name'], $foto_perfil)) {
            echo "Erro ao enviar a foto de perfil.";
            exit;
        }
    } else {
        $foto_perfil = NULL; // Caso não tenha sido enviado um arquivo de foto, será NULL
    }

    // Preparando e executando a query para inserir os dados no banco
    $sql = "INSERT INTO artistas (nome, email, telefone, nome_usuario, senha, genero_musical, foto_perfil, biografia, link_musica, website) 
            VALUES ('$nome', '$email', '$telefone', '$username', '$password_hash', '$genero_musical', '$foto_perfil', '$biografia', '$link_musica', '$website')";

    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
} else {
    echo "Nenhum dado foi enviado.";
}
?>
