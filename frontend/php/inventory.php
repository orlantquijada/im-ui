<?php
  // db connection
  $con = mysqli_connect('localhost','root','','pharmacy_db')
  or die('Error connecting to MySQL server.');

  // helper function
  function normalize_price_text($price) {
    return number_format((float)$price, 2);
  }

  $generic_name = "";
  $company_name = "";
  $brand_name = "";
  $quantity = "";
  $dosage = "";
  $price = "";

  $is_edit = false;

  if (isset($_POST['editComplete'])) {
    $generic_name = $_POST['genericName'];
    $company_name = $_POST['companyName'];
    $brand_name = $_POST['brandName'];
    $quantity = $_POST['quantity'];
    $dosage = $_POST['dosage'];
    $price = $_POST['price'];

    echo $price;

    $edit_query = "UPDATE `medicine` SET `company`='{$company_name}',`generic_name`='{$generic_name}',`brand_name`='{$brand_name}',
                                         `quantity`={$quantity},`dosage`='{$dosage}',`price`={$price} WHERE `id`={$_POST['id']}";
    mysqli_query($con, $edit_query);

    header('location: inventory.php');
  };

  if (isset($_GET['edit'])) {
    $is_edit = (bool)$_GET['edit'];
  }
 
  if ($is_edit) {
    $id_to_edit = $_GET['id'];
    $sql_edit = "SELECT * FROM medicine WHERE id={$id_to_edit} LIMIT 1";
    $medicine_instance = mysqli_query($con, $sql_edit);

    $row = mysqli_fetch_assoc($medicine_instance);
  
    $generic_name = $row["generic_name"];
    $company_name = $row["company"];
    $brand_name = $row["brand_name"];
    $quantity = $row["quantity"];
    $dosage = $row["dosage"];
    $price = normalize_price_text($row["price"]);

    // Edit Modal Section
    echo "
    <div class='modal modal--show' class='MedicineModal' id='editMedicineModal'>
      <div class='medicineModal'>
        <div class='header'>
          <h1 class='title'>Edit Item</h1>
        </div>
        <form action='inventory.php' method='POST' class='form'>
          <div class='form__main' >
            <div class='form__main__form-item' id='generic'>
              <h1 class='title'>Generic Name :</h1>
              <input type='text' class='input' name='genericName' value='{$generic_name}' />
            </div>
            
            <div class='form__main__form-item' id='company'>
              <h1 class='title'>Company Name :</h1>
              <input type='text' class='input' name='companyName' value='{$company_name}' />
            </div>

            <div class='form__main__form-item' id='brand'>
              <h1 class='title'>Brand Name :</h1>
              <input type='text' class='input' name='brandName' value='{$brand_name}' />
            </div>

            <div class='form__main__form-item' id='dosage'>
              <h1 class='title'>Dosage :</h1>
              <input type='text' class='input' name='dosage' value='{$dosage}' />
            </div>

            <div class='form__main__form-item' id='price'>
              <h1 class='title'>Price :</h1>
              <input type='text' class='input' name='price' value='{$price}' />
            </div>

            <div class='form__main__form-item' id='qty'>
              <h1 class='title'>Stocks Available :</h1>
              <input type='text' class='input' name='quantity' value='{$quantity}' />
            </div>
          </div>

          <div class='buttons'>
            <div class='buttons__main'>
              <button type='reset' class='cancel btn' id='editMedicineModalClose'><h1>Cancel</h1></button>
              <button type='submit' class='submit btn' name='editComplete' value=1><h1>Confirm</h1></button>
            </div>
          </div>

          <input type='hidden' name='id' value='{$id_to_edit}' />
        </form>
      </div>
    </div>
    ";
  }
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
          <a href="index.php" class="left-side-bar__mid__function">
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
        </section>
      </div>

      <div class="main" id="inventory">
        <form action="inventory.php" method="GET" class="search">
          <div class="search__main">
            <button type="submit" name="searchSubmit" class="btn" value=1>
              <img src="../static/search.svg" class="search__main__logo" />
            </button>
            <input
              type="search"
              name="search"
              class="search__main__name"
              placeholder="Search"
            />
          </div>
          <h1 class="search__results-count">
            <?php 
              if (isset($_GET['searchSubmit']) && isset($_GET['search'])) {
                $search = $_GET['search'];
                $search_count_sql = "SELECT COUNT(*) AS total FROM medicine WHERE generic_name LIKE '%{$search}%'";

                $search_count = mysqli_fetch_assoc(mysqli_query($con, $search_count_sql));

                echo $search_count['total'];
                echo $search_count['total'] == '1' ? ' result' : ' results';
              }
            ?>
          </h1>
        </form>

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
            <div class="table__header__item quantity">
            <h1 class="name">Stocks Available</h1>
            </div>
          </section>

          <section class="table__body">
              <?php
                $sql = "SELECT * FROM medicine";

                if (isset($_GET['searchSubmit']) && isset($_GET['search'])) {
                  $search = $_GET['search'];
                  $sql = "SELECT * FROM medicine WHERE generic_name LIKE '%{$search}%'";
                }

                $all_medicine = mysqli_query($con, $sql);
                
                while ($row = mysqli_fetch_array($all_medicine)) {
                  $price = normalize_price_text($row["price"]);
                  $id = $row['id'];
                  
                  echo 
                  "
                <div class='table__body__card inventory' id='{$id}'>
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
                  <div class='table__body__card__item quantity'>
                    <h1 class='name'>{$row['quantity']}</h1>
                </div>
                  <a href='inventory.php?edit=1&id={$id}' class='table__body__card__item menu'>
                    <img src='../static/edit.svg' />
                  </a>
                </div>
                  ";
                }
              ?>
          </section>
        </div>
      </div>

      <div class="main-functions">
        <div class="main-functions__function modal-activator" id="addMedicineButton">
          <img src="../static/add.svg">
        </div>
      </div>

      <!-- Add Modal Section -->
      <?php
        if (isset($_POST['addComplete'])) {
          $add_generic_name = $_POST['genericNameAdd'];
          $add_company_name = $_POST['companyNameAdd'];
          $add_brand_name = $_POST['brandNameAdd'];
          $add_dosage = $_POST['dosageAdd'];
          $add_price = $_POST['priceAdd'];
          $add_qty = $_POST['quantityAdd'];

          $insert_medicine_sql = "INSERT INTO `medicine`(`generic_name`, `company`, `brand_name`, `dosage`, `price`, `quantity`) VALUES 
                                 ('{$add_generic_name}','{$add_company_name}', '{$add_brand_name}','{$add_dosage}', {$add_price}, {$add_qty})";
          $insert_medicine = mysqli_query($con, $insert_medicine_sql);
        }
      ?>
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
      <!-- End of Modal -->
    </div>

    <script src="../js/modal.js"></script>
  </body>
</html>
