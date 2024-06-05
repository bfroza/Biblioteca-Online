<?php

use PHPUnit\Framework\TestCase;

class LivroTest extends TestCase
{
    private $conexao;

    protected function setUp(): void
    {
        $this->conexao = new mysqli("localhost", "root", "", "biblioteca");
    
        if ($this->conexao->connect_error) {
            die("Falha na conexão com o banco de dados: " . $this->conexao->connect_error);
        }

       
        $autorExiste = $this->conexao->query("SELECT id FROM autores WHERE id = 9999")->num_rows > 0;
        if (!$autorExiste) {
            $this->conexao->query("INSERT INTO autores (id, nome, biografia) VALUES (9999, 'Autor Teste', 'Biografia Teste')");
            echo "Autor de teste criado.\n";
        }

    
        $categoriaExiste = $this->conexao->query("SELECT id FROM categorias WHERE nome = 'Categoria Teste'")->num_rows > 0;
        if (!$categoriaExiste) {
            $this->conexao->query("INSERT INTO categorias (nome) VALUES ('Categoria Teste')");
            echo "Categoria de teste criada.\n";
        }
    }

    protected function tearDown(): void
    {
        echo "Iniciando a limpeza após o teste...\n";

       
        $this->conexao->query("DELETE FROM autores_has_livros WHERE livros_id IN (SELECT id FROM livros WHERE titulo = 'Livro Teste')");
        echo "Associações livro-autor removidas.\n";

        $this->conexao->query("DELETE FROM livros WHERE titulo = 'Livro Teste'");
        echo "Livros de teste removidos.\n";
        
        $this->conexao->query("DELETE FROM autores WHERE id = 9999");
        echo "Autor de teste removido.\n";
        
        $this->conexao->query("DELETE FROM categorias WHERE nome = 'Categoria Teste'");
        echo "Categoria de teste removida.\n";

        $this->conexao->close();
    }

    public function testRegisterNewBook()
    {
        echo "Iniciando o teste de registro de novo livro...\n";

        $_SERVER['REQUEST_METHOD'] = 'POST';

        $_POST['title'] = 'Livro Teste';
        $_POST['author'] = 9999;
        $_POST['category'] = 'Categoria Teste';
        $_POST['pages'] = 100;
        $_POST['amount'] = 10;
        $_POST['publication-date'] = '2024';
        $_POST['rating'] = 4.5;
        $_POST['cover-image'] = 'http://example.com/capa.jpg';
        $_POST['description'] = 'Descrição de teste';

        ob_start();
        include 'php/livros/livro.php';
        $output = ob_get_clean();

        $livroRegistrado = $this->conexao->query("SELECT id FROM livros WHERE titulo = 'Livro Teste'")->num_rows > 0;
        $this->assertTrue($livroRegistrado);

        $this->assertStringContainsString('New record created successfully', $output);

        echo "Teste de registro de novo livro concluído.\n";
        echo "Livro registrado com sucesso.\n";
    }
}
