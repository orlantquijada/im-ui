// Modals
const addMedicineModal = document.getElementById("addMedicineModal");
const editMedicineModal = document.getElementById("editMedicineModal");

// Modal activators
let addMedicineButton = document.getElementById("addMedicineButton");
let editMedicineButton = document.getElementById("editMedicineButton");

// Close buttons for modals
let editMedicineModalClose = document.getElementById("editMedicineModalClose");
let addMedicineModalClose = document.getElementById("addMedicineModalClose");

const modalFunctionality = (modal, button, close, hasButton = true) => {
  if (hasButton) {
    button.addEventListener("click", event => {
      modal.style.display = "flex";
    });
  }

  close.addEventListener("click", event => {
    modal.style.display = "none";
  });
};

modalFunctionality(addMedicineModal, addMedicineButton, addMedicineModalClose);
modalFunctionality(
  editMedicineModal,
  editMedicineButton,
  editMedicineModalClose,
  false
);
