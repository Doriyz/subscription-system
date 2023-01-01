<?php
include "../../refresh.php";
?>


<?php
// Initialize the session
session_start();
 
require_once "config.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../welcome.php");
    exit;
}
 


 
// Define variables and initialize with empty values
$telephone = $password = "";
$telephone_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if telephone is empty
    if(empty(trim($_POST["telephone"]))){
        $telephone_err = "Please enter telephone.";
    } 
    elseif(!is_numeric($_POST['telephone'])){
        $telephone_err = "Please enter a valid telephone number.";
    }
    else{
        $telephone = trim($_POST["telephone"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($telephone_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT * FROM Guest WHERE gtelephone = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_telephone);
            
            // Set parameters
            $param_telephone = $telephone;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if telephone exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $name, $hashed_password, $email, $address, $telephone, $postcode);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;
                            $_SESSION["address"] = $address;
                            $_SESSION["telephone"] = $telephone;                            
                            $_SESSION["postcode"] = $postcode;

                            // Redirect user to welcome page
                            header("location: ../welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid telephone or password.";
                        }
                    }
                } else{
                    // telephone doesn't exist, display a generic error message
                    $login_err = "Invalid telephone or password.";
                }
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
 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>log in</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">
    <link href="../../../styles/style.css" rel="stylesheet">
    <style>
        div {
            width: 400px;
        }
        body{ 
            font: 18px sans-serif; 
        }
        .wrapper{ 
            width: 360px; 
            padding: 20px; 
            margin: 0 auto;
        }
        .center { 
            padding-top:3% ;
            display: flex;
            justify-content: center;
        } 
        .btn {
            font-size: 18px;
            vertical-align: middle;
            padding: 10px 20px;
            border-radius: 10px;
            width: 50%;
            height: 40px;
        }
        .form-group {
            margin-bottom: 13px;
            font-family: "corebell";
            font-size: 17px;
        }
        p {
            font-family: "bell MT";
            font-size: 20px;
            text-align: center;
        }
        input {
            margin-top: 1%;
            margin-bottom: 1%;
            width: 100%;
            height: 25px;
            padding: 2px;
            font-size: 15px;
        }
        label {
            font-family: "corebell";
            font-size: 20px;
        }
        .icon{
            width: 35px;
            height: 35px;
            margin: 10px 10px;
            text-decoration: none;
            font-size: large;
            display: inline-block;
            text-align: left;
        }
        .icon:hover{
        text-decoration: none;
        }
        
    </style>
</head>
<body>
<?php
echo'
<div>
    <!-- add a icon to jump to homepage -->
    <a href="javascript:history.back()" title="return back"><img src="/subscription-system/images/return.png" class="icon"></img></a>
    <a href="../../index.php" title="jump to home page"><img src="/subscription-system/images/homeicon.png" class="icon"></img></a>
</div>
'
?>

    <div class="wrapper">
        <h2>Log in</h2>
        <p>Please fill in your credentials to login.</p>
        <?php 
        if(!empty($login_err)){
            echo ('<div class="alert alert-danger" backgroundcolor="balck">' . $login_err . '</div>');
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>telephone</label>
                <input type="text" name="telephone" class="form-control <?php echo (!empty($telephone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telephone; ?>">
                <span class="invalid-feedback"><?php echo $telephone_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div >
                <input type="submit" class="btn btn-primary center" value="Log in">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>