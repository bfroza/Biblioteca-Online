# BookBase - Biblioteca Online

BookBase é uma biblioteca virtual de venda de livros desenvolvida por Bruno Froza, João Vitor Longo e Márcio Lima. Este projeto é uma plataforma onde os usuários podem encontrar e comprar uma variedade de livros online.

## Funcionalidades

- **Página Inicial:** Apresenta os livros recomendados e uma barra de pesquisa para que os usuários encontrem facilmente os livros desejados.
  
- **Detalhes do Livro:** Ao clicar em um livro, são exibidas informações detalhadas, como nome do livro, autor, avaliação, número de páginas, descrição e opção para ler o livro.

- **Navegação por Categoria:** Os usuários podem explorar diferentes categorias de livros na parte inferior da página.

- **Menu de Navegação:** Localizado no canto esquerdo da página, o menu oferece acesso rápido a diversas seções, incluindo a página inicial, cadastro de livros, autores, categorias, livraria.

- **Cadastro de Livros:** Os administradores podem cadastrar novos livros na plataforma, incluindo informações como nome, autor, categoria, número de páginas, quantidade disponível, ano de publicação, avaliação e URL da capa do livro.

## Funcionalidades a Adicionar

- **Downloads:** Permite aos usuários baixarem os livros adquiridos para leitura offline.

- **Favoritos:** Permite aos usuários salvar seus livros favoritos para acesso rápido e fácil.

- **Livros Lidos:** Mantém um registro dos livros que os usuários já leram, fornecendo insights e recomendações personalizadas.

- **Configurações:** Permite aos usuários personalizarem suas preferências, como idioma, tema da interface, notificações, etc.

- **Suporte:** Oferece assistência e suporte técnico aos usuários, seja para questões relacionadas ao uso da plataforma ou problemas técnicos.

- **Logout:** Permite aos usuários encerrarem sua sessão e saírem da plataforma de forma segura.

## Como Utilizar

1. **Instalação do Xampp:**
   - Instale o Xampp com as dependências PHP e Apache.

2. **Clone o Repositório:**
   - Clone o repositório dentro da pasta `C:\xampp\htdocs`.

3. **Extração do Arquivo Vendor:**
   - Selecione o arquivo `vendor.zip` e extraia-o. 
   - Após a extração, exclua o arquivo ZIP e mantenha apenas a pasta `vendor`.

4. **Configuração do Banco de Dados:**
   - Vá para a pasta `sql` do e copie o código SQL.

5. **Iniciar o Xampp:**
   - Abra o Xampp e inicie os serviços Apache e MySQL.
   - Clique no botão "Admin" na seção MySQL para abrir o phpMyAdmin.

6. **Executar o Código SQL:**
   - Cole o código SQL que você copiou na barra de navegação escrita 'SQL' e execute.

7. **Acessar a Aplicação:**
   - No Xampp, clique no botão "Admin" na seção Apache.
   - Navegue até a pasta `Trabalho V3 -> php -> index`, ou digite `http://localhost/Trabalho%20V3/php/index/` na barra de pesquisa do seu navegador.

8. **Testes Unitários:**
   - Vá para a pasta raiz do trabalho através do terminal do VSCODE, ou seja, `C:\xampp\htdocs\Trabalho V3>` e digite ```bash ./vendor/bin/phpunit tests ```

Agora você pode usar o projeto conforme necessário, seguindo essas etapas.



## Tecnologias Utilizadas

- HTML(frontend)
- CSS(frontend)
- JavaScript(frontend and connection backend)
- PHP(backend)
- PHP Unit(unit tests)

## Licença

Este projeto está licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT) - consulte o arquivo `LICENSE` para obter detalhes.
