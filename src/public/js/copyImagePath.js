const imageCardList = document.querySelectorAll(".image-card");
imageCardList.forEach(function (imageCard) {
    imageCard.addEventListener("click", function (ele) {
        if (navigator.clipboard) {
            const pathDiv = this.querySelector(".path-text");
            const pathText = pathDiv.innerText;
            navigator.clipboard.writeText(pathText).then(() => {
                alert(
                    `画像のパスがクリップボードにコピーされました。(${pathText})`
                );
            });
        }
    });
});