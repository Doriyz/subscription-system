<?php
include "../../refresh.php";
?>

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login/login.php");
    exit;
}

// Include config file
require_once "../login/config.php";
?>




<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Bills</title>
    <link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">
    <link href="../../../styles/style.css" rel="stylesheet">
    <style>
        body{
            padding-bottom: 100px;
        }
        .btn-primary{
            font-size: large;
            border-radius: 15px;
            width: 100px;
            height: 30px;
            padding: 10px;
            background-color: #794a9a;
            display: block;
            margin: 0 auto;
            text-shadow: none;
            text-align: center;
        }
        .btn-primary:hover{
            background-color: #ac3d6a;
        }


        table {
            height: auto;
            line-height: 33px;
            text-align: center;
            padding: 2px;
            border-radius: 1em;
            overflow: hidden;
            margin: 0 auto;
            font-size: 17px;
        }
       
        table tr th, table tr td{
            padding: 5px 10px;
            width: 150px;
        }
        table tr th{
            background-color: #B5D5C5;
            color: #002a00;
            font-size: 18px;
            line-height: 38px;
            width: 150px;
        }
        th, td {
            padding: 1em;
            background: #F5F5DC;
            border-bottom: 1px solid white;
        }

        .price{
            text-shadow:  3px 3px 1px rgb(187, 187, 187);
            font-size: 30px;
            font-weight: bold;
            text-align: right;
            color: #136d34;
            margin-right: 10%;
        }


        .wrapper{ 
            padding: 15px 10px 0 0; 
            margin: 0 auto;
            font-size: 50px;
            text-align: center;
        }
        
    </style>

</head>


<body>
    <div class="wrapper">
    <h1><b>Your Bills</b></h1>

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
            echo "<p class='price'>Total Price: ".$total_price."</h2>";
        }
    }

    ?>
    <br></br>
    </div>
    <a href="../welcome.php" class="btn btn-primary">Back</a>

</body>
</html>