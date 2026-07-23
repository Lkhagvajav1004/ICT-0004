<?php
$username = "Progearhub";
$password = "password";
// create connection
$connection = mysqli_connect("127.0.0.1", $username, $password, "progearhub");
//check if connection is successful
if (!$connection){
    echo "<h1 style = 'color:red; '> Database connection error!" .mysqli_connect_error()."</h1>";
}
else{
    // echo all good
}
?>