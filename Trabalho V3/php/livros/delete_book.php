<?php
include('../conexao/conexao.php');


if(isset($_POST['idLivro'])) {
    $idLivro = mysqli_real_escape_string($conexao, $_POST['idLivro']);

    $sql_remove_dependencias = "DELETE FROM autores_has_livros WHERE livros_id = '$idLivro'";
    if(mysqli_query($conexao, $sql_remove_dependencias)) {
        $sql_delete_livro = "DELETE FROM livros WHERE id = '$idLivro'";
        if(mysqli_query($conexao, $sql_delete_livro)) {
            echo $idLivro;
        } else { 
            echo "Erro ao deletar o livro: " . mysqli_error($conexao);
        }
    } else {
        echo "Erro ao remover as dependências do livro: " . mysqli_error($conexao);
    }
} else {
   
    echo "ID do livro não foi recebido.";
}


mysqli_close($conexao);
?>