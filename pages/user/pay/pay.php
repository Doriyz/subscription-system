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
    <title>Check and Pay</title>
    <link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">
    <link href="../../../styles/style.css" rel="stylesheet">
    <style>  
        body {
            padding: 0% 0%;
        }    
        .wrapper{ 
            margin: 0 auto;
            padding-top: 30px;
        }
        table {
            width: auto;
            height: auto;
            line-height: 33px;
            text-align: center;
            padding: 2px;
            border-radius: 1em;
            overflow: hidden;
            margin: 3% auto;
            font-size: 17px;
        }

        table tr th{
            background-color: #B5D5C5;
            color: #002a00;
            font-size: 20px;
            line-height: 40px;
        }
        table tr th, table tr td{
            padding: 5px 10px;
        }

        th, td {
            padding: 1em;
            background: #F5F5DC;
            border-bottom: 1px solid white;
        }
        .btn-primary{
            font-size: large;
            border-radius: 20px;
            height: 55px;
            width: 200px;
            background-color: #794a9a;
            border: white;
            margin: 0 48%;
            display: block;
        }
        .btn-primary:hover{
            background-color: #ac3d6a;
        }

        .price{
            text-shadow:  3px 3px 1px rgb(187, 187, 187);
            font-size: 30px;
            font-weight: bold;
            text-align: right;
            color: #136d34;
            margin-right: 10%;
        }
    </style>
    
</head>


<body>
    <div class="wrapper">
    <h1><b>Check Your Bill</b></h1>

    <!-- build the pay bill -->
    <table>
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
    <?php
   echo "<p class = 'price'>Total Price: " . $total_price . "</h2>";
   ?>
    <button type="button" class="btn btn-primary" onclick="location.href='qrcode.php'">Pay</button>
    </div>  
  
</body>
</html>