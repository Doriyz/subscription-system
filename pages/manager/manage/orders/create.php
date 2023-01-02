<?php
include "../../../refresh.php";
?>

<?php
// Include config file
require_once "../../login/config.php";
 
// Define variables and initialize with empty values
$id = $name = $price = $frequency = $width = $height = $publisher = "";
$name_err = $price_err = $frequency_err = $width_err = $height_err = $publisher_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } 
    else{
        $name = $input_name;
    }
    
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price amount.";     
    } 
    else{
        $price = $input_price;
    }

    // Validate frequency
    $input_frequency = trim($_POST["frequency"]);
    if(empty($input_frequency)){
        $frequency_err = "Please enter the frequency amount.";     
    } elseif(!ctype_digit($input_frequency)){
        $frequency_err = "Please enter a positive integer value.";
    } else{
        $frequency = $input_frequency;
    }

    $input_width = trim($_POST["width"]);
    if(!empty($input_width)){
        $width = $input_width;
    }

    $input_height = trim($_POST["height"]);
    if(!empty($input_height)){
        $height = $input_height;
    }

    $input_publisher = trim($_POST["publisher"]);
    if(!empty($input_publisher)){
        $publisher = $input_publisher;
    }

    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($price_err) && empty($frequency_err)){
        // firstly generate a new paper id
        $id = 0;
        $sql = "SELECT MAX(pno) FROM Paper";
        $stmt = mysqli_prepare($link, $sql);
        if($stmt) {
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id);
                    if(mysqli_stmt_fetch($stmt)){
                        $id = $id + 1;
                        echo $id;
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);

        // then add the newspaper info
        $sql = "INSERT INTO Paper(pno, pname, pprice, frequency, pwidth, pheight, ppublisher) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssssss", $id, $name, $price, $frequency, $width, $height, $publisher);

            if(mysqli_stmt_execute($stmt)){
                header("location: main.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../../../images/favicon.png" type="image/x-icon">    
    <title>Add Newspaper</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../styles/style.css">
    <style>
        
        body{ 
            font: 18px sans-serif; 
        }
        .wrapper{ 
            width: 600px; 
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
        }
        input {
            margin-top: 1%;
            margin-bottom: 1%;
            width: 80%;
            display: block;
            height: 30px;
            padding: 2px;
            font-size: 18px;
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
        input[type="submit"]{
            width: 52%;
            display: inline-block;
            padding: 0 0 0 0;
            margin: 15px 10px 15px 0;
        }
        .btn-secondary{
            width: 25%;
            text-align: center;
            display: inline-block;
            padding: 5px 0 0 0;
            vertical-align: middle;
        }
        
    </style>
    

</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Add Newspaper Info</h2>
                    <p>Please fill this form and submit to add Newspaper record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>name</label>
                            <input type="text" name="name" class="<?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>price</label>
                            <input type="number" step="0.1" name="price" class="<?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>frequency</label>
                            <input type="number" name="frequency" class="<?php echo (!empty($frequency_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $frequency; ?>">
                            <span class="invalid-feedback"><?php echo $frequency_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>width</label>
                            <input type="number" step="0.1" name="width" class="<?php echo (!empty($width_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $width; ?>">
                            <span class="invalid-feedback"><?php echo $width_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <label>height</label>
                            <input type="number" step="0.1"name="height" class="<?php echo (!empty($height_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $height; ?>">
                            <span class="invalid-feedback"><?php echo $height_err;?></span>
                        </div>
                        

                        <div class="form-group">
                            <label>publisher</label>
                            <input type="text" name="publisher" class="<?php echo (!empty($publisher_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $publisher; ?>">
                            <span class="invalid-feedback"><?php echo $publisher_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="main.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

