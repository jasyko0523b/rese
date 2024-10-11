const dropArea = document.querySelector(".drop-area");

// ドロップエリアをクリックした際のインプットのクリックイベント
dropArea.addEventListener("click", () => {
    const reviewImg = document.querySelector(".review-img");
    reviewImg.click();
});

const reviewImg = document.querySelector(".review-img");

// ドロップ時のファイル読み込み
function dropHandler(ev) {
    const changeEv = new Event("change");

    ev.preventDefault();
    if (ev.dataTransfer.items) {
        const dt = new DataTransfer();
        [...ev.dataTransfer.items].forEach((item, i) => {
            if (item.kind == "file") {
                const file = item.getAsFile();
                dt.items.add(file);
            }
        });
        reviewImg.files = dt.files;
        reviewImg.dispatchEvent(changeEv);
    } else {
        reviewImg.files = ev.dataTransfer.files;
        reviewImg.dispatchEvent(changeEv);
    }
}

function dragOverHandler(ev) {
    ev.preventDefault();
}

/* 選択ファイルの件数・拡張子チェック */
/* 画像のプレビュー */
const maxFiles = 1;
const allowExtensions = ".(jpeg|jpg|png)$";
var previewArea = document.querySelector(".preview-area");

reviewImg.addEventListener("change", (ele) => {
    // プレビュー画像の削除
    while (previewArea.firstChild) {
        previewArea.removeChild(previewArea.firstChild);
    }
    // 件数チェック
    if (ele.target.files.length > maxFiles) {
        reviewImg.files = new DataTransfer().files;
        numberAlert();
        return;
    }
    // 拡張子チェック
    [...ele.target.files].forEach((file, i) => {
        if (!file.name.match(allowExtensions)) {
            reviewImg.files = new DataTransfer().files;
            extensionAlert();
            return;
        }
    });
    // プレビュー画像の追加
    [...ele.target.files].forEach((file, i) => {
        let img_element = document.createElement("img");
        img_element.src = URL.createObjectURL(file);
        img_element.className = "preview-img";
        previewArea.appendChild(img_element);
    });
});

/* アラート */
//拡張子エラー
function extensionAlert() {
    alert("jpeg、pngのみアップロード可能です");
}
// 件数エラー
function numberAlert() {
    alert("画像の追加は" + maxFiles + "件のみ可能です");
}
