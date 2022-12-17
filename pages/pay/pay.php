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
    <title>Check and Pay</title>
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
    
</head>


<body>
    <h1 class="my-5"><b>Check Your Bill</b></h1>

    <!-- build the pay bill -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>no</th>
                <th>name</th>
                <th>price</th>
                <th>frequency</th>
                <th>width</th>
                <th>height</th>
                <th>publisher</th>
                <th><b>Number</b></th>
                <th><b>Period(months)</b></th>
                <th><b>Sum</b></th>
            </tr>
        </thead>
        <tbody>
            <?php
            global $link;
            $Orders = $_SESSION['Orders'];
            $total_price = 0;
            foreach($Orders as $ono){
                //get the information of the order
                $sql = "SELECT pno, pname, pprice, frequency, pwidth, pheight,  ppublisher, onumber, period, pprice*frequency*onumber*period AS sum FROM Orders NATURAL JOIN Paper WHERE ono = ?";
                if($stmt = mysqli_prepare($link, $sql)){
                    mysqli_stmt_bind_param($stmt, "s", $para_ono);
                    $para_ono = $ono;
                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $pno, $pname, $pprice, $frequency, $pwidth, $pheight, $ppublisher, $onumber, $period, $sum);
                        if(mysqli_stmt_fetch($stmt)){
                            $total_price += $sum;
                            echo "<tr>";
                            echo "<td>" . $ono . "</td>";
                            echo "<td>" . $pname . "</td>";
                            echo "<td>" . $pprice . "</td>";
                            echo "<td>" . $frequency . "</td>";
                            echo "<td>" . $pwidth . "</td>";
                            echo "<td>" . $pheight . "</td>";
                            echo "<td>" . $ppublisher . "</td>";
                            echo "<td>" . $onumber . "</td>";
                            echo "<td>" . $period . "</td>";
                            echo "<td>" . $sum . "</td>";
                            echo "</tr>";
                        }
                    }
                    // mysqli_stmt_close($stmt);
                }

            }
            
            ?>
        </tbody>

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
    
   <?php
   echo "<h2 class = 'price'>Total Price: " . $total_price . "</h2>";
   ?>

        <!-- add a button to pay -->
        <button type="button" class="btn btn-primary" onclick="location.href='qrcode.php'">Pay</button>
        
</body>
</html>