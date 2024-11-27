<?php


$nome =$_POST[''];
$email =$_POST[''];
$data_atual= date('d/m/Y');
$hora_atual = date('H:i:s');

$server = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'banco_de_dados_fa';


$conn = new mysqli($server , $usuario, $senha,$banco );


if($conn->connect_errno){
    die("falha ao se conectar com banco de dados:".$conn->connect_errno);
}

$smtp = $conn->prepare("INSERT INTO banco_de_fa(nome,email)VALUES(?,?)");
$smtp->bind_param("ssss",null,null, $null,$null );

if($smtp->execute()){
    echo "cadastro enviado";
}else{
    echo "Erro no envio:".$smtp->error;
}

$smtp->close();
$conn->close();