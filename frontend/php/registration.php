<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="login-site">
        <div class="title"><h1>Login at Instruments Database</h1></div>
        <div class="login-bar">
        <form name="myForm" action="" onsubmit="return validateForm()" method="post" required>
            <center>
                Username:<br>
                <input type="text" name="Username"><br><br>
                Password:<br>
                <input type="password" name="Password"><br><br>

                <div class="buttons">
                    <input name="submit" type="submit" value="Login">
                    <div class="register-button"><button><a href="Registration.php">Register</a></button></div>
                </div>
                

            </center>
        </div>
    </div>
    

    <!--Javascript-->

    <script language="Javascript">
        function validateForm() {
            var x = document.forms["myForm"]["Username"].value;
            if (x == "") {
                alert("Username must be filled out");
                return false;
            }
            var x = document.forms["myForm"]["Password"].value;
            if (x == "") {
                alert("Password must be filled out");
                return false;
            }
        }
    </script>

</body>

</html>

<?php
$con = mysqli_connect("localhost","root","","pharmacy_db")
    or die("Error in connnection");

if (isset($_POST["submit"])) {
    if (!empty($_POST['Username']) && !empty($_POST['Password'])) {

        $Username = $_POST['Username'];
        $Password = $_POST['Password'];

        $sql = "SELECT count(*) as count FROM student WHERE username= '$Username'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        $sql = "SELECT count(*) as count as count FROM student WHERE password= '$Password'";
        $resultpass = mysqli_query($con, $sql);
        $rowpass = mysqli_fetch_array($resultpass);

        if ($row[0] == 1) {
            $sql = "SELECT count(*) as count FROM student WHERE password= '$Password'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            if ($row[0] == 1) {
                session_start();
                $_SESSION["Username"] = $Username;
                header('Location: instrument-list.php');
            } else {
                echo '<script language="javascript">';
                echo 'alert("Incorrect password.")';  //not showing an alert box.
                echo '</script>';
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("Incorrect username.")';  //not showing an alert box.
            echo '</script>';
        }
    }
}

?>