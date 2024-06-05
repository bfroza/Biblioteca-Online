function toggleBooksDisplay(event) {
    const seeAllButton = event.target;
    const recommendedSection = seeAllButton.closest('.recommended');
    const books = recommendedSection.querySelectorAll('.book');

    books.forEach((book, index) => {
        if (index >= 7) {
            book.classList.toggle('hidden');
        }
    });

    seeAllButton.textContent = seeAllButton.textContent === 'Veja todos >' ? 'Veja os melhores' : 'Veja todos >';
}