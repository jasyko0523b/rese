// 文字数カウント
const maxLength = 400;
const comment = document.querySelector(".comment");
const textCount = document.querySelector(".text-count");
textCount.innerHTML = comment.value.length + "/" + maxLength + " (最高文字数)";
if (comment.value.length > maxLength) {
    textCount.style.color = "red";
} else {
    textCount.style.removeProperty("color");
}
["input"].forEach(function (ev) {
    comment.addEventListener(ev, (ele) => {
        const currentLength = ele.currentTarget.value.length;
        textCount.innerHTML = currentLength + "/" + maxLength + " (最高文字数)";
        if (currentLength > maxLength) {
            textCount.style.color = "red";
        } else {
            textCount.style.removeProperty("color");
        }
    });
});
