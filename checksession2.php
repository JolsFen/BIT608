<?php
session_start();

//overrides for development purposes only - comment this out when testing the login
$_SESSION['loggedin'] = 1;     
$_SESSION['admin'] = 9; //this is the ID for the admin user  
$_SESSION['email'] = '$email';
$_SESSION['customerID'] = '$customerID';
//end of overrides

function isAdmin() {
 if (($_SESSION['loggedin'] == 1) and ($_SESSION['admin'] == 9))
     return true;
 else 
     return false;
}
//function to check if the user is logged else send to the login page 
function checkUser() {
return true;
    $_SESSION['URI'] = '';    
    if ($_SESSION['loggedin'] == 1)
       return TRUE;
    else {
       $_SESSION['URI'] = 'http://localhost'.$_SERVER['REQUEST_URI']; //save current url for redirect     
       header('Location: http://localhost/motueka/login.php', true, 303);       
    }       
}

//just to show we are logged in
function loginStatus() {
    $un = $_SESSION['email'];
    if ($_SESSION['loggedin'] == 1)     
        echo "<h2>Logged in as $un</h2>";
    else
        echo "<h2>Logged out</h2>";            
}

//log a user in
function login($id,$username,$customerID) {
   //simple redirect if a user tries to access a page they have not logged in to
   if ($_SESSION['loggedin'] == 0 and !empty($_SESSION['URI']))        
        $uri = $_SESSION['URI'];          
   else { 
     $_SESSION['URI'] =  'http://localhost/motueka/registercustomer.php';         
     $uri = $_SESSION['URI'];           
   }  

   $_SESSION['customerID'] = $customerID;        
   $_SESSION['loggedin'] = 1;   
   $_SESSION['admin'] = $id; 
   $_SESSION['email'] = $username; 
   $_SESSION['URI'] = ''; 
   header('Location: '.$uri, true, 303);        
}

//simple logout function
function logout(){
  $_SESSION['customerID'] = " ";
  $_SESSION['loggedin'] = 0;
  $_SESSION['admin'] = -1;        
  $_SESSION['email'] = " ";
  $_SESSION['URI'] = '';
  header('Location: http://localhost/motueka/index.php', true, 303);    
}
?>
