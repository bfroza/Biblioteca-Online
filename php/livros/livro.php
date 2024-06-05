<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBase</title>
    <link rel="stylesheet" href="../../css/livro.css">
    <link rel="stylesheet" href="../../css/styles.css">

    <script src="../../js/sweetalert2.all.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<body>
    <div class="container" style="overflow-y: auto;">
        <aside class="sidebar " style="height:auto">
        <div class="sidebar-header">
            <div class="close-sidebar">
            <i id="close" class='bx bxs-caret-left-circle' ></i>
            </div>
        </div>
            <div class="logo">BookBase</div>
            <nav>
                <ul>
                    <li><a href="../index/index.php" class="active"><i class='bx bx-home-heart' id="icon"></i> Descubra</a></li>
                    <li><a href="../livros/lista-livros.php"><i class='bx bx-library'></i> Livraria</a></li>
                    <li><a href="../autor/authores.php"><i class='bx bxs-edit'></i> Autores</a></li>
                    <li class="disabled"><a href="#"><i class='bx bx-category'></i> Categorias</a></li>
                    <li class="disabled"><a href="#"><i class='bx bx-heart'></i> Favoritos</a></li>
                    <li class="disabled"><a href="#"><i class='bx bx-book-reader'></i> Livros Lidos</a></li>
                    <li class="disabled"><a href="#"><i class='bx bx-download'></i> Download</a></li>
                </ul>
            </nav>
            <div class="sidebar-bottom">
                <ul>
                    <li><a href="#"><i class='bx bx-cog sidebar-icon'></i>Settings</a></li>
                    <li><a href="#"><i class='bx bx-support sidebar-icon'></i>Support</a></li>
                    <li><a href="#"><i class='bx bx-log-in sidebar-icon'></i>Logout</a></li>
                </ul>
            </div>
        </aside>
        <main>
            <section class="form-section" style="overflow-x: auto;">
                <h2>Registrar Novo Livro</h2>
                <form id="book-form" class="book-form" action="../livros/livro.php" method="POST">
                    <div class="form-group">
                        <label for="title">Título do Livro:</label>
                        <input type="text" id="title" name="title" placeholder="Digite o Título do Livro" minlength="3" required >
                    </div>
                    <div class="form-group">
                        <label for="author">Autor:</label>
                        <select id="author" name="author" required>
                            <option value="" disabled selected>Escolha o autor</option>
                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "biblioteca";
                            
                            $conexao = new mysqli($servername, $username, $password, $dbname);

                            $sql = "SELECT id, nome FROM autores";
                            $result = $conexao->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Escolha o autor</option>";
                            }

                            $conexao->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Categoria:</label>
                        <select id="category" name="category" required>
                            <option value="" disabled selected>Escolha a categoria</option>
                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "biblioteca";
                            
                            $conexao = new mysqli($servername, $username, $password, $dbname);

                            $sql = "SELECT nome FROM categorias";
                            $result = $conexao->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['nome'] . "'>" . $row['nome'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No categories available</option>";
                            }

                            $conexao->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pages">Número de Páginas:</label>
                        <input type="number" id="pages" name="pages" placeholder="Digite o número de páginas" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Quantidade:</label>
                        <input type="number" id="amount" name="amount" placeholder="Digite a quantidade" required>
                    </div>
                    <div class="form-group">
                        <label for="publication-date">Ano de Publicação:</label>
                        <input type="text" id="publication-year" name="publication-date" placeholder="Digite o Ano de Publicação" required>
                    </div>
                    <div class="form-group">
                        <label for="rating">Nota:</label>
                        <input type="number" id="rating" name="rating" step="0.1" min="0" max="5" placeholder="Digite a  nota" required>
                    </div>
                    <div class="form-group">
                        <label for="cover-image">URL da Imagem:</label>
                        <input type="url" id="cover-image" name="cover-image" placeholder="Digite a URL da Imagem" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição:</label>
                        <textarea id="description" name="description" rows="4" placeholder="Digite a Descrição" required></textarea>
                    </div>
                    <button type="submit" id="button-submit" class="submit-button">Enviar</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conexao = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = $_POST['title'];
    $author_id = $_POST['author'];
    $category = $_POST['category'];
    $pages = $_POST['pages'];
    $amount = $_POST['amount'];
    $publication_date = $_POST['publication-date'];
    $rating = $_POST['rating'];
    $cover_image = $_POST['cover-image'];
    $description = $_POST['description'];

    
    $stmt_categoria = $conexao->prepare("SELECT id FROM categorias WHERE nome = ?");
    $stmt_categoria->bind_param("s", $category);
    $stmt_categoria->execute();
    $result_categoria = $stmt_categoria->get_result();

    
    if ($result_categoria->num_rows > 0) {
        $row_categoria = $result_categoria->fetch_assoc();
        $categoria_id = $row_categoria['id'];

    
        $stmt = $conexao->prepare("INSERT INTO livros (titulo, categoria_id, numeroPag, quantidade, anoPubli, nota, imagem, descricao) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siididss", $title, $categoria_id, $pages, $amount, $publication_date, $rating, $cover_image, $description);

       
        if ($stmt->execute()) {
            $livro_id = $stmt->insert_id;

            
            $stmt_autor_livro = $conexao->prepare("INSERT INTO autores_has_livros (autores_id, livros_id) VALUES (?, ?)");
            $stmt_autor_livro->bind_param("ii", $author_id, $livro_id);

           
            if ($stmt_autor_livro->execute()) {
                echo '<script>
                        Swal.fire({
                            title: "Success",
                            text: "New record created successfully",
                            icon: "success"
                        }).then(function() {
                            window.location = "../index/index.php";
                        });
                      </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "Error associating author with book: ' . $stmt_autor_livro->error . '",
                            icon: "error"
                        });
                      </script>';
            }

            $stmt_autor_livro->close();
        } else {
            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Error creating new record: ' . $stmt->error . '",
                        icon: "error"
                    });
                  </script>';
        }

        $stmt->close();
    } else {
        echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "Selected category not found",
                    icon: "error"
                });
              </script>';
    }

    $stmt_categoria->close();
}

$conexao->close();
?>
