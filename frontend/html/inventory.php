<?php
 $con = mysqli_connect('localhost','root','','pharmacy_db')
 or die('Error connecting to MySQL server.');
?>



<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory</title>

    <link rel="stylesheet" href="../css/main.css" />
  </head>
  <body>
    <div class="site">
      <div class="left-side-bar">
        <section class="left-side-bar__top">
          <img src="../static/rx.svg" class="left-side-bar__top__logo" />
          <h1 class="left-side-bar__top__pharmacy-name">Pharmacy</h1>
          <img src="../static/hamburger.svg" class="left-side-bar__top__menu" />
        </section>
        <section class="left-side-bar__mid">
          <a href="index.html" class="left-side-bar__mid__function">
            <img
              src="../static/checklist.svg"
              class="left-side-bar__mid__function__logo"
            />
            <h1 class="left-side-bar__mid__function__name">POS</h1>
          </a>

          <a
            href="inventory.php"
            class="left-side-bar__mid__function left-side-bar__mid__function--active"
          >
            <img
              src="../static/box.svg"
              class="left-side-bar__mid__function__logo"
            />
            <h1 class="left-side-bar__mid__function__name">Inventory</h1>
          </a>

          <a href="#" class="left-side-bar__mid__function">
            <img
              src="../static/feedback.svg"
              class="left-side-bar__mid__function__logo"
            />
            <h1 class="left-side-bar__mid__function__name">Messages</h1>
          </a>

          <a href="#" class="left-side-bar__mid__function">
            <img
              src="../static/adjust.svg"
              class="left-side-bar__mid__function__logo"
            />
            <h1 class="left-side-bar__mid__function__name">Settings</h1>
          </a>
        </section>
      </div>

      <div class="main">
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
                $sql = "SELECT * FROM medicine";
                $all_medicine = mysqli_query($con, $sql);
                
                while ($row = mysqli_fetch_array($all_medicine)) {
                  $price = number_format((float)$row['price'], 2);

                  echo 
                  "
                <div class='table__body__card'>
                  <div class='table__body__card__item check'>
                    <div></div>
                  </div>
                  <div class='table__body__card__item generic'>
                    <h1 class='name'>{$row['generic_name']}</h1>
                  </div>
                  <div class='table__body__card__item brand'>
                    <h1 class='name'>{$row['brand_name']}</h1>
                  </div>
                  <div class='table__body__card__item company'>
                    <h1 class='name'>{$row['company']}</h1>
                  </div>
                  <div class='table__body__card__item dosage'>
                    <h1 class='name'>{$row['dosage']}</h1>
                  </div>
                  <div class='table__body__card__item price'>
                    <h1 class='name'>{$price}</h1>
                  </div>
                  <div class='table__body__card__item menu'>
                    <img src='../static/3dots.svg' />
                  </div>
                </div>
                  ";
                }
              ?>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
