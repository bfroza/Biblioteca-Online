<?php
include('conexao.php');

if(isset($_POST['idAutor'])) {
  
    $idAutor = mysqli_real_escape_string($conexao, $_POST['idAutor']);

   
    $sql_check_livros = "SELECT COUNT(*) AS total FROM autores_has_livros WHERE autores_id = '$idAutor'";
    $result = mysqli_query($conexao, $sql_check_livros);
    $data = mysqli_fetch_assoc($result);

    if($data['total'] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Este autor possui livros associados e não pode ser excluído.']);
    } else {
        $sql_remove_dependencias = "DELETE FROM autores_has_livros WHERE autores_id = '$idAutor'";

        if(mysqli_query($conexao, $sql_remove_dependencias)) {
          
            $sql_delete_autor = "DELETE FROM autores WHERE id = '$idAutor'";
            if(mysqli_query($conexao, $sql_delete_autor)) {
        
                echo json_encode(['status' => 'success', 'id' => $idAutor]);
            } else {
                
                echo json_encode(['status' => 'error', 'message' => 'Erro ao deletar o autor: ' . mysqli_error($conexao)]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao remover as dependências do autor: ' . mysqli_error($conexao)]);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID do autor não foi recebido.']);
}

mysqli_close($conexao);
?>
