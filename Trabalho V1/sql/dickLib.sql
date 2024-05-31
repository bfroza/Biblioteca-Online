DROP DATABASE IF EXISTS biblioteca;
CREATE DATABASE biblioteca;
USE biblioteca;

-- -----------------------------------------------------
-- Table autores
-- -----------------------------------------------------
CREATE TABLE autores (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  biografia LONGTEXT NOT NULL,
  dataNasc DATE NOT NULL,
  nacionalidade VARCHAR(30) NOT NULL,
  PRIMARY KEY (id)
);

-- -----------------------------------------------------
-- Table livros
-- -----------------------------------------------------
CREATE TABLE livros (
  id INT NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(150) NOT NULL,
  categoria VARCHAR(50) NOT NULL,
  numeroPag VARCHAR(4) NOT NULL,
  quantidade INT NOT NULL,
  anoPubli INT NOT NULL,
  nota DECIMAL(10,2) NOT NULL,
  imagem VARCHAR(255) NULL DEFAULT 'https://m.media-amazon.com/images/I/618iEKbcBDL._AC_UF1000,1000_QL80_.jpg',
  descricao LONGTEXT NOT NULL,
  PRIMARY KEY (id)
);

-- -----------------------------------------------------
-- Table autores_has_livros
-- -----------------------------------------------------
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

-- -----------------------------------------------------
-- View adicionarLivro
-- -----------------------------------------------------
CREATE VIEW adicionarLivro AS
SELECT livros.id AS livro_id, livros.titulo, livros.categoria, livros.numeroPag, livros.quantidade, livros.anoPubli, livros.nota,
       livros.imagem, livros.descricao,
       autores.id AS autor_id, autores.nome AS autor_nome, autores.biografia AS autor_biografia, autores.dataNasc AS autor_dataNasc, autores.nacionalidade AS autor_nacionalidade
FROM livros
JOIN autores_has_livros ON livros.id = autores_has_livros.livros_id
JOIN autores ON autores.id = autores_has_livros.autores_id;

-- Inserir autores
INSERT INTO autores (nome, biografia, dataNasc, nacionalidade) 
VALUES 
('J.K. Rowling', 'Joanne Rowling, mais conhecida como J.K. Rowling, é uma escritora britânica.', '1965-07-31', 'Reino Unido'),
('George Orwell', 'Eric Arthur Blair, mais conhecido pelo pseudônimo George Orwell, foi um escritor e jornalista inglês.', '1903-06-25', 'Reino Unido'),
('Gabriel García Márquez', 'Gabriel José de la Concordia García Márquez foi um escritor, jornalista, editor e ativista político colombiano.', '1927-03-06', 'Colômbia'),
('Agatha Christie', 'Agatha Mary Clarissa Miller, mais conhecida como Agatha Christie, foi uma escritora britânica.', '1890-09-15', 'Reino Unido'),
('Stephen King', 'Stephen Edwin King é um escritor norte-americano.', '1947-09-21', 'Estados Unidos'),
('Machado de Assis', 'Joaquim Maria Machado de Assis foi um escritor, poeta, cronista, dramaturgo, contista, jornalista e crítico literário brasileiro.', '1839-06-21', 'Brasil');


-- Inserir livros
INSERT INTO livros (titulo, categoria, numeroPag, quantidade, anoPubli, nota, imagem, descricao) 
VALUES 

('Cem Anos de Solidão', 'Realismo Mágico', '416', 120, 1967, 4.8, 'https://m.media-amazon.com/images/I/51U-1ilSDEL._AC_UF1000,1000_QL80_.jpg', 'Em Cem anos de solidão , um dos maiores clássicos da literatura, o prestigiado autor narra a incrível e triste história dos Buendía - a estirpe de solitários para a qual não será dada “uma segunda oportunidade sobre a terra” e apresenta o maravilhoso universo da fictícia Macondo, onde se passa o romance.'),
('Harry Potter e a Pedra Filosofal', 'Fantasia', '320', 100, 1997, 4.5, 'https://m.media-amazon.com/images/I/51UoqRAxwEL.jpg', 'Primeiro livro da série Harry Potter, que narra a jornada do jovem bruxo Harry Potter.'),
('1984', 'Ficção Científica', '328', 80, 1949, 4.7, 'https://m.media-amazon.com/images/I/819js3EQwbL._AC_UF1000,1000_QL80_.jpg', 'Romance distópico que apresenta um futuro sombrio e totalitário.'),
('Assassinato no Expresso do Oriente', 'Mistério', '240', 90, 1934, 4.6, 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcS_m_Zl2itJQKi9966ZsJsTl4MQw38C5yMz01k_Pfz_u39lpWkeXf7xLMXeEJC8uKknW0qAN-2WgIe7xmAuQ3HVjc7xwhO85FKJfu4W3IisSY5VxYD8PbpvpA&usqp=CAE', 'Um dos mais famosos romances policiais de Agatha Christie, onde Hercule Poirot investiga um assassinato a bordo do famoso Expresso do Oriente.'),
('It: A Coisa', 'Horror', '1104', 70, 1986, 4.3, 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcQNHsDS6mxZae7_xtYGmoTjCeQ79rVxXI3uC5N3SS6Mb_HXoMfkRhzkxpn2dSDYi2PegtScmXmoU3WxSbY9MElRep5dmKm_lUw6wfiQkDo&usqp=CAE', 'Uma das obras mais conhecidas de Stephen King, que conta a história de um grupo de crianças enfrentando seus medos contra uma criatura maligna que assume a forma dos piores pesadelos.'),
('Dom Casmurro', 'Romance', '256', 110, 1899, 4.9, 'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcQsjfVZuA17loJaArBU-tSta6gL0uQu_rnyOmhRhtPBmF_sisfbLD2Vjn8H7QI7vzdUOAccvKvP06Um2VlmOZTOSLuAbihMV5HKvxoEeUNE_UDWoS2o6xErzg&usqp=CAE', 'Obra clássica de Machado de Assis que narra a história de Bentinho e Capitu, explorando temas como ciúme, traição e obsessão.');

-- Relacionar autores com livros
INSERT INTO autores_has_livros (autores_id, livros_id) 
VALUES 
(1, 2), 
(3, 1), 
(2, 3),
(4, 4), 
(5, 5),
(6,6);


