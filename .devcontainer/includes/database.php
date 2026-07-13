<?php
$username = "Progearhub";
$password = "Lm10110428@";
// create connection
$connection = mysqli_connect("db", $username, $password, "Progearhub");
//check if connection is successful
if (!$connection){
    echo "<h1 style = 'color:red; '> Database connection error!" .mysqli_connect_error()."</h1>";
}
else{
    // echo all good
}
?>