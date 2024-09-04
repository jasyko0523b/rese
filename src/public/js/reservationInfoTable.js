document.getElementById("date").addEventListener("change", function () {
    document.getElementById("date_view").textContent = this.value;
});
document.getElementById("time").addEventListener("change", function () {
    document.getElementById("time_view").textContent = this.value;
});
document.getElementById("number").addEventListener("change", function () {
    document.getElementById("number_view").textContent = this.value + "人";
});
document.getElementById("date").value = new Date().toLocaleDateString("sv-SE");
