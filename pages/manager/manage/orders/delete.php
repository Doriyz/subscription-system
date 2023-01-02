<!-- <?php
include "../../../refresh.php";
?>

<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "../../login/config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM Bill WHERE ono = ?;DELETE FROM Orders WHERE ono = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_id, $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: main.php");
            exit();
        } else{
            // print error message
            echo mysqli_stmt_error($stmt);
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
     
} else{
    // Check existence of id parameter
    // if(empty(trim($_GET["ono"]))){
        // URL doesn't contain id parameter. Redirect to error page
        // header("location: error.php");
        // exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../../../images/favicon.png" type="image/x-icon">    
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../styles/style.css">
    <style>
        .wrapper{
            width: 50%;
            margin: 30px auto 0;
        }
        .btn{
            width: 100px;
            height: 40px;
            font-size: 20px;
            margin: 5px 5px;
            border-radius: 13px;
        }
    </style>
</head>
<body>
    <div class="wrapper">  
        <h1>Delete Record</h1>
        <h1>
        <?php echo trim($_GET["ono"]); ?>
        </h1>
    </div>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert alert-danger">
                <input type="hidden" name="id" value="<?php echo trim($_GET["ono"]); ?>"/>
                <p>Are you sure you want to delete this order record?</p>
                <p>
                    <input type="submit" value="Yes" class="btn btn-danger">
                    <a href="main.php" class="btn btn-secondary">No</a>
                </p>
            </div>
        </form>
                
    </div>
</body>
</html> -->



<?php
include "../../../refresh.php";
?>

<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "../../login/config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM Bill WHERE ono = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            $sql = "DELETE FROM Orders WHERE ono = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            header("location: main.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement

} else{
    // Check existence of id parameter
    if(empty(trim($_GET["ono"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../../../images/favicon.png" type="image/x-icon">    
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../styles/style.css">
    <style>
        .wrapper{
            width: 50%;
            margin: 30px auto 0;
        }
        .btn{
            width: 100px;
            height: 40px;
            font-size: 20px;
            margin: 5px 5px;
            border-radius: 13px;
        }
    </style>
</head>
<body>
    <div class="wrapper">  
        <h1>Delete Record</h1>
    </div>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert alert-danger">
                <input type="hidden" name="id" value="<?php echo trim($_GET["ono"]); ?>"/>
                <p>Are you sure you want to delete this Newspaper record?</p>
                <p>
                    <input type="submit" value="Yes" class="btn btn-danger">
                    <a href="main.php" class="btn btn-secondary">No</a>
                </p>
            </div>
        </form>
                
    </div>
</body>
</html>