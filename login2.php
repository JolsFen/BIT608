<!DOCTYPE HTML>
<html>
  <head>
    <title>Login Page</title> 
  </head>

<?php
include "checksession.php";
include "header.php";
include "config.php";
include "cleaninput.php";

$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
if (mysqli_connect_errno())
{
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit;
}
//if the login form has been filled in
if (isset($_POST['email']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    //prepare the query and send it to the server
    $stmt = mysqli_stmt_init($db_connection);
    mysqli_stmt_prepare($stmt, "SELECT customerID,email,password,admin FROM customer WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $customerID, $hashed_password, $admin);
    mysqli_stmt_fetch($stmt);
}
$username='username';
$customerID='customerID';
$email='email';
$password='password';
$hashed_password='hashed_password';

//this is where the password is checked
if(!$customerID)
{
    echo "<p class=”error”>Unable to find customer with email: ".$email."</p>";
}
else{
    if (password_verify($password, $hashed_password))
    {
        $_SESSION['loggedin'] = true;
        $_SESSION['customerID'] = $customerID;
        $_SESSION['email'] = $email;
        $_SESSION['admin'] = $admin;
        header("Location: home.php");
        echo '<h2>Congratulations! You are logged in.</h2>';
        echo '<h2>If you want to make a booking <a href="makeabooking.php">click here</a>.</p>';
        exit(0);
    }
    else{
        echo '<h2>Username/password combination is wrong, please try again.</h2>';
}
    }

mysqli_close($db_connection); //close the connection once done
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
