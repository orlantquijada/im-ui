<?php
session_start();

  $con = mysqli_connect("localhost", "root", "", "pharmacy_db")
    or die("Error in connection");
  $sql = "SELECT * FROM medicine";
  $result = mysqli_query($con, $sql);

  $table = "";

  while ($row = mysqli_fetch_array($result)) {
    $table .=
    "
    <div class='table__body__card'>
      <div class='table__header__item check'>
        <div></div>
      </div>
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
        <h1 class='name'>" . $row['price'] . "  </h1>
      </div>
      <div class='table__body__card__item menu'>
        <button type='submit' name='buy' value='".$row['id']."'>Buy</button>
      </div>
    </div>
    ";
  }


  if(isset($_POST['buy'])){
    
  }
  $id = '';
  if(isset($_GET['buy'])){
    $id = $_GET['buy'];
  }
  $sql = "SELECT * FROM medicine WHERE id = '$id'";
  $result = mysqli_query($con, $sql);
  $modal = "";
  $row = mysqli_fetch_array($result);



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
        <div class="left-side-bar__mid__function">
          <img src="../static/checklist.svg" class="left-side-bar__mid__function__logo" />
          <h1 class="left-side-bar__mid__function__name">Checklist</h1>
        </div>
        <div class="left-side-bar__mid__function left-side-bar__mid__function--active">
          <img src="../static/box.svg" class="left-side-bar__mid__function__logo" />
          <h1 class="left-side-bar__mid__function__name">Inventory</h1>
        </div>
        <div class="left-side-bar__mid__function">
          <img src="../static/feedback.svg" class="left-side-bar__mid__function__logo" />
          <h1 class="left-side-bar__mid__function__name">Messages</h1>
        </div>
        <div class="left-side-bar__mid__function">
          <img src="../static/adjust.svg" class="left-side-bar__mid__function__logo" />
          <h1 class="left-side-bar__mid__function__name">Settings</h1>
        </div>
      </section>
    </section>
    <section class="main">
      <div class="search">
        <div class="search__main">
          <img src="../static/search.svg" class="search__main__logo" />
          <input type="search" name="search" class="search__main__name" placeholder="Search" />
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
        <section class="table__body" action="">
          <form action="" method="post">
            <?php
            if(isset($table)){
              echo $table;
            };
            ?>
          </form>
        </section>
      </div>
    </section>
    

    <!-- Modal Section -->
    <div class="modal">
      <div class="add-medicine">
        <span class="close">+</span>
        <?php
          echo $modal;
        ?>
        <form action="#" method="POST" class="cash-out">
          <div class="total">
            <h1 class="name">Total:</h1>
            <h1 class="number">60.00</h1>
          </div>

          <div class="buttons">
            <button type="reset" class="cancel">
              <h1>Cancel</h1>
            </button>
            <button type="submit" class="submit">
              <h1>Confirm</h1>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>