<?php
session_start();
  $con = mysqli_connect("localhost", "root", "", "pharmacy_database")
        or die ("Error in connection");

  $sql = "SELECT * FROM medicine";
  $result = mysqli_query($con,$sql);


  while($row = mysqli_fetch_array($result)){
    $display .="
      <div class='table__body__card'>
        <div class='table__body__card__item check'>
          <div></div>
        </div>
        <div class'table__body__card__item generic'>
          <h1 class='name'>".$row['generic_name']."</h1>
        </div>
        <div class='table__body__card__item brand'>
          <h1 class='name'>".$row['brand_name']."</h1>
        </div>
        <div class='table__body__card__item company'>
          <h1 class='name'>".$row['medical_distributor']."</h1>
        </div>
        <div class='table__body__card__item dosage'>
          <h1 class='name'>".$row['dosage']."</h1>
        </div>
        <div class='table__body__card__item price'>
          <h1 class='name'>".$row['price']."</h1>
        </div>
        <div class='table__body__card__item menu'>
          <img src='../static/3dots.svg' />
        </div>
      </div>
    ";
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

    <script type="text/javascript" src="../js/index.js" async></script>
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
          <div class="left-side-bar__mid__function">
            <img
              src="../static/checklist.svg"
              class="left-side-bar__mid__function__logo"
            />
            <h1 class="left-side-bar__mid__function__name">Checklist</h1>
          </div>
          <div
            class="left-side-bar__mid__function left-side-bar__mid__function--active"
          >
            <img
              src="../static/box.svg"
              class="left-side-bar__mid__function__logo"
            />
            <h1 class="left-side-bar__mid__function__name">Inventory</h1>
          </div>
          <div class="left-side-bar__mid__function">
            <img
              src="../static/feedback.svg"
              class="left-side-bar__mid__function__logo"
            />
            <h1 class="left-side-bar__mid__function__name">Messages</h1>
          </div>
          <div class="left-side-bar__mid__function">
            <img
              src="../static/adjust.svg"
              class="left-side-bar__mid__function__logo"
            />
            <h1 class="left-side-bar__mid__function__name">Settings</h1>
          </div>
        </section>
      </section>
      <section class="main">
        <div class="search">
          <div class="search__main">
            <img src="../static/search.svg" class="search__main__logo" />
            <input
              type="search"
              name="search"
              class="search__main__name"
              placeholder="Search"
            />
          </div>
          <h1 class="search__results-count">25 results</h1>
        </div>
        <div class="table">
          <section class="table__header">
            <div class="table__header__item check">
              <div></div>
            </div>
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
              if(isset($display)){
                echo $display;
              }
            ?>
          </section>
        </div>
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
          <div class="right-side-bar__mid__clerk">
            <img src="../static/jane.svg" class="picture" />
            <div class="right-side-bar__mid__clerk__hero">
              <h1 class="name">Jane Doe</h1>
              <h2 class="title">Sales Clerk</h2>
            </div>
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

            <div class="table__card">
              <div class="table__card__item name">
                <h1>STRESSTABS DROPLETS</h1>
              </div>
              <div class="table__card__item piece">
                <h1>1PC</h1>
              </div>
              <div class="table__card__item price">
                <h1>5.00</h1>
              </div>
              <div class="table__card__item total">
                <h1>5.00</h1>
              </div>
            </div>

            <div class="table__card">
              <div class="table__card__item name">
                <h1>NATURE'S SPRING 1L</h1>
              </div>
              <div class="table__card__item piece">
                <h1>1PC</h1>
              </div>
              <div class="table__card__item price">
                <h1>25.00</h1>
              </div>
              <div class="table__card__item total">
                <h1>25.00</h1>
              </div>
            </div>

            <div class="table__card">
              <div class="table__card__item name">
                <h1>RITEMED IBUPROFEN CAP</h1>
              </div>
              <div class="table__card__item piece">
                <h1>3PC</h1>
              </div>
              <div class="table__card__item price">
                <h1>18.00</h1>
              </div>
              <div class="table__card__item total">
                <h1>54.00</h1>
              </div>
            </div>

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

            <div class="table__card">
              <div class="table__card__item name">
                <h1>STRESSTABS DROPLETS</h1>
              </div>
              <div class="table__card__item piece">
                <h1>1PC</h1>
              </div>
              <div class="table__card__item price">
                <h1>5.00</h1>
              </div>
              <div class="table__card__item total">
                <h1>5.00</h1>
              </div>
            </div>

            <div class="table__card">
              <div class="table__card__item name">
                <h1>NATURE'S SPRING 1L</h1>
              </div>
              <div class="table__card__item piece">
                <h1>1PC</h1>
              </div>
              <div class="table__card__item price">
                <h1>25.00</h1>
              </div>
              <div class="table__card__item total">
                <h1>25.00</h1>
              </div>
            </div>

            <div class="table__card">
              <div class="table__card__item name">
                <h1>RITEMED IBUPROFEN CAP</h1>
              </div>
              <div class="table__card__item piece">
                <h1>3PC</h1>
              </div>
              <div class="table__card__item price">
                <h1>18.00</h1>
              </div>
              <div class="table__card__item total">
                <h1>54.00</h1>
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
            <div class="discount">
              <h1 class="name">DISCOUNT:</h1>
              <h2 class="number">28.00</h2>
            </div>
          </section>
          <div class="line--broken"></div>
          <section class="total">
            <h1 class="name">TOTAL:</h1>
            <h1 class="number">200.00</h1>
          </section>
        </section>
      </section>

      <!-- Modal Section -->
      <div class="modal">
        <div class="add-medicine">
          <span class="close">+</span>
          <form action="#" method="GET" class="table">
            <div class="table__item generic">
              <h1 class="name">Generic Name:</h1>
              <h1 class="title">Paracetamol</h1>
            </div>

            <div class="table__item brand">
              <h1 class="name">Brand Name:</h1>
              <h1 class="title">Biogesic</h1>
            </div>

            <div class="table__item company">
              <h1 class="name">Company Name:</h1>
              <h1 class="title">UNILAB</h1>
            </div>

            <div class="table__item dosage">
              <h1 class="name">Dosage:</h1>
              <h1 class="title">15mL Droplets</h1>
            </div>
          </form>

          <form action="#" method="GET" class="table">
            <div class="table__item stocks">
              <h1 class="name">Stocks Available:</h1>
              <h1 class="title">15</h1>
            </div>

            <div class="table__item quantity">
              <label for="qty" class="name">Quantity:</label>
              <input type="text" name="qty" id="qty" class="title" size="2" />
            </div>

            <div class="table__item price">
              <h1 class="name">Price:</h1>
              <h1 class="title">15.00</h1>
            </div>
          </form>

          <form action="#" method="POST" class="cash-out">
            <div class="total">
              <h1 class="name">Total:</h1>
              <h1 class="number">60.00</h1>
            </div>

            <div class="buttons">
              <button type="reset" class="cancel"><h1>Cancel</h1></button>
              <button type="submit" class="submit"><h1>Confirm</h1></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
