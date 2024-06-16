const hamburger = document.querySelector('.menu');
const headNav = document.querySelector('.header__nav');

hamburger.addEventListener('click', () => {
    if (hamburger.classList.contains("is-active")) {
        hamburger.classList.remove('is-active');
        headNav.classList.remove('is-active');
    } else {
        hamburger.classList.add('is-active');
        headNav.classList.add('is-active');
    }
});

headNav.addEventListener('click', () => {
    hamburger.classList.remove('is-active');
    headNav.classList.remove('is-active');
});
