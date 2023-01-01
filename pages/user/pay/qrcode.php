<?php
include "../../refresh.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="3"> -->
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check and Pay</title>
    <link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">
    <link href="../../../styles/style.css" rel="stylesheet">
    <!-- <link href="../../styles/log_in.css" rel="stylesheet"> -->
    <!-- <meta http-equiv="refresh" content="30"> -->
    <!-- <style>
        div {
            width: 400px;
        }
        body{ font: 14px sans-serif;
            text-align: center;}
        .wrapper{ 
            width: 360px; 
            padding: 20px; 
            margin: 0 auto;}
    </style> -->
    <style>
        h1{
            text-shadow: 2px 2px 4px #c9c5c9;
        }

        div {
            width: 60%;
            margin: 40px auto;
            text-align: center;
        }
    </style>
    
</head>

<body>
    <br>
    <br>
    <h1>WeChat Pay is supported</h1>
    <img src="/subscription-system/images/qrcode.png" alt="qrcode" width="300" height="300">
    <br><br>
    <h1 style="font-size: 30px;">Thanks for your subscription !</h1>

    <?php
    echo "<div><p>Waiting for payment...<br>The page will drump to index page after 5 seconds.</p></div>";
    header("refresh: 5; url=../welcome.php");
    ?>

</body>
</html>