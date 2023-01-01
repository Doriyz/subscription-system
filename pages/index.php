<?php
include "refresh.php";
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>home page</title>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link href="../styles/style.css" rel="stylesheet" charset= utf-8 type="text/css">
    <!-- the sequence of the css files is important, the last one will overwrite the previous ones -->
    <style>
      .div-index { 
        padding-top:3% ;
        display: flex;
        justify-content: center;

      } 
  
      body{
        padding-top: 3%;

      }
      .first{
        width: 85%;
        height: auto;
        border-radius: 10px;
      }
      h1{
        text-align: center;
        width: 80%;
        padding-left: 10%;
        padding-bottom: 1%;
      }
    </style>  
  </head>

  <body>
  <h1>welcome to newspaper subscription system</h1>
  <img src="../images/first.png" alt="first image" class="first">

  <div class="div-index">
  <a class="btn-primary" href="user/login/login.php" title="log in as user">log in</a>
  <a class="btn-primary" href="user/login/register.php" title="register as user">register</a>
  <a class="btn-primary" href="manager/login/login.php" title="only availble for manager">manage</a>
  </div>

  </body>

</html>



