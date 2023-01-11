<!DOCTYPE HTML>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title> 
  </head>

<?php

include "header.php";
include "config.php";
include "cleaninput.php";
include "checksession.php";


//Get the data and check it before we match it in the database.
$error = 0; //clear our error flag
$msg = '';
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Login')) {

    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit; //stop processing the page further
    }

    if (empty($_POST['username'])) {
        $usernameErr = 'Please enter your user name';
    } else {
        $username = $_POST['username'];
    }
    if (empty($_POST['password'])) {
        $passwordErr = 'Please enter your password';
    } else {
        $password = $_POST['password'];
    }

    //Double check data snip if we have to and clean the input
    if (isset($_POST['username']) and !empty($_POST['username']) and is_string($_POST['username'])) {
        $un = cleanInput($_POST['username']);
        $username = (strlen($un) > 50) ? substr($un, 1, 50) : $un; //check length and clip if too big
    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid username '; //append error message
        $username = '';
    }
    if (isset($_POST['password']) and !empty($_POST['password']) and is_string($_POST['password'])) {
        $pw = cleanInput($_POST['password']);
        $password = (strlen($pw) > 255) ? substr($pw, 1, 255) : $pw; //check length and clip if too big

    } else {
        $error++; //bump the error flag
        $msg .= 'Invalid password '; //append error message
        $password = '';
    }
    //data check complete

    if ($error == 0) {
        $query = "SELECT customerID,email,password,admin FROM customer WHERE email ='$username'";
        $result = mysqli_query($db_connection, $query); //prepare the query
        $rowcount = mysqli_num_rows($result);
        if ($rowcount > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {

                login($row['admin'], $row['email'] . " " . $row['email'], $row['customerID']);
            } else {
?>
                <script>
                    window.alert("Your password is incorrect ")
                </script> <?php

                        }
                    } else {
                            ?>
            <script>
                window.alert("User name does not exist")
            </script> <?php
                    }
                } else {
                    echo "<h2>$msg</h2>" . PHP_EOL;
                }
                mysqli_close($db_connection); //close the connection once done

            }
        
                        ?>

<!--Bootstrap Login-->
<section class="vh-100 gradient-custom" id="customer_login">
    <form action="login.php"  name="login_profile" method="POST">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold md-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                <div class="form-outline form-white mb-4">
                                    <label for="username" class="form-label">Username:</label>
                                    <input type="email" class="form-control" id="username" placeholder="Enter email" name="username" required>
                                </div>
                                <div class="form-outline form-white mb-4">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                                </div>
                                <!--Need to create logic if you forgot your password-->
                                <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#">Forgot password?</a></p>
                                <button class="btn btn-outline-light btn-lg px-5 " type="submit" name="submit" value="Login">Login</button>
                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#" class="text-white"><i class="fab fa-twitter-f fa-lg mx-4 px-2"></i></a>
                                    <a href="#" class="text-white"><i class="fab fa-google-f fa-lg"></i></a>
                                </div>
                            </div>
                            <div>
                                <p class="mb-0">Don't have an account? <a href="registercustomer.php" class="text-white-50 fw-bold">Sign Up</a></p>
                                <a href="index.php">[Cancel]</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</section>

<!--Footer section using Flexbox-->
<?php
include "footer.php";
?>

</body>
</html>
