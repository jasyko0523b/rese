var writeArea = document.querySelector(".write-area");
var reviewList = document.querySelector(".review-list");
var reviewButton = document.querySelector(".review__button");
reviewButton.addEventListener("click", () => {
    reviewButton.classList.toggle("active");
    writeArea.classList.toggle("active");
    reviewList.classList.toggle("active");
});
