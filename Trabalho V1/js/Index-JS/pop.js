function handleBookClick(bookId) {
    openPopupWithBookDetails(bookId);
}

function fetchBookInfoForPopup(bookId) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://localhost/Trabalho%20V1/php/get-livro.php?id=' + bookId, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const bookData = JSON.parse(xhr.responseText);
                resolve(bookData);
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

function openPopupWithBookDetails(bookId) {
    fetchBookInfoForPopup(bookId)
        .then(bookData => {
            console.log(bookData);

            // Preencha os detalhes do livro no pop-up
            document.getElementById('popup-book-cover').src = bookData.imagem;
            document.getElementById('popup-book-title').textContent = bookData.titulo;
            document.getElementById('popup-book-author').textContent = bookData.autor_nome;
            document.getElementById('popup-book-rating').textContent = bookData.nota;
            calculateStars(bookData.nota);
            document.getElementById('popup-book-pages').textContent = bookData.numeroPag;
            document.getElementById('popup-book-description').textContent = bookData.descricao;

            // Abra o pop-up
            openPopup();
        })
        .catch(error => {
            console.error('Erro ao buscar informações do livro:', error);
        });
}
