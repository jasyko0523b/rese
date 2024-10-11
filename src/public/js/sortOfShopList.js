var shopCardArea = document.querySelector(".shop-card-area");
var cardList = document.getElementsByClassName("shop-card");
var cardArray = Array.prototype.slice.call(cardList);

var sortingMethod = document.querySelector(".sort-select");
sortingMethod.addEventListener("change", function () {
    switch (this.value) {
        case "default":
            cardArray.sort(idAsc);
            break;
        case "random":
            shuffle(cardArray);
            break;
        case "desc":
            cardArray.sort(scoreDesc);
            break;
        case "asc":
            cardArray.sort(scoreAsc);
            break;
    }
    for (var i = 0; i < cardArray.length; i++) {
        shopCardArea.appendChild(shopCardArea.removeChild(cardArray[i]));
    }
});

function idAsc(a, b) {
    idA = Number(a.querySelector(".shop-id").textContent);
    idB = Number(b.querySelector(".shop-id").textContent);
    if (idA > idB) {
        return 1;
    } else if (idA < idB) {
        return -1;
    } else {
        return 0;
    }
}

function scoreDesc(a, b) {
    scoreA = a.querySelector(".score").textContent;
    scoreB = b.querySelector(".score").textContent;
    if (scoreA < scoreB) {
        return 1;
    } else if (scoreA > scoreB) {
        return -1;
    } else {
        return 0;
    }
}

function scoreAsc(a, b) {
    scoreA = a.querySelector(".score").textContent;
    scoreB = b.querySelector(".score").textContent;
    if (scoreA == 0) {
        return 1;
    }
    if (scoreA > scoreB) {
        return 1;
    } else if (scoreA < scoreB) {
        return -1;
    } else {
        return 0;
    }
}

function shuffle(arr) {
    for (var i = arr.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
}
