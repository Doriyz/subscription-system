<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "../login/config.php";
?>




<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="3"> -->
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
    <link href="../../styles/style.css" rel="stylesheet">

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
    
</head>


<body>
    <h1 class="my-5"><b>Your Information</b></h1>

    <!-- build the information table -->
    <table class="table table-bordered" style="font-size: 16px;">
        <?php
        global $link;
        $pno = $_SESSION['id'];
        $sql = "SELECT gname, gemail, gaddress, gtelephone, gpostcode FROM Guest WHERE gno = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $para_pno);
            $para_pno = $pno;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $pname, $pemail, $paddress, $ptelephone, $ppostcode);
                if(mysqli_stmt_fetch($stmt)){

                    echo "<tr><th>name</th><td>".$pname."</td></tr>";
                    echo "<tr><th>email</th><td>".$pemail."</td></tr>";
                    echo "<tr><th>address</th><td>".$paddress."</td></tr>";
                    echo "<tr><th>telephone</th><td>".$ptelephone."</td></tr>";
                    echo "<tr><th>postcode</th><td>".$ppostcode."</td></tr>";

                }
                else{
                    echo "fail to fetch information";
                }
            }
            else{
                echo "fail to execute the statement";
            }
        }
        else{
            echo "fail to prepare the statement";
        }
        ?>

    </table>

    <!-- set the style of h -->
    <style>
        /* h2 {
            color: blue;
            text-align: right;
            text-shadow: none;
            font-size: 30px;
        } */

        .btn-primary{
            font-size: large;
            border-radius: 20px;
            height: 55px;
            width: 200px;
            background-color: #794a9a;
        }
        .btn-primary:hover{
            background-color: #ac3d6a;
        }

        .price{
        text-align: right;
        text-shadow: none;
        font-size: 30px;
        border-color: #ac3d6a;
        border: lightblue;
        padding: 5px 15px;
        text-align: right;
        text-decoration: none;
        margin: 7px 2px;
        transition-duration: 0.4s;
        color: #136d34;
    }

    </style>
    
   <a href="welcome.php" class="btn btn-primary">Back</a>
</body>
</html>