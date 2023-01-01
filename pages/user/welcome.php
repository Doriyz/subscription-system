<?php
include "../refresh.php";
?>

<?php
// Initialize the session
session_start();
 
require_once "login/config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login/login.php");
    exit;
}
?>
 
 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
    <link href="../../styles/style.css" rel="stylesheet">
    <style>
        
        body{ 
            font: 14px sans-serif;
            text-align: center;
        }

        .btn-primary{
            text-decoration: none;
            background-color: #136d34;
            color: #ffffff;
            transition: 0.5s;
            margin: 12px;
            width: 350px;
        }

        .btn-primary:hover{
            text-decoration: none;
            background-color: #004397;
            color: #ffffff;
        }

        .btn-secondary{
            background-color: #457055;
        }

        .btn-third{
            background-color: #003d14;
        }
        h1{
            margin: 3%;
        }
    </style>
    
</head>


<body>
    <div>
    <h1 class="my-5"><b>Hi, <?php echo htmlspecialchars($_SESSION["name"]); ?>.<br> Welcome to my site.</b></h1>
    </div>

    <div>
    <a href="info/view.php" class="btn-primary btn-third">View and Subscribe Newspaper</a><br>
    <a href="info/personal.php" class="btn-primary">View Your Information</a><br>
    <a href="info/bills.php" class="btn-primary">View Your Bills</a><br>
    <a href="login/reset-password.php" class="btn-primary btn-secondary" >Reset Your Password</a><br>
    <a href="login/logout.php" class="btn-primary btn-secondary">Sign Out of Your Account</a><br>
    </div>
</body>
</html>


