DROP DATABASE IF EXISTS biblioteca;
CREATE DATABASE biblioteca;
USE biblioteca;

-- Tabela autores
CREATE TABLE autores (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  biografia LONGTEXT NOT NULL,
  dataNasc DATE NOT NULL,
  nacionalidade VARCHAR(30) NOT NULL,
  PRIMARY KEY (id)
);

-- Tabela categorias
CREATE TABLE categorias (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  descricao LONGTEXT NOT NULL,
  PRIMARY KEY (id)
);

-- Tabela livros
CREATE TABLE livros (
  id INT NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(150) NOT NULL,
  categoria_id INT NOT NULL,
  numeroPag VARCHAR(4) NOT NULL,
  quantidade INT NOT NULL,
  anoPubli INT NOT NULL,
  nota DECIMAL(10,2) NOT NULL,
  imagem VARCHAR(255) NULL DEFAULT 'https://m.media-amazon.com/images/I/618iEKbcBDL._AC_UF1000,1000_QL80_.jpg',
  descricao LONGTEXT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabela autores_has_livros
CREATE TABLE autores_has_livros (
  autores_id INT NOT NULL,
  livros_id INT NOT NULL,
  PRIMARY KEY (autores_id, livros_id),
  CONSTRAINT fk_autores_has_livros_autores
    FOREIGN KEY (autores_id)
    REFERENCES autores (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_autores_has_livros_livros1
    FOREIGN KEY (livros_id)
    REFERENCES livros (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

-- View adicionarLivro
CREATE VIEW adicionarLivro AS
SELECT livros.id AS livro_id, livros.titulo, categorias.nome AS categoria_nome, livros.numeroPag, livros.quantidade, livros.anoPubli, livros.nota,
       livros.imagem, livros.descricao,
       autores.id AS autor_id, autores.nome AS autor_nome, autores.biografia AS autor_biografia, autores.dataNasc AS autor_dataNasc, autores.nacionalidade AS autor_nacionalidade
FROM livros
JOIN autores_has_livros ON livros.id = autores_has_livros.livros_id
JOIN autores ON autores.id = autores_has_livros.autores_id
JOIN categorias ON livros.categoria_id = categorias.id;

-- Inserir autores
INSERT INTO autores (nome, biografia, dataNasc, nacionalidade) 
VALUES 
('J.K. Rowling', 'Joanne Rowling, mais conhecida como J.K. Rowling, é uma escritora britânica.', '1965-07-31', 'Reino Unido'),
('George Orwell', 'Eric Arthur Blair, mais conhecido pelo pseudônimo George Orwell, foi um escritor e jornalista inglês.', '1903-06-25', 'Reino Unido'),
('Gabriel García Márquez', 'Gabriel José de la Concordia García Márquez foi um escritor, jornalista, editor e ativista político colombiano.', '1927-03-06', 'Colômbia'),
('Agatha Christie', 'Agatha Mary Clarissa Miller, mais conhecida como Agatha Christie, foi uma escritora britânica.', '1890-09-15', 'Reino Unido'),
('Stephen King', 'Stephen Edwin King é um escritor norte-americano.', '1947-09-21', 'Estados Unidos'),
('Machado de Assis', 'Joaquim Maria Machado de Assis foi um escritor, poeta, cronista, dramaturgo, contista, jornalista e crítico literário brasileiro.', '1839-06-21', 'Brasil'),
('J.R.R. Tolkien', 'John Ronald Reuel Tolkien foi um escritor, poeta, filólogo e professor universitário britânico.', '1892-01-03', 'Reino Unido'),
('Dan Brown', 'Dan Brown é um escritor norte-americano, mais conhecido por seus romances de suspense.', '1964-06-22', 'Estados Unidos'),
('Markus Zusak', 'Markus Zusak é um escritor australiano, conhecido por seu romance "A Menina que Roubava Livros".', '1975-06-23', 'Austrália'),
('Jane Austen', 'Jane Austen foi uma escritora inglesa, conhecida por seus romances clássicos como "Orgulho e Preconceito".', '1775-12-16', 'Reino Unido');

-- Inserir categorias
INSERT INTO categorias (nome, descricao) 
VALUES 
('Realismo Mágico', 'Gênero literário que combina elementos fantásticos com o realismo.'),
('Fantasia', 'Gênero literário que envolve magia e elementos sobrenaturais.'),
('Ficção Científica', 'Gênero literário baseado em avanços científicos e tecnológicos.'),
('Mistério', 'Gênero literário centrado em resolver um crime ou descobrir segredos.'),
('Horror', 'Gênero literário destinado a provocar medo e suspense.'),
('Romance', 'Gênero literário que foca nas relações amorosas.');

-- Inserir mais livros
INSERT INTO livros (titulo, categoria_id, numeroPag, quantidade, anoPubli, nota, imagem, descricao) 
VALUES 
('Harry Potter e a Câmara Secreta', 2, '352', 95, 1998, 4.6, 'https://m.media-amazon.com/images/I/81jbivNEVML._AC_UF1000,1000_QL80_.jpg', 'Segundo livro da série Harry Potter, onde Harry retorna a Hogwarts para seu segundo ano de estudos, enfrentando mistérios relacionados à Câmara Secreta.'),
('Harry Potter e o Prisioneiro de Azkaban', 2, '448', 90, 1999, 4.7, 'https://m.media-amazon.com/images/I/81QnqHwRiUL._AC_UF1000,1000_QL80_.jpg', 'Terceiro livro da série Harry Potter, onde Harry descobre segredos sobre seu passado enquanto tenta proteger Hogwarts de um perigoso prisioneiro.'),
('1984', 3, '328', 85, 1949, 4.7, 'https://m.media-amazon.com/images/I/819js3EQwbL._AC_UF1000,1000_QL80_.jpg', 'Romance distópico que apresenta um futuro sombrio e totalitário.'),
('Assassinato no Expresso do Oriente', 4, '240', 85, 1934, 4.6, 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcS_m_Zl2itJQKi9966ZsJsTl4MQw38C5yMz01k_Pfz_u39lpWkeXf7xLMXeEJC8uKknW0qAN-2WgIe7xmAuQ3HVjc7xwhO85FKJfu4W3IisSY5VxYD8PbpvpA&usqp=CAE', 'Um dos mais famosos romances policiais de Agatha Christie, onde Hercule Poirot investiga um assassinato a bordo do famoso Expresso do Oriente.'),
('It: A Coisa', 5, '1104', 75, 1986, 4.3, 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcQNHsDS6mxZae7_xtYGmoTjCeQ79rVxXI3uC5N3SS6Mb_HXoMfkRhzkxpn2dSDYi2PegtScmXmoU3WxSbY9MElRep5dmKm_lUw6wfiQkDo&usqp=CAE', 'Uma das obras mais conhecidas de Stephen King, que conta a história de um grupo de crianças enfrentando seus medos contra uma criatura maligna que assume a forma dos piores pesadelos.'),
('Dom Casmurro', 6, '256', 105, 1899, 4.9, 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcQsjfVZuA17loJaArBU-tSta6gL0uQu_rnyOmhRhtPBmF_sisfbLD2Vjn8H7QI7vzdUOAccvKvP06Um2VlmOZTOSLuAbihMV5HKvxoEeUNE_UDWoS2o6xErzg&usqp=CAE', 'Obra clássica de Machado de Assis que narra a história de Bentinho e Capitu, explorando temas como ciúme, traição e obsessão.'),
('O Senhor dos Anéis: As Duas Torres', 2, '448', 85, 1954, 4.9, 'https://http2.mlstatic.com/D_NQ_NP_718363-MLU50424454396_062022-O.webp', 'Segundo livro da trilogia O Senhor dos Anéis, de J.R.R. Tolkien, que narra a continuação da jornada da Sociedade do Anel.'),
('O Hobbit', 2, '320', 95, 1937, 4.8, 'https://m.media-amazon.com/images/I/81t2CVWEsUL.jpg', 'Livro de J.R.R. Tolkien que narra a aventura de Bilbo Bolseiro, um hobbit que é levado a uma jornada épica para ajudar a recuperar o Reino de Erebor.'),
('O Código Da Vinci', 4, '480', 125, 2003, 4.4, 'https://m.media-amazon.com/images/I/51b5YG6Y1rL.jpg', 'Romance de Dan Brown que combina mistério, suspense e símbolos secretos na busca por um segredo histórico.'),
('Anjos e Demônios', 4, '448', 110, 2000, 4.5, 'https://www.editoraarqueiro.com.br/media/upload/conteudos/Anjos_e_demonios_FILME_IMPRENSA.jpg', 'Outro romance de Dan Brown que segue o simbologista Robert Langdon em uma corrida para evitar uma ameaça terrível ao Vaticano.'),
('A Menina que Roubava Livros', 6, '552', 75, 2005, 4.7, 'https://m.media-amazon.com/images/I/61L+4OBhm-L._AC_UF1000,1000_QL80_.jpg', 'Romance de Markus Zusak que narra a história de uma jovem garota na Alemanha nazista que encontra consolo ao roubar livros e compartilhá-los com os outros.'),
('Emma', 6, '474', 85, 1815, 4.6, 'https://m.media-amazon.com/images/I/81TPjJ6cW+L._AC_UF1000,1000_QL80_.jpg', 'Romance de Jane Austen que segue as intrigas e romances da jovem Emma Woodhouse enquanto ela tenta orquestrar a vida amorosa de seus amigos.'),
('Percy Jackson e o Ladrão de Raios', 2, '352', 100, 2005, 4.5, 'https://m.media-amazon.com/images/I/A1UjcPz4gZL._AC_UF1000,1000_QL80_.jpg', 'Primeiro livro da série Percy Jackson & os Olimpianos, onde um adolescente descobre ser um semideus e embarca em uma jornada para salvar o mundo dos deuses gregos.'),
('O Iluminado', 5, '464', 80, 1977, 4.5, 'https://br.web.img3.acsta.net/c_310_420/pictures/14/10/10/19/21/152595.jpg', 'Clássico de Stephen King que narra a história de um escritor que aceita um emprego de zelador em um hotel isolado nas montanhas do Colorado, onde eventos sobrenaturais começam a ocorrer.'),
('Doutor Sono', 5, '464', 70, 2013, 4.4, 'https://photos.enjoei.com.br/livro-doutor-sono-95153462/828xN/czM6Ly9waG90b3MuZW5qb2VpLmNvbS5ici9wcm9kdWN0cy8zMzIyNDg3Ny9jN2E0OGQ3NGMxYjJmM2QxYjU5OThmMzAyZjU3YjA2OC5qcGc', 'Sequência de O Iluminado, onde o protagonista, agora adulto, tenta proteger uma jovem com habilidades semelhantes às suas do culto do Verdadeiro Nó.'),
('A Revolução dos Bichos', 1, '152', 95, 1945, 4.7, 'https://m.media-amazon.com/images/I/91BsZhxCRjL._AC_UF1000,1000_QL80_.jpg', 'Sátira política de George Orwell que narra a rebelião dos animais de uma fazenda contra seus donos humanos e as subsequentes lutas pelo poder.'),
('Morte na Mesopotâmia', 4, '288', 85, 1936, 4.6, 'https://m.media-amazon.com/images/I/81KmIm6Z4uL._AC_UF1000,1000_QL80_.jpg', 'Romance policial de Agatha Christie onde Hercule Poirot investiga um assassinato durante uma expedição arqueológica no Oriente Médio.'),
('A Coragem de ser Imperfeito', 6, '256', 100, 2010, 4.8, 'https://m.media-amazon.com/images/I/61rRRbfINJL._AC_UF1000,1000_QL80_.jpg', 'Livro de autoajuda de Brené Brown que explora a importância da vulnerabilidade e da autenticidade na vida pessoal e profissional.'),
('A Sutil Arte de Ligar o F*da-se', 6, '224', 90, 2016, 4.6, 'https://m.media-amazon.com/images/I/6175IU0qFgL._AC_UF1000,1000_QL80_.jpg', 'Livro de autoajuda de Mark Manson que propõe uma abordagem inconvencional para alcançar a felicidade e o sucesso através do desapego das expectativas e da aceitação da adversidade.');

-- Relacionar autores com livros (continuação)
INSERT INTO autores_has_livros (autores_id, livros_id) 
VALUES 
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(5, 7),
(7, 8),
(6, 9),
(8, 10),
(9, 11),
(5, 12),
(5, 13),
(4, 14),
(4, 15),
(2, 16),
(3, 17),
(8, 18),
(9, 19);

