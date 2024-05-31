<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBase</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/autor.css">
    <script src="../js/sweetalert2.all.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">BookBase</div>
            <nav>
                <ul>
                    <li><a href="../php/index.php" class="active"><i class='bx bx-home-heart' id="icon"></i> Discover</a></li>
                    <li><a href="../php/livro.php"><i class='bx bxs-book-bookmark' ></i> Books</a></li>
                    <li><a href="lista-livros.php"><i class='bx bx-library'></i> My Library</a></li>
                    <li><a href="#"><i class='bx bxs-edit'></i> Author</a></li>
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
            <section class="form-section">
                <h2>Register a New Book</h2>
                <form id="book-form" class="book-form" action="../php/livro.php" method="POST">
                    <div class="form-group">
                        <label for="title">Book Title:</label>
                        <input type="text" id="title" name="title" placeholder="Enter book Title" required>
                    </div>
                    <div class="form-group">
                        <label for="author">Author:</label>
                        <select id="author" name="author" required>
                        <option value="" disabled selected>Choose an author</option>
                        <?php
                        include 'conexao.php';

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
                    <input type="text" id="category" name="category" placeholder="Enter book category" required>
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
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conexao->prepare("INSERT INTO livros (titulo, categoria, numeroPag, quantidade, anoPubli, nota, imagem, descricao) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiidss", $title, $category, $pages, $amount, $publication_date, $rating, $cover_image, $description);

   
    $title = $_POST['title'];
    $author_id = $_POST['author']; 
    $category = $_POST['category'];
    $pages = $_POST['pages'];
    $amount = $_POST['amount'];
    $publication_date = $_POST['publication-date'];
    $rating = $_POST['rating'];
    $cover_image = $_POST['cover-image'];
    $description = $_POST['description'];
    
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
                        window.location = "../html/index.html";
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
}

$conexao->close();
?>
