<?php
include "../../refresh.php";
?>



<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                // echo "<span>Password updated successfully. Please login again.</span>";
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">
    <link href="../../../styles/style.css" rel="stylesheet">
    <style>
 
        .wrapper{ 
            width: 600px; 
            padding: 30px 150px; 
            margin: 0 auto;
        }
        p {
            font-family: "bell MT";
            font-size: 25px;
            text-align: center;
        }
        input {
            margin-top: 1%;
            width: 100%;
            height: 35px;
            padding: 2px;
            font-size: 25px;
        }
        label {
            font-family: "corebell";
            font-size: 20px;
        }
        .btn-primary{
            font-size: large;
            border-radius: 15px;
            width: 80px;
        }
        input[type="submit"]{
            height: auto;
            width: 200px;
       }
       span {
        color: red;
        display: block;
       }
        .table {
        margin-top: 3%;
        margin-bottom: 3%;
        }
</style>
   
</head>
<body>
    <div class="wrapper">
        <h1>Reset Password</h1>
        <p>Please fill in this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="table">
            <label>New Password</label>
            <input type="password" name="new_password" <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
            <span><?php echo $new_password_err; ?></span>
            </div>
            <div class="table">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password"  <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
            <span><?php echo $confirm_password_err; ?></span>
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-primary" href="../welcome.php" style="background-color:gray">Cancel</a>
        </form>

    </div>    
    
</body>
</html> -->






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta http-equiv="refresh" content="3"> -->
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        div {
            width: 400px;
        }
        body{ font: 14px sans-serif; }
        .wrapper{ 
            width: 440px; 
            padding: 20px; 
            margin: 0 auto;}
        .btn-primary {
            height: 50px;
            padding: 5px 32px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
        }
        form-group {
            width: 100%;
            margin-bottom: 30px;
            padding: 0 20px;
        }
    </style>
   
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
                <link href="../../styles/style.css" rel="stylesheet">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-primary" href="../information/welcome.php" style="background-color:gray">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>