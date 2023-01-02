<?php
include "../../../refresh.php";
?>


<?php
// Include config file
require_once "../../login/config.php";
 
// Define variables and initialize with empty values
$name  = $publisher = "";
$price = $frequency = $width = $height = 0;
$name_err = $price_err = $frequency_err = $width_err = $height_err = $publisher_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["pno"]) && !empty($_POST["pno"])){
    // Get hidden input value
    $pno = $_POST["pno"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
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
    
    if(empty($name_err) && empty($price_err) && empty($frequency_err)){
        $sql = "UPDATE Paper SET pname=?, pprice=?, frequency=?, pwidth=?, pheight=?, ppublisher=? WHERE pno=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $price, $frequency, $width, $height, $publisher, $pno);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("refresh:1; url = main.php");
                exit();
            } else{
                // print the error message
                echo mysqli_stmt_error($stmt);
                echo "<br>";
                //print the parameter
                echo $name;
                echo "<br>";
                echo $price;
                echo "<br>";
                echo $frequency;
                echo "<br>";
                echo $width;
                echo "<br>";
                echo $height;
                echo "<br>";
                echo $publisher;
                echo "<br>";
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["pno"]) && !empty(trim($_GET["pno"]))){
        // Get URL parameter
        $pno =  trim($_GET["pno"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM Paper WHERE pno = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $pno);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["pname"];
                    $price = $row["pprice"];
                    $frequency = $row["frequency"];
                    $width = $row["pwidth"];
                    $height = $row["pheight"];
                    $publisher = $row["ppublisher"];
                } 
                else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
    }  else{
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
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../styles/style.css">
    <style>
        .btn-primary{
            font-size: large;
            border-radius: 15px;
            width: 50%;
            height: auto;
            padding: 10px;
            background-color: #794a9a;
            margin: 0 auto;
            text-shadow: none;
            text-align: center;
        }
        .btn-primary:hover{
            background-color: #ac3d6a;
        }
        .btn-secondary{
            font-size: large;
            border-radius: 15px;
            width: 30%;
            height: auto;
            padding: 10px;
            background-color: gray;
            margin: 0 auto;
            text-shadow: none;
            text-align: center;
        }
        .wrapper{
            width: 50%;
            margin: 30px auto 0;
        }
        
        table {
            width: 100%;
            height: auto;
            line-height: 33px;
            text-align: center;
            padding: 2px;
            border-radius: 10px;
            overflow: hidden;
            margin: 0 auto;
            font-size: 17px;
        }

        table tr th{
        /* background-color: #553939; */
        background-color: #6B4F4F;
        color: #EFEFEF;
        font-size: 20px;
        line-height: 40px;
        font-weight: 20px;
        }
        table tr th, table tr td{
        padding: 5px 10px;
        }

        th, td {
        padding: 1em;
        background: #FAF8F1;
        border-bottom: 1px solid white;
        }
        h1{
            display: block;
            margin: 30px auto;
        }
        div{
            margin: 30px auto;
        }
        p{
            font-family: "Bell MT";
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Update Record</h1>
        <p>Please edit the input values and submit to update the Newspaper record.</p>
    </div>
    <div class="wrapper">        
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <table>
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" name="name" class="<?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err;?></span>
                    </td>
                </tr>
               
                <tr>
                    <th>price</th>
                    <td>
                        <input type="number" step="0.1" name="price" class="<?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                        <span class="invalid-feedback"><?php echo $price_err;?></span>
                    </td>
                </tr>

                <tr>
                    <th>frequency</th>
                    <td>
                        <input type="number" name="frequency" class="<?php echo (!empty($frequency_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $frequency; ?>">
                        <span class="invalid-feedback"><?php echo $frequency_err;?></span>
                    </td>
                </tr>

                <tr>
                    <th>width</th>
                    <td>
                        <input type="number" name="width" class="<?php echo (!empty($width_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $width; ?>">
                        <span class="invalid-feedback"><?php echo $width_err;?></span>
                    </td>
                </tr>

                <tr>
                    <th>height</th>
                    <td>
                        <input type="number" name="height" class="<?php echo (!empty($height_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $height; ?>">
                        <span class="invalid-feedback"><?php echo $height_err;?></span>
                    </td>
                </tr>

                <tr>
                    <th>publisher</th>
                    <td>
                        <input type="text" name="publisher" class="<?php echo (!empty($publisher_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $publisher; ?>">
                        <span class="invalid-feedback"><?php echo $publisher_err;?></span>
                    </td>
                </tr>

            </table>    

            <input type="hidden" name="pno" value="<?php echo $_GET["pno"]; ?>"/>
            <div>
            <input type="submit" class="btn btn-primary" value="Submit">
            <a href="main.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    
    </div>
</body>
</html>