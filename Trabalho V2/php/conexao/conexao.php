<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "biblioteca";

$conexao = mysqli_connect($servidor, $usuario, $senha, $dbname);

if (!$conexao) {
    die("Houve um erro ao conectar ao banco de dados: " . mysqli_connect_error());
} else {
    
}
?>
