function calculateStars(rating) {
    const starsElement = document.querySelector(".stars");
    const totalStars = 5;
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 !== 0;
    const emptyStars = totalStars - fullStars - (hasHalfStar ? 1 : 0);

    starsElement.innerHTML = '';

    for (let i = 0; i < fullStars; i++) {
        starsElement.innerHTML += "<i class='bx bxs-star' style='color: gold;'></i>";
    }

    if (hasHalfStar) {
        starsElement.innerHTML += "<i class='bx bxs-star-half' style='color: gold;'></i>";
    }

    for (let i = 0; i < emptyStars; i++) {
        starsElement.innerHTML += "<i class='bx bxs-star' style='color: lightgray;'></i>";
    }
}