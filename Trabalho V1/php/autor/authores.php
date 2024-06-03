<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBase</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/view-users.css">
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
      
        <main class="container-fluid">
            <h1>Lista de Authores</h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 pb-3">
                                <input type="text" id="searchInput" placeholder="Pesquisar..." onkeyup="pesquisarAutores()">
                                <button class="btn btn-primary" onclick="window.location.href='../autor/author.php'">
                                    <i class="fa fa-plus"></i> Novo Autor
                                </button>
                            </div>
                            <table class="table table-bordered table-hover" id="dados">
                                <thead>
                                    <tr>
                                        <th scope="col">Autor</th>
                                        <th scope="col">Biografia</th>
                                        <th scope="col">Data de Nascimento</th>
                                        <th scope="col">Nacionalidade</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include '../autor/listar_autores.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </div>
</body>
</html>

<script>
function pesquisarAutores() {
    var input, filter, table, tr, i, txtValueAuthor;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase(); 
    table = document.getElementById("dados");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        var tdAuthor = tr[i].getElementsByTagName("td")[1]; 
        if (tdAuthor) {
            txtValueAuthor = tdAuthor.textContent || tdAuthor.innerText;
            if (txtValueAuthor.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}

function editarAutor(id) {
    window.location.href = '../autor/atualizar-author.php?id=' + id;
}


function confirmarDelecaoAutor(id) {
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deletarAutor(id);
                }
            });
        }

        function deletarAutor(id) {
            const idAutor = id;
            $.ajax({
                url: 'http://localhost/Trabalho%20V1/php/autor/delete-autor.php',
                type: 'POST',
                data: { idAutor: idAutor }, 
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire(
                            'Deletado!',
                            'O autor foi deletado com sucesso.',
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire(
                            'Erro!',
                            res.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Erro!',
                        'Houve um problema ao deletar o autor.',
                        'error'
                    );
                }
            });
        }
</script>
