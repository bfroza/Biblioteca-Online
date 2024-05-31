<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBase</title>
    <link rel="stylesheet" href="../css/styles.css">
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
                    <li><a href="#"><i class='bx bx-cog sidebar-icon' ></i>Settings</a></li>
                    <li><a href="#"><i class='bx bx-support sidebar-icon' ></i>Support</a></li>
                    <li><a href="#"><i class='bx bx-log-in sidebar-icon' ></i>Logout</a></li>
                </ul>
            </div>
        </aside>
        <main>
            <header>
                <div class="input-box">
                    <i class='bx bx-search'></i>
                    <input type="text" id="input_search" onkeyup="pesquisarLivros()" placeholder="Search your favourite books">

                </div>  
                <div class="user-profile">
                    <img src="https://via.placeholder.com/40" alt="User Avatar">
                    <span>Your Name</span>
                </div>
            </header>
            <section class="recommended">
                <h2>Recommended <a href="#" class="see-all">See All ></a></h2>
                <div class="book-list">
                    <?php
                    include_once "conexao.php";

                    $sql = "SELECT livros.id AS livro_id, livros.titulo, livros.categoria, livros.numeroPag, livros.quantidade, livros.anoPubli, livros.nota,
                                   livros.imagem, livros.descricao,
                                   autores.nome AS autor_nome
                            FROM livros
                            JOIN autores_has_livros ON livros.id = autores_has_livros.livros_id
                            JOIN autores ON autores.id = autores_has_livros.autores_id";

                    $result = mysqli_query($conexao, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="book" onclick="handleBookClick(' . $row["livro_id"] . ')">';
                            echo '<img src="' . $row["imagem"] . '" alt="' . $row["titulo"] . '">';
                            echo '<p>' . $row["titulo"] . '</p>';
                            echo '<p class="author">' . $row["autor_nome"] . '</p>';
                            echo '</div>';
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
                    <button class="category active">All</button>
                    <button class="category">Sci-Fi</button>
                    <button class="category">Fantasy</button>
                    <button class="category">Drama</button>
                    <button class="category">Business</button>
                    <button class="category">Education</button>
                    <button class="category">Geography</button>
                </div>
                <div class="book-list">
                <?php
                    $result = mysqli_query($conexao, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="book-list">';
                            echo '<div class="book" onclick="handleBookClick(' . $row["livro_id"] . ')">';
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
                </div>
            </section>
        </main>
       
        <aside class="book-details">
            <img src="https://m.media-amazon.com/images/I/51U-1ilSDEL._AC_UF1000,1000_QL80_.jpg" alt="Book Cover" id="book-cover">
            <h2 id="book-title">Cem Anos de Solidão</h2>
            <p id="book-author">Gabriel García Márquez</p>
            <p class="rating">
                <span class="stars"><i class='bx bxs-star' style='color: gold;'></i>
                <i class='bx bxs-star' style='color: gold;'></i>
                <i class='bx bxs-star' style='color: gold;'></i><i class='bx bxs-star' style='color: gold;'></i>
                <i class='bx bxs-star-half' style='color: gold;'></i></span>
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
            <p class="description" id="book-description"> Em Cem anos de solidão , um dos maiores clássicos da literatura, o prestigiado autor narra a incrível e triste história dos Buendía - a estirpe de solitários para a qual não será dada “uma segunda oportunidade sobre a terra” e apresenta o maravilhoso universo da fictícia Macondo, onde se passa o romance.</p>
            <button class="read-now">Read Now <i class='bx bx-book-reader'></i></button>
        </aside>
    </div>
    <script>
        function handleBookClick(bookId) {
            
            fetchBookInfo(bookId)
                .then(book => {
                   
                })
                .catch(error => {
                    console.error('Erro ao buscar informações do livro:', error);
                });
        }

        function fetchBookInfo(bookId) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                console.log(typeof(bookId))
                xhr.open('GET', 'http://localhost/Trabalho%20V1/php/get-livro.php?id=' + bookId, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const bookData = JSON.parse(xhr.responseText);
                        resolve(bookData);
                        console.log(bookData)
                        document.getElementById('book-cover').src = bookData.imagem;
                        document.getElementById('book-title').textContent = bookData.titulo;
                        document.getElementById('book-author').textContent = bookData.autor_nome;
                        document.getElementById('book-rating').textContent = bookData.nota;
                        calculateStars(bookData.nota);
                        document.getElementById('book-pages').textContent = bookData.numeroPag;
                        document.getElementById('book-ratings').textContent = 45;
                        document.getElementById('book-reviews').textContent = 434;
                        document.getElementById('book-description').textContent = bookData.descricao;
                    } else {
                        reject(new Error('Erro ao buscar informações do livro'));
                    }
                };
                xhr.onerror = function () {
                    reject(new Error('Erro de conexão'));
                };
                xhr.send();
            });
        }

        function calculateStars(rating) {
            const ratingElement = document.querySelector(".rating-value");
            const starsElement = document.querySelector(".stars");
            const totalStars = 5;
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 !== 0;
            const emptyStars = totalStars - fullStars - (hasHalfStar ? 1 : 0);

            starsElement.innerHTML = '';

            for (let i = 0; i < fullStars; i++) {
                starsElement.innerHTML += "<i class='bx bxs-star' style='color: gold;'></i>";
            }

            if (hasHalfStar) {
                starsElement.innerHTML += "<i class='bx bxs-star-half' style='color: gold;'></i>";
            }

            for (let i = 0; i < emptyStars; i++) {
                starsElement.innerHTML += "<i class='bx bxs-star' style='color: lightgray;'></i>";
            }
        }

        function pesquisarLivros() {
            var input, filter, bookLists, books, book, title, author, i, j, txtValueTitle, txtValueAuthor;
            input = document.getElementById("input_search");
            filter = input.value.toUpperCase();
            bookLists = document.querySelectorAll(".book-list");

            for (i = 0; i < bookLists.length; i++) {
                books = bookLists[i].getElementsByClassName("book");
                for (j = 0; j < books.length; j++) {
                    book = books[j];
                    title = book.querySelector("p").textContent.toUpperCase();
                    author = book.querySelector(".author").textContent.toUpperCase();
                    if (title.indexOf(filter) > -1 || author.indexOf(filter) > -1) {
                        book.style.display = "";
                    } else {
                        book.style.display = "none";
                    }
                }
            }
        }


    </script>
</body>
</html>
