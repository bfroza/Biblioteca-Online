function pesquisarLivros() {
    var input, filter, bookLists, books, book, title, author, i, j, txtValueTitle, txtValueAuthor;
    input = document.getElementById("input_search");
    filter = input.value.toUpperCase();
    bookLists = document.querySelectorAll(".book-list");

    for (i = 0; i < bookLists.length; i++) {
        books = bookLists[i].getElementsByClassName("book");
        for (j = 0; j < books.length; j++) {
            book = books[j];
            title = book.querySelector("p").textContent.toUpperCase();
            author = book.querySelector(".author").textContent.toUpperCase();
            if (title.indexOf(filter) > -1 || author.indexOf(filter) > -1) {
                book.style.display = "";
            } else {
                book.style.display = "none";
            }
        }
    }
}