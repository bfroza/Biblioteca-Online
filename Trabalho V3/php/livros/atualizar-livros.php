<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBase</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/autor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../css/css-web/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/css-web/bs-admin.css">
    <link rel="stylesheet" href="../../css/css-web/select2.min.css">
    <link rel="stylesheet" href="../../css/css-web/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="../../css/css-web/font-awesome-all.min.css">
    <script src="../../js/sweetalert2.all.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .buttons-cadastro{
            padding: 30px;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
        }
    </style>
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
            <div class="container-fluid">
                <h1 class="mt-4">Atualizar Livro</h1>
                <br>
                <form name="cadastroForm" id="cadastroForm" method="post" action="atualiza-livro.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="card">
                        <div class="card-header">
                            Dados do Livro
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                include '../conexao/conexao.php';
                                
                                // Recuperar ID do livro da URL
                                $id = intval($_GET['id']);

                                // Consultar os dados do livro e do autor
                                $sql = "SELECT l.*, a.id AS autor_id, a.nome AS autor_nome 
                                        FROM livros l
                                        JOIN autores_has_livros ahl ON l.id = ahl.livros_id
                                        JOIN autores a ON ahl.autores_id = a.id
                                        WHERE l.id = ?";
                                $stmt = $conexao->prepare($sql);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $livro = $result->fetch_assoc();
                                ?>
                                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $livro['id']; ?>">
                                <div class="col-md-6">
                                    <label for="title" class="form-label">Título do Livro</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $livro['titulo']; ?>" minlength="3">
                                </div>
                                <div class="col-md-6">
                                    <label for="author" class="form-label">Autor</label>
                                    <select id="author" name="author" class="form-control">
                                        <option value="" disabled>Escolha um autor</option>
                                        <?php
                                        $sql = "SELECT id, nome FROM autores";
                                        $result = $conexao->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $selected = $row['id'] == $livro['autor_id'] ? 'selected' : '';
                                                echo "<option value='" . $row['id'] . "' $selected>" . $row['nome'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Nenhum autor disponível</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="category" class="form-label">Categoria</label>
                                    <select id="category" name="category" class="form-control">
                                        <option value="" disabled>Escolha uma categoria</option>
                                        <?php
                                        $sql = "SELECT id, nome FROM categorias";
                                        $result = $conexao->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $selected = $row['id'] == $livro['categoria_id'] ? 'selected' : '';
                                                echo "<option value='" . $row['id'] . "' $selected>" . $row['nome'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Nenhuma categoria disponível</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="pages" class="form-label">Número de Páginas</label>
                                    <input type="number" class="form-control" id="pages" name="pages" value="<?php echo $livro['numeroPag']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="amount" class="form-label">Quantidade</label>
                                    <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $livro['quantidade']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="publication-date" class="form-label">Ano de Publicação</label>
                                    <input type="text" class="form-control" id="publication-date" name="publication-date" value="<?php echo $livro['anoPubli']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="rating" class="form-label">Nota</label>
                                    <input type="number" class="form-control" id="rating" name="rating" step="0.1" min="0" max="5" value="<?php echo $livro['nota']; ?>">
                                </div>
                                <div class="col-md-12">
                                    <label for="cover-image" class="form-label">URL da Imagem de Capa</label>
                                    <input type="url" class="form-control" id="cover-image" name="cover-image" value="<?php echo $livro['imagem']; ?>">
                                </div>
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Descrição</label>
                                    <textarea id="description" class="form-control" name="description" rows="4" required><?php echo $livro['descricao']; ?></textarea>
                                </div>
                                <?php
                                } else {
                                    echo "<p>Livro não encontrado.</p>";
                                }
                                $stmt->close();
                                ?>
                            </div>
                            <div class="row buttons-cadastro">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button id="btn-submit" class="btn btn-success btn-lg me-3" type="button">Atualizar</button>
                                    <button id="btn-cancelar" type="button" class="btn
                                    btn-danger btn-lg">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleOriginal = "<?php echo htmlspecialchars($livro['titulo']); ?>";
    const authorOriginal = "<?php echo htmlspecialchars($livro['autor_id']); ?>";
    const categoryOriginal = "<?php echo htmlspecialchars($livro['categoria_id']); ?>";
    const pagesOriginal = "<?php echo htmlspecialchars($livro['numeroPag']); ?>";
    const amountOriginal = "<?php echo htmlspecialchars($livro['quantidade']); ?>";
    const publicationDateOriginal = "<?php echo htmlspecialchars($livro['anoPubli']); ?>";
    const ratingOriginal = "<?php echo htmlspecialchars($livro['nota']); ?>";
    const coverImageOriginal = "<?php echo htmlspecialchars($livro['imagem']); ?>";
    const descriptionOriginal = "<?php echo htmlspecialchars($livro['descricao']); ?>";

    document.getElementById('btn-submit').addEventListener('click', function() {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente atualizar os dados do livro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, atualizar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cadastroForm').submit();
            }
        });
    });

    document.getElementById('btn-cancelar').addEventListener('click', function() {
        Swal.fire({
            title: 'Cancelar alterações?',
            text: "Deseja realmente cancelar as alterações?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, cancelar!',
            cancelButtonText: 'Não, continuar editando'
        }).then((result) => {
            if (result.isConfirmed) {
                // Restaura os valores originais dos campos
                document.getElementById('title').value = titleOriginal;
                document.getElementById('author').value = authorOriginal;
                document.getElementById('category').value = categoryOriginal;
                document.getElementById('pages').value = pagesOriginal;
                document.getElementById('amount').value = amountOriginal;
                document.getElementById('publication-date').value = publicationDateOriginal;
                document.getElementById('rating').value = ratingOriginal;
                document.getElementById('cover-image').value = coverImageOriginal;
                document.getElementById('description').value = descriptionOriginal;
            }
        });
    });
});
</script>
