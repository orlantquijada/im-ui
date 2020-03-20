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
  <?php
   $con = mysqli_connect('localhost','root','','pharmacy_db')
   or die('Error connecting to MySQL server.');
  
    $is_edit = false;
  
    try {
      @$is_edit = (bool)$_GET['edit'];
    } catch (Exception $e) {}
   
    if ($is_edit) {
      $id = $_GET['id'];
      $sql = "SELECT * FROM medicine WHERE id= '$id'";
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($result);
        echo 
          "
          <div class='modal'>
            <div class='add-medicine'>
              <span class='close'>+</span>
              <form action='#' method='post' class='table'>
                <input type='text' name = 'id' value='{" . $row['id'] . "}' style='display:none'>
                <div class='table__item generic'>
                  <h1 class='name'>Generic Name:</h1>
                  <h1 class='title'>" . $row['generic_name'] . "</h1>
                </div>
      
                <div class='table__item brand'>
                  <h1 class='name'>Brand Name:</h1>
                  <h1 class='title'>" . $row['brand_name'] . "</h1>
                </div>
        
                <div class='table__item company'>
                  <h1 class='name'>Company Name:</h1>
                  <h1 class='title'>" . $row['company'] . "</h1>
                </div>
        
                <div class='table__item dosage'>
                  <h1 class='name'>Dosage:</h1>
                  <h1 class='title'>" . $row['dosage'] . "</h1>
                </div>
              </form>
      
              <form action='#' name='modal-form' method='post' class='table'>
                <div class='table__item stocks'>
                  <h1 class='name'>Stocks Available:</h1>
                  <h1 class='title'>" . $row['quantity'] . "</h1>
                </div>
        
                <div class='table__item quantity'>
                  <label for='qty' class='name'>Quantity:</label>
                  <input type='text' name='quantity' class='title' value='2' size='2'>
                </div>
      
                <div class='table__item price'>
                  <h1 class='name'>Price:</h1>
                  <h1 class='title'>" . money($row['price']) . "</h1>
                </div>
                
                <div class='buttons'>
                  <button type='reset' class='cancel'>
                    <h1>Cancel</h1>
                  </button>
                  <input type='submit' class='submit' name='confirm' value='Confirm'>
                </div>
              </form>
            </div>
          ";

          if($_SERVER["REQUEST_METHOD"] == "POST"){
            $quantity = $_POST['quantity'];
          }
          else{
                echo '<script language="javascript">';
                echo 'alert("123")';  //not showing an alert box.
                echo '</script>';
          }
         
  }

  ?>

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