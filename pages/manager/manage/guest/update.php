<?php
include "../../../refresh.php";
?>


<?php
// Include config file
require_once "../../login/config.php";
 
// Define variables and initialize with empty values
$name  = $email = $address = $telephone = $postcode = "";
$name_err = $email_err = $address_err = $telephone_err = $postcode_err = "";

// Processing form data when form is submitted
if(isset($_POST["gno"]) && !empty($_POST["gno"])){
    // Get hidden input value
    $gno = $_POST["gno"];
    
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    }
    else{
        $name = $input_name;
    }
    
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter the email amount.";     
    } 
    else{
        $email = $input_email;
    }

    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter the address amount.";     
    } 
    else{
        $address = $input_address;
    }

    $input_telephone = trim($_POST["telephone"]);
    if(empty($input_telephone)){
        $telephone_err = "Please enter the telephone amount.";     
    } 
    else{
        $telephone = $input_telephone;
    }

    $input_postcode = trim($_POST["postcode"]);
    if(!empty($input_postcode)){
        $postcode = $input_postcode;
    }


    
    if(empty($name_err) && empty($price_err) && empty($frequency_err)){
        $sql = "UPDATE Guest SET gname=?, gemail=?, gaddress=?, gtelephone=?, gpostcode=? WHERE gno=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $address, $telephone, $postcode, $gno);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("refresh:1; url = main.php");
                exit();
            } else{
                // print the error message
                echo mysqli_stmt_error($stmt);
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["gno"]) && !empty(trim($_GET["gno"]))){
        // Get URL parameter
        $gno =  trim($_GET["gno"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM Guest WHERE gno = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $gno);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["gname"];
                    $email = $row["gemail"];
                    $address = $row["gaddress"];
                    $telephone = $row["gtelephone"];
                    $postcode = $row["gpostcode"];
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
        <p>Please edit the input values and submit to update the Guest record.</p>
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
                    <th>Email</th>
                    <td>
                        <input type="text" name="email" class="<?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err;?></span>
                    </td>
                </tr>

                <tr>
                    <th>Address</th>
                    <td>
                        <input type="text" name="address" class="<?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                        <span class="invalid-feedback"><?php echo $address_err;?></span>
                    </td>
                </tr>

                <tr>
                    <th>Telephone</th>
                    <td>
                        <input type="text" name="telephone" class="<?php echo (!empty($telephone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telephone; ?>">
                        <span class="invalid-feedback"><?php echo $telephone_err;?></span>
                    </td>
                </tr>

                <tr>
                    <th>Postcode</th>
                    <td>
                        <input type="text" name="postcode" class="<?php echo (!empty($postcode_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $postcode; ?>">
                        <span class="invalid-feedback"><?php echo $postcode_err;?></span>
                </tr>
            </table>    


            <input type="hidden" name="gno" value="<?php echo $_GET["gno"]; ?>"/>
            <div>
            <input type="submit" class="btn btn-primary" value="Submit">
            <a href="main.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    
    </div>
</body>
</html>