var reserveList = document.querySelectorAll(".reservation-card");

reserveList.forEach((reserve, i) => {
    var editButton = reserve.querySelector(".edit-button");
    editButton.classList.add("active");
    var editForm = reserve.querySelector(".edit-form");
    if (editButton != null) {
        editButton.addEventListener("click", () => {
            editForm.classList.toggle("active");
        });
    }
});
