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
</style>
<body>
    <div class="container">
        <aside class="sidebar">
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
      
        <div class="container-fluid">
            <h1>Lista de Livros</h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 pb-3">
                                <input type="text" id="searchInput" placeholder="Pesquisar..." onkeyup="pesquisarLivros()">
                                <button class="btn btn-primary" onclick="window.location.href='../livros/livro.php'">
                                    <i class="fa fa-plus"></i> Novo Livro
                                </button>
                            </div>
                            <table class="table table-bordered table-hover" id="dados">
                                <thead>
                                    <tr>
                                        <th scope="col">Título</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Número de Páginas</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Ano de Publicação</th>
                                        <th scope="col">Nota</th>
                                        <th scope="col">Imagem</th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include '../livros/listar_livros.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form name="edita_livro">
            <input type="hidden" name="id_livro" id="id_livro">
            <input type="hidden" name="acao" id="acao" value="editar">
        </form>

        <form name="deleta_livro">
            <input type="hidden" name="id_livro" id="deleta_livro">
            <button type="button" onclick="deletarLivro(<?php echo $id_livro; ?>)">
        <i class="fa fa-trash"></i> 
</button>

        </form>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    </div>
</body>
</html>


<script>
function pesquisarLivros() {
    var input, filter, table, tr, i, txtValueTitle, txtValueAuthor;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase(); 
    table = document.getElementById("dados");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        var tdTitle = tr[i].getElementsByTagName("td")[0];
        var tdAuthor = tr[i].getElementsByTagName("td")[1]; 
        if (tdTitle || tdAuthor) {
            txtValueTitle = tdTitle.textContent || tdTitle.innerText;
            txtValueAuthor = tdAuthor.textContent || tdAuthor.innerText;
            if (txtValueTitle.toUpperCase().indexOf(filter) > -1 || txtValueAuthor.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}


function editarLivro(id) {
    window.location.href = '../livros/atualizar-livros.php?id=' + id;
}


function confirmarDelecao(id) {
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
                    deletarLivro(id);
                }
            });
        }

        function deletarLivro(id) {
            const idLivro = id;
            $.ajax({
                url: 'http://localhost/Trabalho%20V1/php/livros/delete_book.php',
                type: 'POST',
                data: { idLivro: idLivro },
                success: function(response) {
                    Swal.fire(
                        'Deletado!',
                        'O livro foi deletado com sucesso.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Erro!',
                        'Houve um problema ao deletar o livro.',
                        'error'
                    );
                }
            });
        }



</script>


