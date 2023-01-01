<?php
include "../../refresh.php";
?>

<?php

echo '
<link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">
<link href="../../../styles/style.css" rel="stylesheet">';

// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
echo '<div style="height:30%"></div><div><h1>Good Bye!</h1></div>';
header("refresh: 2; url = ../../index.php");

?>
