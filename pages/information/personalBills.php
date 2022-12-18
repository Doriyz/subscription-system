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
    <title>Personal Bills</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
    <link href="../../styles/style.css" rel="stylesheet">
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
    <style>
        
        body{ font: 14px sans-serif;
            text-align: center;}
        .wrapper{ 
            width: 500px; 
            padding: 20px; 
            margin: 0 auto;
            font-size: 50px;
        }
 
    </style>
    
</head>


<body>
    <h1 class="my-5"><b>Your Bills</b></h1>

    <!-- get the bills' datetime -->
    <?php
    global $link;
    $bdatetimes = "";
    if(empty($link)){
        echo "Database connection failed";
        return;
    }
    $para_gno = $_SESSION["id"];
    $sql = "select distinct btime from Bill natural join Orders where gno = ".$para_gno.";";
    $result = mysqli_query($link, $sql);
    if($result == true){
        if($result->num_rows > 0){
            $bdatetimes = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    else{
        echo "Error: " . mysqli_error($link);
    }
    ?>

    <!-- print all bills  -->
    <?php
    if(gettype($bdatetimes) == "string"){
        echo "No bills";
        return;
    }
    else{
        $total_price = 0;
        foreach($bdatetimes as $btime){
            echo "<div class='wrapper'></div>";
            echo "<h2>Bill Time: ".$btime["btime"]."</h2>";
            // get the orders in this bill
            $para_btime = $btime["btime"];
            $sql = "select * from Bill natural join Orders natural join Paper where gno = ".$para_gno." and btime = '".$para_btime."' order by ono;";
            $result = mysqli_query($link, $sql);
            if($result == true){
                if($result->num_rows > 0){
                    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
                }
            }
            else{
                echo "Error: " . mysqli_error($link);
            }
            // print the orders
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Newspaper Name</th>";
            echo "<th>Price</th>";
            echo "<th>Frequency</th>";
            echo "<th>Number</th>";
            echo "<th>Period</th>";
            echo "<th>Sum Price</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach($orders as $order){
                $sumprice = $order['pprice'] * $order['frequency'] * $order['onumber'] * $order['period'];
                echo "<tr>";
                echo "<td>" . $order['ono'] . "</td>";
                echo "<td>" . $order['pname'] . "</td>";
                echo "<td>" . $order['pprice'] . "</td>";
                echo "<td>" . $order['frequency'] . "</td>";
                echo "<td>" . $order['onumber'] . "</td>";
                echo "<td>" . $order['period'] . "</td>";
                echo "<td>" . $sumprice. "</td>";
                echo "</tr>";
                $total_price += $sumprice;
            }
            echo "</tbody>";
            echo "</table>";
            // print the total price of this bill
            echo "<h2 class='price'>Total Price: ".$total_price."</h2>";
        }
    }

    ?>


    
   <a href="welcome.php" class="btn btn-primary">Back</a>
</body>
</html>