<?php

function money($value)
{
  if ($value < 0) return "-" . money(-$value);
  return '₱' . number_format($value, 2);
}



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
              echo
                "
              <div class='table__body__card--unavailable' onclick = 'return unavailable()'>
                ";
            } else {
              echo
                "
                <a href='index.php?edit=1&id=" . $row['id'] . "'>
                <div class='table__body__card' onclick>
                ";
            }
            echo
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
            if ($row['quantity'] != 0) {
              echo "</a>";
            }
          }
          ?>
        </section>
    </section>

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