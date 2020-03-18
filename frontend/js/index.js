const midCards = document.querySelectorAll(".table__body__card");
let modal = document.querySelector(".modal");

midCards.forEach(card => {
  let menu = card.children[5];
  menu.addEventListener("click", event => {
    console.log(checkbox.classList);
    console.log("check--active" in checkbox.classList);
    modal.style.display = "flex";
  });
});

document.querySelector(".close").addEventListener("click", event => {
  modal.style.display = "none";
}); 