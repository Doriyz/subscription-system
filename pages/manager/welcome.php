<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="3"> -->
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
    <link href="../../styles/style.css" rel="stylesheet">
    <!-- <link href="../../styles/log_in.css" rel="stylesheet"> -->
    <!-- <meta http-equiv="refresh" content="30"> -->
    <style>
        div {
            width: 400px;
        }
        body{ font: 14px sans-serif;
            text-align: center;}
        .wrapper{ 
            width: 360px; 
            padding: 20px; 
            margin: 0 auto;}
    </style>
    <style>
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

    </style>
    
</head>


<body>
    <h1 class="my-5"><b>Hi, <?php echo htmlspecialchars($_SESSION["name"]); ?>.<br> Let's do some manage task.</b></h1>
    
    <a href="/subscription-system/pages/manager/paper.php" class="btn-primary btn-third">View and Change Newspaper</a><br>
    <!-- <a href="/subscription-system/pages/information/personalInfo.php" class="btn-primary">View Your Information</a><br>
    <a href="/subscription-system/pages/information/personalBills.php" class="btn-primary">View Your Bills</a><br>
    <a href="/subscription-system/pages/login/reset-password.php" class="btn-primary btn-secondary" >Reset Your Password</a><br>
    <a href="/subscription-system/pages/login/logout.php" class="btn-primary btn-secondary">Sign Out of Your Account</a><br>
 -->

</body>
</html>