<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBase</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="../../js/Index-JS/books-details.js"></script>
    <script src="../../js/Index-JS/category.js"></script>
    <script src="../../js/Index-JS/filter-book.js"></script>
    <script src="../../js/Index-JS/see-all-only.js"></script>
    <script src="../../js/Index-JS/calculate-star.js"></script>
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
            <header>
                <div class="input-box">
                    <i id="menu" class="bx bx-menu" id="sidebar-toggle"></i>
                    <i class='bx bx-search'></i>
                    <input type="text" id="input_search" onkeyup="pesquisarLivros()"
                        placeholder="Search your favourite books">
                </div>
                <div class="user-profile">
                    <img src="https://via.placeholder.com/40" alt="User Avatar">
                    <span>Your Name</span>
                </div>
            </header>
            <section class="recommended">
                <h2>Recommended <a href="#" class="see-all" onclick="toggleBooksDisplay(event)">See All ></a></h2>
                <div class="book-list">
                    <?php
                    include_once "../conexao/conexao.php";

                    $sql = "SELECT livros.id AS livro_id, livros.titulo, categorias.id AS categoria_id, categorias.nome AS categoria_nome, livros.numeroPag, livros.quantidade, livros.anoPubli, livros.nota,
                    livros.imagem, livros.descricao,
                    autores.nome AS autor_nome
                    FROM livros
                    JOIN autores_has_livros ON livros.id = autores_has_livros.livros_id
                    JOIN autores ON autores.id = autores_has_livros.autores_id
                    JOIN categorias ON livros.categoria_id = categorias.id ORDER BY livros.nota DESC";

                    $result = mysqli_query($conexao, $sql);

                    $counter = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $hiddenClass = $counter >= 7 ? 'hidden' : '';
                            echo '<div class="book ' . $hiddenClass . '" data-category="' . $row["categoria_id"] . '" onclick="handleBookClick(' . $row["livro_id"] . ')">';
                            echo '<img src="' . $row["imagem"] . '" alt="' . $row["titulo"] . '">';
                            echo '<p>' . $row["titulo"] . '</p>';
                            echo '<p class="author">' . $row["autor_nome"] . '</p>';
                            echo '</div>';
                            $counter++;
                        }
                    } else {
                        echo "Nenhum livro encontrado.";
                    }
                    ?>
                </div>
            </section>
            <section class="categories">
                <h2>Categories</h2>
                <div class="category-list">
                    <?php
                    $sql_categories = "SELECT * FROM categorias";
                    $result_categories = mysqli_query($conexao, $sql_categories);

                    if (mysqli_num_rows($result_categories) > 0) {
                        echo '<button class="category active" data-category="all" onclick="filterBooksByCategory(this)">All</button>';
                        while ($row_cat = mysqli_fetch_assoc($result_categories)) {
                            echo '<button class="category" data-category="' . $row_cat["id"] . '" onclick="filterBooksByCategory(this)">' . $row_cat["nome"] . '</button>';
                        }
                    } else {
                        echo "Nenhuma categoria encontrada.";
                    }
                    ?>
                </div>
                <div class="book-list">
                    <?php
                    $sql = "SELECT livros.id AS livro_id, livros.titulo, categorias.id AS categoria_id, categorias.nome AS categoria_nome, livros.numeroPag, livros.quantidade, livros.anoPubli, livros.nota,
                livros.imagem, livros.descricao,
                autores.nome AS autor_nome
                FROM livros
                JOIN autores_has_livros ON livros.id = autores_has_livros.livros_id
                JOIN autores ON autores.id = autores_has_livros.autores_id
                JOIN categorias ON livros.categoria_id = categorias.id 
                ORDER BY livros.titulo"; // Ordenar por nome do livro
                    
                    $result = mysqli_query($conexao, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="book" data-category="' . $row["categoria_id"] . '" onclick="handleBookClick(' . $row["livro_id"] . ')">';
                            echo '<img src="' . $row["imagem"] . '" alt="' . $row["titulo"] . '">';
                            echo '<p>' . $row["titulo"] . '</p>';
                            echo '<p class="author">' . $row["autor_nome"] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "Nenhum livro encontrado.";
                    }
                    mysqli_close($conexao);
                    ?>
                </div>
            </section>


        </main>
        <aside class="book-details">
            <img src="https://m.media-amazon.com/images/I/51U-1ilSDEL._AC_UF1000,1000_QL80_.jpg" alt="Book Cover"
                id="book-cover">
            <h2 id="book-title">Cem Anos de Solidão</h2>
            <p id="book-author">Gabriel García Márquez</p>
            <p class="rating">
                <span class="stars">
                    <i class='bx bxs-star' style='color: gold;'></i>
                    <i class='bx bxs-star' style='color: gold;'></i>
                    <i class='bx bxs-star' style='color: gold;'></i>
                    <i class='bx bxs-star' style='color: gold;'></i>
                    <i class='bx bxs-star-half' style='color: gold;'></i>
                </span>
                <span id="book-rating" class="rating-value">4.6</span>
            </p>
            <p class="details">
            <div class="detail-item">
                <span id="book-pages">416</span>
                <span>Pages</span>
            </div>
            <div class="detail-item">
                <span id="book-ratings">45</span>
                <span>Ratings</span>
            </div>
            <div class="detail-item">
                <span id="book-reviews">434</span>
                <span>Reviews</span>
            </div>
            </p>
            <p class="description" id="book-description">
                Em Cem anos de solidão , um dos maiores clássicos da literatura, o prestigiado autor narra a incrível e
                triste história dos Buendía - a estirpe de solitários para a qual não será dada “uma segunda
                oportunidade sobre a terra” e apresenta o maravilhoso universo da fictícia Macondo, onde se passa o
                romance.
            </p>
            <button class="read-now">Read Now <i class='bx bx-book-reader'></i></button>
        </aside>
    </div>

    <script>
        const sidebarToggle = document.getElementById('menu');
        const sidebar = document.querySelector('.sidebar');

        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });

        const closeSidebarButton = document.querySelector('.close-sidebar');


        closeSidebarButton.addEventListener('click', function() {
            sidebar.classList.remove('active');

});
    </script>