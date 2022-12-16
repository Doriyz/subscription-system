<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', '127.0.0.1:40000');
define('DB_USERNAME', 'manager');
define('DB_PASSWORD', 'manager');
define('DB_NAME', 'SubscriptionSystem');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else {
    // define user_id
    $user_id = 0;

}
?>