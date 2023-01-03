<?php
include "../../../refresh.php";
?>

<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "../../login/config.php";
    $param_id = trim($_POST["id"]);
    
    // consider the foreign key constraint, we should delete the record in the table which has the foreign key first
    // get the ono to of the guest
    $sql = "SELECT ono FROM Orders WHERE gno = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    while($row = mysqli_fetch_array($result)){
        $value = $row['ono'];
        echo $value;

        // delete the record in the table Bill
        $sql = "DELETE FROM Bill WHERE ono = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $value);
        if(!mysqli_stmt_execute($stmt)){
            echo mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    
        // delete the record in the table Orders
        $sql = "DELETE FROM Orders WHERE ono = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $value);
        if(!mysqli_stmt_execute($stmt)){
            echo mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }

    $sql = "DELETE FROM Guest WHERE gno = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        $param_id = trim($_POST["id"]);
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        if(mysqli_stmt_execute($stmt)){
            header("location: main.php");
            exit();
        } else{
            echo mysqli_stmt_error($stmt);
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["gno"]))){
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
                <input type="hidden" name="id" value="<?php echo trim($_GET["gno"]); ?>"/>
                <p>Are you sure you want to delete this Guest record?</p>
                <p>
                    <input type="submit" value="Yes" class="btn btn-danger">
                    <a href="main.php" class="btn btn-secondary">No</a>
                </p>
            </div>
        </form>
                
    </div>
</body>
</html>