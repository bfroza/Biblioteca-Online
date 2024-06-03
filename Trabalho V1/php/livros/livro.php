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
                    <li><a href="../index/index.php" class="active"><i class='bx bx-home-heart' id="icon"></i> Discover</a></li>
                    <li><a href="../livros/livro.php"><i class='bx bxs-book-bookmark' ></i> Books</a></li>
                    <li><a href="../livros/lista-livros.php"><i class='bx bx-library'></i> My Library</a></li>
                    <li><a href="../autor/authores.php"><i class='bx bxs-edit'></i> Author</a></li>
                    <li><a href="#"><i class='bx bx-category'></i> Category</a></li>
                    <li><a href="#"><i class='bx bx-download'></i> Download</a></li>
                    <li><a href="#"><i class='bx bx-headphone'></i> Audio Books</a></li>
                    <li><a href="#"><i class='bx bx-heart'></i> Favourite</a></li>
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
                <h2>Register a New Book</h2>
                <form id="book-form" class="book-form" action="../livros/livro.php" method="POST">
                    <div class="form-group">
                        <label for="title">Book Title:</label>
                        <input type="text" id="title" name="title" placeholder="Enter book Title" minlength="3" required >
                    </div>
                    <div class="form-group">
                        <label for="author">Author:</label>
                        <select id="author" name="author" required>
                            <option value="" disabled selected>Choose an author</option>
                            <?php
                            include '../conexao/conexao.php';

                            $sql = "SELECT id, nome FROM autores";
                            $result = $conexao->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No authors available</option>";
                            }

                            $conexao->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select id="category" name="category" required>
                            <option value="" disabled selected>Choose a category</option>
                            <?php
                            include '../conexao/conexao.php';

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
                        <label for="pages">Number of Pages:</label>
                        <input type="number" id="pages" name="pages" placeholder="Enter number of pages" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" placeholder="Enter amount" required>
                    </div>
                    <div class="form-group">
                        <label for="publication-date">Publication Year:</label>
                        <input type="text" id="publication-year" name="publication-date" placeholder="Enter publication year" required>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating:</label>
                        <input type="number" id="rating" name="rating" step="0.1" min="0" max="5" placeholder="Enter rating" required>
                    </div>
                    <div class="form-group">
                        <label for="cover-image">Cover Image URL:</label>
                        <input type="url" id="cover-image" name="cover-image" placeholder="Enter cover image URL" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="4" placeholder="Enter book description" required></textarea>
                    </div>
                    <button type="submit" id="button-submit" class="submit-button">Submit</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>

<?php
include '../conexao/conexao.php';

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
