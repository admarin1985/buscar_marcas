<?php  //Start the Session
require 'Db.php';
session_start();
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['username']) and isset($_POST['password'])){
    //3.1.1 Assigning posted values to variables.
    $username = $_POST['username'];
    $password = $_POST['password'];
    //3.1.2 Checking the values are existing in the database or not
    $query = "SELECT * FROM `user` WHERE username='$username' and password='$password' and active = 1";

    $db = new Db();
    $rows = $db -> select($query);
    $count = sizeof($rows);
    //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    if ($rows != false && $count == 1){
    $_SESSION['username'] = $username;
    $_SESSION['login'] = true;
    header('Location: index.php');
    }else{
    //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
    $fmsg = "Invalid Login Credentials.";
    header('Location: login.php');
    }
}
//3.1.4 if the user is logged in Greets the user with message
if (isset($_SESSION['username'])){
$username = $_SESSION['username'];
echo "Hai " . $username . "
";
echo "This is the Members Area
";
echo "<a href='logout.php'>Logout</a>";
 
}else{
//3.2 When the user visits the page first time, simple login form will be displayed.
header('Location: login.php');
}
?>