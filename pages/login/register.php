<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = "";
$password = "";
$confirm_password = "";
$email = "";
$address = "";
$telephone = "";
$postcode = "";
$username_err = "";
$password_err = "";
$confirm_password_err = "";
$email_err = "";
$address_err = "";
$telephone_err = "";
$postcode_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate telephone
    if(empty(trim($_POST["telephone"]))){
        $telephone_err = "Please enter a telephone.";
    } elseif(!preg_match('/^[0-9]+$/', trim($_POST["telephone"]))){
        $telephone_err = "invalid telephone.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM Guest WHERE telephone = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_telephone);
            
            // Set parameters
            $param_telephone = trim($_POST["telephone"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $telephone_err = "This telephone is already taken.";
                } else{
                    $telephone = trim($_POST["telephone"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        $username = trim($_POST["username"]);
    }


    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Validate email
    if(!empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    }
    else{
        $email = trim($_POST["email"]);
    }

// Validate email address, maybe accomplish later
//     <script type="text/javascript">
// 	//onblur失去焦点事件，用户离开输入框时执行 JavaScript 代码：
// 	//函数：验证邮箱格式
//   	function isEmail(strEmail){
//   		//定义正则表达式的变量:邮箱正则
//   		var reg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
//   		console.log(strEmail);
//   		//文本框不为空，并且验证邮箱正则成功，给出正确提示
//   		if(strEmail != null && strEmail.search(reg) != -1)
//   		{
//   			document.getElementById("test_user").innerHTML = "<font color='green' size='4px'>√邮箱格式正确！</font>";
//   		}else{
//   			document.getElementById("test_user").innerHTML = "<font color='red' size='4px'>邮箱格式错误！</font>";
//   		}
//   	}
//   </script>

    // Validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter a address.";
    } else{
        $address = trim($_POST["address"]);
    }

    // Validate postcode
    if(empty(trim($_POST["postcode"]))){
        $postcode_err = "Please enter a postcode.";
    } elseif(!preg_match('/^[0-9]+$/', trim($_POST["postcode"]))){
        $postcode_err = "invalid postcode.";
    } else{
        $postcode = trim($_POST["postcode"]);
    }

    // Check input errors before inserting in database
    if( empty($telephone_err)
        &&empty($email_err) 
        && empty($password_err) 
        && empty($confirm_password_err) 
        && empty($username_err)
        && empty($address_err)
        && empty($postcode_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Guest VALUES (?, ?, ?, ?, ?, ?, ?)";
        // the first ? is the id of the guest, which is auto-incremented
        if($stmt = mysqli_prepare($link, $sql)){
            

            // need a mysql interact here to get the id of the guest
            $para_id = $user_id;
            // !!!!!!!!!!!!!!!! generate the id in the config.php

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $para_id, $param_username, $param_password, $param_email, $param_address, $param_telephone, $param_postcode);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_telephone = $telephone;
            $param_email = $email;
            $param_address = $address;
            $param_postcode = $postcode;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
    <!-- <meta http-equiv="refresh" content="3"> -->
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
    <link href="../../styles/style.css" rel="stylesheet">
    <!-- <link href="../../styles/log_in.css" rel="stylesheet"> -->
    <meta http-equiv="refresh" content="30">
    <style>
        div {
            width: 400px;
        }
        body{ font: 14px sans-serif; }
        .wrapper{ 
            width: 360px; 
            padding: 20px; 
            margin: 0 auto;}
    </style>
    
</head>


    


<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>telephone</label>
                <input type="text" name="telephone" class="form-control <?php echo (!empty($telephone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telephone; ?>">
                <span class="invalid-feedback"><?php echo $telephone_err; ?></span>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>address</label>
                <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                <span class="invalid-feedback"><?php echo $address_err; ?></span>
            </div>
            <div class="form-group">
                <label>postcode</label>
                <input type="text" name="postcode" class="form-control <?php echo (!empty($postcode_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $postcode; ?>">
                <span class="invalid-feedback"><?php echo $postcode_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>