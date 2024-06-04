<?php
include '../conexao/conexao.php';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitiza o ID convertendo para inteiro
    $sql = "SELECT * FROM autores WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $autor = $result->fetch_assoc();
    } else {
        echo "Autor não encontrado.";
        exit;
    }
} else {
    echo "ID do autor não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBase</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/autor.css">
    <link rel="stylesheet" href="../../css/atualizar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../css/css-web/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/css-web/bs-admin.css">
    <link rel="stylesheet" href="../../css/css-web/select2.min.css">
    <link rel="stylesheet" href="../../css/css-web/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="../../css/css-web/font-awesome-all.min.css">
    <script src="../../js/sweetalert2.all.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
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
                    <li id><a href="#"><i class='bx bx-category'></i> Categoria</a></li>
                    <li><a href="#"><i class='bx bx-download'></i> Download</a></li>
                    <li><a href="#"><i class='bx bx-headphone'></i> Audio Books</a></li>
                    <li><a href="#"><i class='bx bx-heart'></i> Favoritos</a></li>
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
                <h1 class="mt-4">Atualizar Autor</h1>
                <br>
                <form name="cadastroForm" id="cadastroForm" method="post" action="atualiza.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="card">
                        <div class="card-header">
                            Dados do Autor
                        </div>
                        <div class="card-body">
                            <div class="row" style="padding: 10px;">
                                <div class="col-md-4">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($autor['nome']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="nacionalidade" class="form-label">Nacionalidade</label>
                                    <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" value="<?php echo htmlspecialchars($autor['nacionalidade']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="dataNasc" class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control" id="dataNasc" name="dataNasc" value="<?php echo htmlspecialchars($autor['dataNasc']); ?>">
                                </div>
                                <div class="col-md-12">
                                    <label for="biografia" class="form-label">Biografia</label>
                                    <textarea class="form-control" id="biografia" name="biografia" rows="4"><?php echo htmlspecialchars($autor['biografia']); ?></textarea>
                                </div>
                            </div>
                            <div class="row buttons-cadastro">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button id="btn-submit" class="btn btn-success btn-lg me-3" type="button">Atualizar</button>
                                    <button id="btn-cancelar" type="button" class="btn btn-danger btn-lg">Cancelar</button>
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
    const nomeOriginal = "<?php echo htmlspecialchars($autor['nome']); ?>";
    const nacionalidadeOriginal = "<?php echo htmlspecialchars($autor['nacionalidade']); ?>";
    const dataNascOriginal = "<?php echo htmlspecialchars($autor['dataNasc']); ?>";
    const biografiaOriginal = "<?php echo htmlspecialchars($autor['biografia']); ?>";

    document.getElementById('btn-submit').addEventListener('click', function() {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente atualizar os dados do autor?",
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
                document.getElementById('nome').value = nomeOriginal;
                document.getElementById('nacionalidade').value = nacionalidadeOriginal;
                document.getElementById('dataNasc').value = dataNascOriginal;
                document.getElementById('biografia').value = biografiaOriginal;
            }
        });
    });
});
</script>
