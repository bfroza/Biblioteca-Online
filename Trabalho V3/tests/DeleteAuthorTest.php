<?php

use PHPUnit\Framework\TestCase;

class DeleteAuthorTest extends TestCase
{
    private $conexao;

    protected function setUp(): void
    {
        echo "Configuração inicial do teste.\n";

        $this->conexao = new mysqli("localhost", "root", "", "biblioteca");
    
        if ($this->conexao->connect_error) {
            die("Falha na conexão com o banco de dados: " . $this->conexao->connect_error);
        }
    
        $autorExiste = $this->conexao->query("SELECT id FROM autores WHERE id = 9999")->num_rows > 0;
        
        if (!$autorExiste) {
            $this->conexao->query("INSERT INTO autores (id, nome, biografia) VALUES (9999, 'Autor Teste', 'Biografia Teste')");
            echo "Autor de teste criado.\n";
        } else {
            echo "Autor de teste já existe.\n";
        }
    }
    
    protected function tearDown(): void
    {
        echo "Limpeza após o teste.\n";

        $this->conexao->query("DELETE FROM autores WHERE id = 9999");
        $this->conexao->query("DELETE FROM autores_has_livros WHERE autores_id = 9999");
        $this->conexao->close();

        echo "Autor de teste removido.\n";
    }

    public function testDeleteAuthorWithNoBooks()
    {
        echo "Executando o teste de exclusão de autor sem livros.\n";

        $_POST['idAutor'] = 9999;

        ob_start();
        include 'php/autor/delete-autor.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);

        echo "Resposta do script: " . json_encode($response) . "\n";

        $this->assertEquals('success', $response['status']);
        $this->assertEquals(9999, $response['id']);
    }
}
