<?php
include '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']); 
        
        if (!empty($_POST['nome']) && !empty($_POST['nacionalidade']) && !empty($_POST['dataNasc']) && !empty($_POST['biografia'])) {
           
            $nome = $_POST['nome'];
            $nacionalidade = $_POST['nacionalidade'];
            $dataNasc = $_POST['dataNasc'];
            $biografia = $_POST['biografia'];
          
            $sql = "UPDATE autores SET nome=?, nacionalidade=?, dataNasc=?, biografia=? WHERE id=?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssssi", $nome, $nacionalidade, $dataNasc, $biografia, $id);
            if ($stmt->execute()) {
                echo '<script>
                    window.location.href = "authores.php";
                      
                </script>';

            } else {
                echo "Erro ao atualizar os dados do autor: " . $conexao->error;
            }
            $stmt->close();
        } else {
            echo "Por favor, preencha todos os campos.";
        }
    } else {
        echo "ID do autor não fornecido.";
    }
}
$conexao->close();
?>
