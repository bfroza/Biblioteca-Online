<?php
include_once "conexao.php"; // Inclui o arquivo de conexão com o banco de dados

// Verifica se o parâmetro 'id' foi passado na requisição GET
if (isset($_GET['id'])) {
    // Obtém o ID do livro da requisição GET
    $livro_id = $_GET['id'];

    // Consulta SQL para buscar as informações do livro com base no ID
    $sql = "SELECT * FROM adicionarlivro WHERE livro_id = $livro_id";

    // Executa a consulta
    $result = mysqli_query($conexao, $sql);

    // Verifica se a consulta retornou algum resultado
    if ($result) {
        // Verifica se encontrou o livro com o ID fornecido
        if (mysqli_num_rows($result) > 0) {
            // Obtém os dados do livro
            $livro = mysqli_fetch_assoc($result);
            
            // Retorna os dados do livro como um JSON
            echo json_encode($livro);
        } else {
            // Retorna um erro indicando que o livro não foi encontrado
            echo json_encode(array("error" => "Livro não encontrado"));
        }
    } else {
        // Retorna um erro indicando que houve um problema com a consulta SQL
        echo json_encode(array("error" => "Erro na consulta SQL: " . mysqli_error($conexao)));
    }
} else {
    // Retorna um erro indicando que o parâmetro 'id' não foi fornecido
    echo json_encode(array("error" => "Parâmetro 'id' não fornecido na requisição"));
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
