<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM autores";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nome"] . "</td>";
        echo "<td style='text-align: justify;'>" . $row["biografia"] . "</td>";
        echo "<td>" . $row["dataNasc"] . "</td>";
        echo "<td>" . $row["nacionalidade"] . "</td>";
        echo "<td>
                <i class='bx bxs-edit' style='color:#067500; cursor: pointer;' onclick='editarAutor(" . $row["id"] . ")'></i>
                <i class='bx bxs-trash' style='color:#d33; cursor: pointer;' onclick='confirmarDelecaoAutor(" . $row["id"] . ")'></i>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>Nenhum autor encontrado</td></tr>";
}

$conn->close();
?>
