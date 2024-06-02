<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM adicionarLivro";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["titulo"] . "</td>";
        echo "<td>" . $row["autor_nome"] . "</td>";
        echo "<td>" . $row["categoria_nome"] . "</td>";
        echo "<td>" . $row["numeroPag"] . "</td>";
        echo "<td>" . $row["quantidade"] . "</td>";
        echo "<td>" . $row["anoPubli"] . "</td>";
        echo "<td>" . $row["nota"] . "</td>";
        echo "<td><img src='" . $row["imagem"] . "' alt='" . $row["titulo"] . "' width='50'></td>";
        echo "<td style='text-align: justify;'>" . $row["descricao"] . "</td>";
        echo "<td>
                <i class='bx bxs-edit' style='color:#067500; cursor: pointer;' onclick='editarLivro(" . $row["livro_id"] . ")'></i>
                <i class='bx bxs-trash' style='color:#d33; cursor: pointer;' onclick='confirmarDelecao(" . $row["livro_id"] . ")'></i>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>Nenhum livro encontrado</td></tr>";
}

$conn->close();
?>
