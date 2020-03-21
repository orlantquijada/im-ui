// Modals
let addMedicineModal = document.getElementById("addMedicineModal");
let editMedicineModal = document.getElementById("editMedicineModal");
let addMedicineModalCheckout = document.getElementById(
  "addMedicineModalCheckout"
);

// Modal activators
let addMedicineButton = document.getElementById("addMedicineButton");
console.log(addMedicineButton);

// Close buttons for modals
let editMedicineModalClose = document.getElementById("editMedicineModalClose");
let addMedicineModalClose = document.getElementById("addMedicineModalClose");
let addMedicineModalCloseCheckout = document.getElementById(
  "addMedicineModalCloseCheckout"
);

// function to add to modals
const modalFunctionality = (modal, close, button) => {
  if (button) {
    console.log(button);
    button.addEventListener("click", event => {
      modal.style.display = "flex";
    });
  }

  close.addEventListener("click", event => {
    modal.style.display = "none";
  });
};

try {
  modalFunctionality(
    addMedicineModal,
    addMedicineModalClose,
    addMedicineButton
  );
  modalFunctionality(editMedicineModal, editMedicineModalClose);
} catch (error) {}

try {
  modalFunctionality(addMedicineModalCheckout, addMedicineModalCloseCheckout);
} catch (error) {}
