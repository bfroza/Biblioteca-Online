function handleBookClick(bookId) {
    fetchBookInfo(bookId)
        .then(book => {
            console.log(book);
        })
        .catch(error => {
            console.error('Erro ao buscar informações do livro:', error);
        });
}

function fetchBookInfo(bookId) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest
        xhr.open('GET', 'http://localhost/Trabalho%20V1/php/get-livro.php?id=' + bookId, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const bookData = JSON.parse(xhr.responseText);
                resolve(bookData);
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