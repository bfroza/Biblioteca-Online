<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBase</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/autor.css">
    <script src="../../js/sweetalert2.all.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
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
        <main id="author-container">
            <section class="form-section">
                <h2>Register a New Author</h2>
                <form id="author-form" class="author-form" action="../autor/author.php" method="POST">
                    <div class="form-group">
                        <label for="name">Author Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter Author Name" required>
                    </div>
                    <div class="form-group">
                        <label for="biografy">Author Biografy:</label>
                        <textarea id="biografy" name="biografy" rows="4" placeholder="Enter Author Biografy" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="birth">Author Date of Birth:</label>
                        <input type="date" id="birth" name="birth" placeholder="Enter Author Birth" required>
                    </div>
                    <div class="form-group">
                        <label for="nationality">Author Nationality:</label>
                        <input type="text" id="nationality" name="nationality" placeholder="Enter Author Nationality" required>
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
    $stmt = $conexao->prepare("INSERT INTO autores (nome, biografia, dataNasc, nacionalidade) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $biografy, $birth, $nationality);

    $name = $_POST['name'];
    $biografy = $_POST['biografy']; 
    $birth = $_POST['birth'];
    $nationality = $_POST['nationality'];
    
    if ($stmt->execute()) {
        $author_id = $stmt->insert_id;

        echo '<script>
                Swal.fire({
                    title: "Success",
                    text: "New record created successfully",
                    icon: "success"
                }).then(function() {
                    window.location = "../autor/authores.php";
                });
              </script>';
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
