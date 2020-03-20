<?php

function money($value)
{
  if ($value < 0) return "-" . money(-$value);
  return '₱' . number_format($value, 2);
}

$con = mysqli_connect('localhost','root','','pharmacy_db')
or die('Error connecting to MySQL server.');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>POS</title>
  <link rel="stylesheet" href="../css/main.css" />
</head>

<body>
  <div class="site">
    <section class="left-side-bar">
      <section class="left-side-bar__top">
        <img src="../static/rx.svg" class="left-side-bar__top__logo" />
        <h1 class="left-side-bar__top__pharmacy-name">Pharmacy</h1>
        <img src="../static/hamburger.svg" class="left-side-bar__top__menu" />
      </section>
      <section class="left-side-bar__mid">
        <a href="index.html" class="left-side-bar__mid__function left-side-bar__mid__function--active">
          <img src="../static/checklist--active.svg" class="left-side-bar__mid__function__logo" />
          <h1 class="left-side-bar__mid__function__name">POS</h1>
        </a>

        <a href="inventory.php" class="left-side-bar__mid__function">
          <img src="../static/box--inactive.svg" class="left-side-bar__mid__function__logo" />
          <h1 class="left-side-bar__mid__function__name">Inventory</h1>
        </a>
      </section>
    </section>

    <section class="main">
      <div class="table">
        <section class="table__header">
          <div class="table__header__item generic">
            <h1 class="name">Generic Name</h1>
          </div>
          <div class="table__header__item brand">
            <h1 class="name">Brand</h1>
          </div>
          <div class="table__header__item company">
            <h1 class="name">Company</h1>
          </div>
          <div class="table__header__item dosage">
            <h1 class="name">Dosage</h1>
          </div>
          <div class="table__header__item price">
            <h1 class="name">Price</h1>
          </div>
        </section>

        <section class="table__body">
          <?php
          $con = mysqli_connect("localhost", "root", "", "pharmacy_db");
          $sql = "SELECT * FROM medicine";
          $result = mysqli_query($con, $sql);
          $print = "";
          while ($row = mysqli_fetch_array($result)) {
            if ($row['quantity'] <= 0) {
              $print .=
                "
              <div class='table__body__card--unavailable' onclick = 'return unavailable()'>
                ";
            } else {
              $print .=
                "
                <a href='index.php?edit=1&id=" . $row['id'] . "'>
                <div class='table__body__card' onclick>
                ";
            }
            $print .=
              "
                <div class='table__body__card__item generic'>
                  <h1 class='name'>" . $row['generic_name'] . "</h1>
                </div>
                <div class='table__body__card__item brand'>
                  <h1 class='name'>" . $row['brand_name'] . "</h1>
                </div>
                <div class='table__body__card__item company'>
                  <h1 class='name'>" . $row['company'] . "</h1>
                </div>
                <div class='table__body__card__item dosage'>
                  <h1 class='name'>" . $row['dosage'] . "</h1>
                </div>
                <div class='table__body__card__item price'>
                  <h1 class='name'>" . money($row['price']) . "</h1>
                </div>
              </div>
              ";
            if($row['quantity'] != 0){
              $print .= "</a>";
            }
          }
          echo $print;
          ?>
        </section>
    </section>
    <section class="right-side-bar">
      <section class="right-side-bar__top">
        <div class="right-side-bar__top__pharmacy">
          <div class="right-side-bar__top__pharmacy__hero">
            <img src="../static/hygeia.svg" class="logo" />
            <h1 class="name">Pharmacy</h1>
          </div>
          <h3 class="right-side-bar__top__pharmacy__location">
            21 St. This Barangay, That City
          </h3>
        </div>
        <div class="line"></div>
      </section>
      <section class="right-side-bar__mid">
        <div class="right-side-bar__mid__transaction">
          <h1 class="name">Transaction:</h1>
          <h1 class="number">817231987237</h1>
        </div>
        <div class="line"></div>
      </section>

      <section class="right-side-bar__bot">
        <section class="table">
          <div class="table__card">
            <div class="table__card__item name">
              <h1>BIOGESIC TABLET 250MG</h1>
            </div>
            <div class="table__card__item piece">
              <h1>5PC</h1>
            </div>
            <div class="table__card__item price">
              <h1>6.00</h1>
            </div>
            <div class="table__card__item total">
              <h1>30.00</h1>
            </div>
          </div>
        </section>

        <section class="calculations">
          <div class="total-items">
            <h1 class="name">TOTAL ITEMS:</h1>
            <h2 class="number">8</h2>
          </div>
          <div class="subtotal">
            <h1 class="name">SUBTOTAL:</h1>
            <h2 class="number">228.00</h2>
          </div>
        </section>
        <div class="line--broken"></div>
        <section class="total">
          <h1 class="name">TOTAL:</h1>
          <h1 class="number">200.00</h1>
        </section>
      </section>
    </section>
  </section>
  <!-- Modal Section -->
  <div class='modal' class='MedicineModal' id='addMedicineModal'>
        <div class='medicineModal'>
          <div class='header'>
            <h1 class='title'>Add Item</h1>
          </div>
          <form action='inventory.php' method='POST' class='form'>
            <div class='form__main' >
              <div class='form__main__form-item'>
                <h1 class='title'>Generic Name :</h1>
                <input type='text' class='input' name='genericNameAdd' />
              </div>
              
              <div class='form__main__form-item'>
                <h1 class='title'>Company Name :</h1>
                <input type='text' class='input' name='companyNameAdd' />
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Brand Name :</h1>
                <input type='text' class='input' name='brandNameAdd' />
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Dosage :</h1>
                <input type='text' class='input' name='dosageAdd' />
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Price :</h1>
                <input type='text' class='input' name='priceAdd' />
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Stocks Available :</h1>
                <input type='text' class='input' name='quantityAdd' />
              </div>
            </div>

            <div class='buttons'>
              <div class='buttons__main'>
                <button type='reset' class='cancel btn' id='addMedicineModalClose'><h1>Cancel</h1></button>
                <button type='submit' class='submit btn' name='addComplete' value=1><h1>Confirm</h1></button>
              </div>
            </div>
          </form>
        </div>
      </div>
  <!-- Modal Section -->

  </div>
</div>

  <script language="Javascript">
    let modal = document.querySelector(".modal");

    document.querySelector(".close").addEventListener("click", event => {
      modal.style.display = "none";
    });

    function unavailable() {
      alert("Item unavailable!");
    }
  </script>
</body>

</html>