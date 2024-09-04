const menuButton = document.querySelector(".menu-button");
const menuWrapper = document.querySelector(".menu-wrapper");

menuButton.addEventListener("click", () => {
    if (menuButton.classList.contains("is-active")) {
        menuButton.classList.remove("is-active");
        menuWrapper.classList.remove("is-active");
    } else {
        menuButton.classList.add("is-active");
        menuWrapper.classList.add("is-active");
    }
});

menuWrapper.addEventListener("click", () => {
    menuButton.classList.remove("is-active");
    menuWrapper.classList.remove("is-active");
});
