<?php
function money($value)
{
  if ($value < 0) return "-" . money(-$value);
  return '₱' . number_format($value, 2);
}
$con = mysqli_connect("localhost", "root", "", "pharmacy_db");

$sql = "SELECT * FROM transaction WHERE is_payed = false";
$check_transaction = mysqli_query($con, $sql);
$row = mysqli_fetch_array($check_transaction);
if ($row == NULL) {
  $sql = "INSERT INTO transaction (employee_id) VALUES ('1')";
  $result = mysqli_query($con, $sql);
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
      <form action="index.php" method="GET" class="search">
        <div class="search__main">
          <button type="submit" name="searchSubmit" class="btn" value=1>
            <img src="../static/search.svg" class="search__main__logo" />
          </button>
          <input type="search" name="search" class="search__main__name" placeholder="Search" />
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
        </section>

        <section class="table__body">
          <?php
          $sql = "SELECT * FROM medicine";

          if (isset($_GET['searchSubmit']) && isset($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT * FROM medicine WHERE generic_name LIKE '%{$search}%'";
          }
          
          $result = mysqli_query($con, $sql);
          $print = "";
          while ($row = mysqli_fetch_array($result)) {
            if ($row['quantity'] <= 0) {
              echo
                "
              <div class='table__body__card table__body__card--unavailable' onclick = 'return unavailable()'>
                ";
            } else {
              echo
                "
                <a href='index.php?edit=1&id=" . $row['id'] . "'>
                <div class='table__body__card'>
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
          <h1 class="name">Transaction Number :</h1>
          <?php
          $sql = "SELECT id FROM transaction WHERE is_payed = false";
          $result = mysqli_query($con, $sql);
          $row = mysqli_fetch_array($result);
          echo "<h1 class='number'>" . str_pad($row['id'], 10, '0', STR_PAD_LEFT) . "</h1>";
          ?>

        </div>
        <div class="line"></div>
      </section>
      <section class="right-side-bar__bot">
        <section class="table">
          <?php
          $sql = "SELECT id FROM transaction WHERE is_payed = false";
          $check_transaction = mysqli_query($con, $sql);
          $row = mysqli_fetch_assoc($check_transaction);
          $total_price = 0;
          $transaction_id = $row['id'];

          $sql = "SELECT M.brand_name, M.dosage, O.quantity, M.price FROM medicine as M, ordered_item as O where O.medicine_id = M.id and O.transaction_id = '$transaction_id'";

          $result = mysqli_query($con, $sql);
          while ($row = mysqli_fetch_array($result)) {
            $price = $row['price'] * $row['quantity'];
            $total_price += $price;
            echo
              "
            <div class='table__card'>
                <div class='table__card__item name'>
                  <h1>" . $row['brand_name'] . " " . $row['dosage'] . "</h1>
                </div>
                <div class='table__card__item piece'>
                  <h1>" . $row['quantity'] . "PC</h1>
                </div>
                <div class='table__card__item price'>
                  <h1>" . money($row['price']) . "</h1>
                </div>
                <div class='table__card__item total'>
                  <h1>" . money($price) . "</h1>
                </div>
              </div>
            ";
          }

          $update_total = "UPDATE transaction SET total = $total_price WHERE id = '$transaction_id'";
          $result = mysqli_query($con, $update_total);
          ?>
        </section>

        <section class="calculations">
          <div class="total-items">
            <h1 class="name">TOTAL ITEMS:</h1>
            <?php
            $sql = "SELECT COUNT(*) FROM ordered_item WHERE ordered_item.transaction_id = '$transaction_id'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);

            echo "<h2 class='number'>" . $row[0] . "</h2>";
            ?>


          </div>
        </section>
        <div class="line--broken"></div>
        <section class="total">
          <h1 class="name">TOTAL:</h1>
          <?php
          $sql = "SELECT id FROM transaction WHERE is_payed = false";
          $check_transaction = mysqli_query($con, $sql);
          $row = mysqli_fetch_assoc($check_transaction);

          $sql = "SELECT total FROM transaction WHERE id = '$transaction_id'";
          $result = mysqli_query($con, $sql);
          $row = mysqli_fetch_assoc($result);
          echo "<h1 class='number'>" . money($row['total']) . "</h1>";
          ?>
        </section>
        <form action='index.php' method='post'>
          <div class="pay-transaction">
            <h1 class="title">Enter payment:</h1>
            <input type='text' class='input-payment' name='payment' tabIndex=2 />
          </div>
          <button type='submit' class="pay-total" name='payTransaction'>
            <h1>Pay</h1>
          </button>
        </form>
        <?php
        if (isset($_POST['payTransaction'])) {
          if (empty($_POST['payment'])) {
            echo "<script language='Javascript'>alert('Must input payment!')</script>";
          } else {
            $payment = $_POST['payment'];

            $get_transaction = "SELECT * FROM transaction WHERE is_payed = false";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);

            if ($payment < $row['total']) {
              echo "<script language='Javascript'>alert('Insufficient payment!')</script>";
            } else {
              $insert_payment = "UPDATE transaction SET payment = '$payment'";
              $result = mysqli_query($con, $insert_payment);

              $get_change = "SELECT total FROM transaction WHERE is_payed = false";

              $change = $payment - $row['total'];

              $update_payed = "UPDATE transaction SET is_payed = true WHERE is_payed = false";
              $result = mysqli_query($con, $update_payed);

              $sql = "SELECT * FROM transaction WHERE is_payed = false";
              $check_transaction = mysqli_query($con, $sql);
              $row = mysqli_fetch_array($check_transaction);
              echo
                "
                <section class='total'>
                  <h1 class='name'>CHANGE : </h1>
                  <h1 class='number' style='padding-top: 10px;'>" . money($change) . "</h1>
                </section>
                ";
            }
          }
        }
        ?>


      </section>
    </section>

    <!-- Add Modal Section -->

    <?php
    $sql = "SELECT id FROM transaction WHERE is_payed = false";
    $check_transaction = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($check_transaction);
    $is_edit = false;

    if (isset($_POST['addComplete'])) {
      $medicine_id = $_POST['medicineId'];  //get medicine_id
      if (empty($_POST['itemsPurchased'])) {
        echo "<script language='Javascript'>alert('Invalid input!')</script>";
      }
      $items_purchased = $_POST['itemsPurchased'];  //get items purchased
      echo $items_purchased;
      $check_quantity = $sql = "SELECT quantity FROM medicine WHERE id='$medicine_id'";  //checks the quantity of the medicine
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($result);
      if ($row['quantity'] < $items_purchased) {  //if quantity exceeds, alert box
        echo "<script language='Javascript'>alert('Numbers exceeded!')</script>";
      } else {
        $check_duplicate = "SELECT * FROM ordered_item WHERE medicine_id = '$medicine_id' AND transaction_id = '$transaction_id'";  //checking for duplicate
        $result = mysqli_query($con, $check_duplicate);
        $row = mysqli_fetch_array($result);

        if ($row != NULL) { //if there's a duplicate
          $get_quantity = "SELECT quantity FROM ordered_item WHERE medicine_id = '$medicine_id' AND transaction_id = '$transaction_id'"; //get quantity of existing order
          $result = mysqli_query($con, $get_quantity);
          $row = mysqli_fetch_array($result);
          $new_quantity = $row['quantity'] + $items_purchased; //set new quantity
          $update_purchase = "UPDATE ordered_item SET quantity = '$new_quantity' WHERE medicine_id = '$medicine_id'";
          $result = mysqli_query($con, $update_purchase);
        } else {
          $add_purchase = "INSERT INTO ordered_item (transaction_id, medicine_id, quantity) VALUES ('$transaction_id', '$medicine_id', '$items_purchased')";  //add new ordered item
          $insert_order = mysqli_query($con, $add_purchase);
        }

        $check_quantity = $sql = "SELECT quantity FROM medicine WHERE id='$medicine_id'";  //checks the quantity of the medicine
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $diff = $row['quantity'] - $items_purchased;  //update medicine quantity
        $update_quantity = "UPDATE medicine SET quantity = '$diff' WHERE id = '$medicine_id'";
        $update_query = mysqli_query($con, $update_quantity);
        echo "<meta http-equiv='refresh' content='0'>";
      }
    }

    if (isset($_GET['edit'])) {
      $is_edit = (bool) $_GET['edit'];
    }


    if ($is_edit) {
      $id_to_edit = $_GET['id'];
      $sql_edit = "SELECT * FROM medicine WHERE id={$id_to_edit}";
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
                <input type='text' class='input' name='genericNameAdd' value='{$transaction_id}' readonly/>
              </div>
              
              <div class='form__main__form-item'>
                <h1 class='title'>Company Name :</h1>
                <input type='text' class='input' name='companyNameAdd' value='{$company_name}' readonly/>
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Brand Name :</h1>
                <input type='text' class='input' name='brandNameAdd' value='{$brand_name}' readonly/>
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Dosage :</h1>
                <input type='text' class='input' name='dosageAdd' value='{$dosage}' readonly/>
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Price :</h1>
                <input type='text' class='input' name='priceAdd' value='{$price}' readonly/>
              </div>

              <div class='form__main__form-item'>
                <h1 class='title'>Stocks Available :</h1>
                <input type='text' class='input' name='quantityAdd' value='{$quantity}' readonly/>
              </div>
            </div>

            <form action='index.php' method='POST'>
              <div class='form__main__form-item'>
                <h1 class='title'>Quantity :</h1>
                <input type='text' class='input' name='itemsPurchased' autofocus/>
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
  <script src="../js/modal.js">
    </script>
    <script language="Javascript">
      function unavailable() {
        alert("Item unavailable!");
      }
    </script>
</body>

</html>