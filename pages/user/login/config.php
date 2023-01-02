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

    $sql = "SELECT MAX(gno) FROM Guest";
    $stmt = mysqli_prepare($link, $sql);
    if($stmt) {
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $user_id);
                if(mysqli_stmt_fetch($stmt)){
                    $user_id = $user_id + 1;
                    // echo $user_id;
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
}

?>