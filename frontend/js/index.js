const midCards = document.querySelectorAll(".table__body__card");
let modal = document.querySelector(".modal");

midCards.forEach(card => {
  let checkbox = card.children[0];

  card.addEventListener("click", event => {
    checkbox.style.transition = "background-color 200ms";
    checkbox.classList.toggle("check--active");
  });

  let menu = card.children[6];
  menu.addEventListener("click", event => {
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
