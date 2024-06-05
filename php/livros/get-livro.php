<?php
include_once "../conexao/conexao.php"; 
if (isset($_GET['id'])) {
    
    $livro_id = $_GET['id'];

    
    $sql = "SELECT * FROM adicionarlivro WHERE livro_id = $livro_id";

    
    $result = mysqli_query($conexao, $sql);

    
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $livro = mysqli_fetch_assoc($result);
            echo json_encode($livro);
        } else {
            
            echo json_encode(array("error" => "Livro não encontrado"));
        }
    } else {
        
        echo json_encode(array("error" => "Erro na consulta SQL: " . mysqli_error($conexao)));
    }
} else {
  
    echo json_encode(array("error" => "Parâmetro 'id' não fornecido na requisição"));
}


mysqli_close($conexao);
?>
