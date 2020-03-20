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
    
    <!-- Add Modal Section -->
      <?php
        $generic_name = "";
        $company_name = "";
        $brand_name = "";
        $quantity = "";
        $dosage = "";
        $price = "";

        $sql = "SELECT * FROM transaction WHERE is_payed = false";
        $check_transaction = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($check_transaction);
        if($row == NULL){
          $sql = "INSERT INTO transaction (employee_id) VALUES ('1')";
          $result = mysqli_query($con, $sql);
          $row = mysqli_fetch_array($result);
        }
        $transaction_id = $row['id'];
        $is_edit = false;

        if(isset($_POST['addComplete'])){
          $medicine_id = $_POST['medicineId'];
          $items_purchased = $_POST['itemsPurchased'];
          $add_purchase = "INSERT INTO ordered_item (transaction_id, medicine_id, quantity) VALUES ('$transaction_id', '$medicine_id', '$items_purchased')";
          $insert_order = mysqli_query($con, $add_purchase);
        }

        if (isset($_GET['edit'])) {
          $is_edit = (bool)$_GET['edit'];
        }

        echo $is_edit;
       
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
          $price = money($row["price"]);
          echo
          "
          <div class='modal modal--show' class='MedicineModal' id='addMedicineModalCheckout'>
        <div class='medicineModal'>
          <div class='header'>
            <h1 class='title'>Purchase Item</h1>
          </div>
          <div class='form'>
            <div class='form__main' >
              <div class='form__main__form-item'>
                <h1 class='title'>Generic Name :</h1>
                <input type='text' class='input' name='genericNameAdd' value='{$generic_name}'/>
              </div>
              
              <div class='form__main__form-item'>
                <h1 class='title'>Company Name :</h1>
                <input type='text' class='input' name='companyNameAdd' value='{$company_name}'/>
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Brand Name :</h1>
                <input type='text' class='input' name='brandNameAdd' value='{$brand_name}'/>
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Dosage :</h1>
                <input type='text' class='input' name='dosageAdd' value='{$dosage}'/>
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Price :</h1>
                <input type='text' class='input' name='priceAdd' value='{$price}'/>
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Stocks Available :</h1>
                <input type='text' class='input' name='quantityAdd' value='{$quantity}'/>
              </div>
            </div>

            <form action='index.php' method='POST'>
              <div class='form__main__form-item'>
                <h1 class='title'>Quantity :</h1>
                <input type='text' class='input' name='itemsPurchased' />
              </div>
              
              <div class='buttons'>
                <div class='buttons__main'>
                  <button type='reset' class='cancel btn' id='addMedicineModalCloseCheckout'><h1>Cancel</h1></button>
                  <button type='submit' class='submit btn' name='addComplete' value=1><h1>Confirm</h1></button>
                </div>
              </div>

              <input type='hidden' name='medicineId' value={$id_to_edit} />
            </form>
          </div>
        </div>
      </div>
          ";
        }
      ?>
      <!-- End of Modal -->
  </div>
  <script src="../js/modal.js"></script>
  <script language="Javascript">
    function unavailable() {
      alert("Item unavailable!");
    }
  </script>
</body>

</html>