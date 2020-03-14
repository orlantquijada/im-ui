const midCards = document.querySelectorAll(".table__body__card");
let modal = document.querySelector(".modal");

midCards.forEach(card => {
  let button = card.children[0];

  button.addEventListener("click", event => {
    console.log(checkbox.classList);
    console.log("check--active" in checkbox.classList);
    if ("check--active" in checkbox.classList) {
      checkbox.classList.add("check--active");
    }

    modal.style.display = "flex";
  });
});

document.querySelector(".close").addEventListener("click", event => {
  modal.style.display = "none";
});

