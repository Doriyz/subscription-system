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
    <!-- <meta http-equiv="refresh" content="3"> -->
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Information</title>
    <link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">
    <link href="../../../styles/style.css" rel="stylesheet">

    <style>
 
        body{ 
            font: 14px sans-serif;
            text-align: center;
        }
        .wrapper{ 
            padding: 20px; 
            margin: 0 auto;
        }

        .btn-primary{
            font-size: large;
            border-radius: 15px;
            width: 50px;
            background-color: #794a9a;
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
            width: 500px;
        }
        table tr th{
            background-color: #B5D5C5;
            color: #002a00;
            font-size: 18px;
            line-height: 40px;
            width: 150px;
        }
        th, td {
            padding: 1em;
            background: #F5F5DC;
            border-bottom: 1px solid white;
        }

    </style>
    
</head>


<body>
    <div class="wrapper">
    <h1><b>Your Information</b></h1>

    <!-- build the information table -->
    <table>
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
    </div>
   <a href="../welcome.php" class="btn btn-primary">Back</a>
</body>
</html>