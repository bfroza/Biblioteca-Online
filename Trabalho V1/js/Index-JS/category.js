function filterBooksByCategory(button) {
    const category = button.getAttribute('data-category');
    const books = button.closest('.categories').querySelectorAll('.book');

    document.querySelectorAll('.category').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');

    books.forEach(book => {
        if (category === 'all' || book.getAttribute('data-category') === category) {
            book.style.display = 'block';
        } else {
            book.style.display = 'none';
        }
    });
}