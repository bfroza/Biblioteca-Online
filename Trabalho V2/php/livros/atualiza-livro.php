<?php
include '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $livro_id = intval($_POST['id']);
    $titulo = $_POST['title'];
    $categoria_id = intval($_POST['category']);
    $numeroPag = intval($_POST['pages']);
    $quantidade = intval($_POST['amount']);
    $anoPubli = $_POST['publication-date'];
    $nota = floatval($_POST['rating']);
    $imagem = $_POST['cover-image'];
    $descricao = $_POST['description'];
    $autor_id = intval($_POST['author']);

    // Atualizar dados do livro
    $stmt = $conexao->prepare("UPDATE livros SET titulo=?, categoria_id=?, numeroPag=?, quantidade=?, anoPubli=?, nota=?, imagem=?, descricao=? WHERE id=?");
    $stmt->bind_param("siisidssi", $titulo, $categoria_id, $numeroPag, $quantidade, $anoPubli, $nota, $imagem, $descricao, $livro_id);

    if ($stmt->execute()) {
        // Atualizar autor associado ao livro
        $stmt_autor_livro = $conexao->prepare("UPDATE autores_has_livros SET autores_id=? WHERE livros_id=?");
        $stmt_autor_livro->bind_param("ii", $autor_id, $livro_id);

        if ($stmt_autor_livro->execute()) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
            
                    window.location.href = "lista-livros.php";
                    
                
            </script>';
        } else {
            echo 'error';
        }

        $stmt_autor_livro->close();
    } else {
        echo 'error';
    }

    $stmt->close();
}

$conexao->close();
?>
