/* タブ切替 */
var tabs = document.querySelectorAll(".tab-link");
var pages = document.querySelectorAll(".tab-pane");

tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        /* タグ部分の見た目の切り替え */
        if (!tab.classList.contains("active")) {
            tabs.forEach((ele) => {
                ele.classList.remove("active");
            });
            tab.classList.toggle("active");
        }

        var targetId = tab.href.substring(
            tab.href.indexOf("#") + 1,
            tab.href.length
        );

        pages.forEach((page) => {
            if (page.id != targetId) {
                page.classList.remove("active");
            } else {
                page.classList.add("active");
            }
        });
    });
});
tabs[0].click();

/* 画像のプレビュー */
var previewArea = document.querySelector("#preview-image");
var imageInput = document.querySelector(".input-field--image");

imageInput.addEventListener("change", (ele) => {
    previewArea.setAttribute("src", URL.createObjectURL(ele.target.files[0]));
});
