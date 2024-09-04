var stars = document.querySelectorAll(".star");
var selectedRank = document.querySelector(".selected-rank");
stars.forEach((star) => {
    star.addEventListener("click", () => {
        selectedRank.textContent = "( " + star.value + ".0 )";
    });
});
stars[2].click();