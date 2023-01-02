<?php
include "../../../refresh.php";
?>

<?php
// Check existence of id parameter before processing further
if(isset($_GET["gno"]) && !empty(trim($_GET["gno"]))){
    // Include config file
    require_once "../../login/config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM Guest WHERE gno = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["gno"]);
        
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
            } else{
                header("location: error.php");
                exit();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
} else{
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../../../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../../styles/style.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 30px auto;
            display: block;
        }
        table {
            height: auto;
            line-height: 33px;
            text-align: center;
            padding: 2px;
            border-radius: 1em;
            overflow: hidden;
            margin: 0 auto;
            font-size: 17px;
        }
       
        table tr th, table tr td{
            padding: 5px 10px;
            width: 500px;
        }
        table tr th{
            background-color: #B5D5C5;
            color: #002a00;
            font-size: 18px;
            line-height: 40px;
            width: 150px;
        }
        th, td {
            padding: 1em;
            background: #F5F5DC;
            border-bottom: 1px solid white;
        }
        
        .btn-primary{
            font-size: large;
            border-radius: 15px;
            width: 20%;
            height: auto;
            padding: 10px;
            background-color: #794a9a;
            display: block;
            margin: 0 auto;
            text-shadow: none;
            text-align: center;
        }
        .btn-primary:hover{
            background-color: #ac3d6a;
        }
    </style>
</head>
<body>
    <div>
    <h1>View Guest Info</h1>
    </div>
    <div class="wrapper">
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo $row["gname"]; ?></td>
            </tr>
            
            <tr>
                <th>Email</th>
                <td><?php echo $row["gemail"]; ?></td>
            </tr>

            <tr>
                <th>Address</th>
                <td><?php echo $row["gaddress"]; ?></td>
            </tr>

            <tr>
                <th>Telephone</th>
                <td><?php echo $row["gtelephone"]; ?></td>
            </tr>

            <tr>
                <th>Postcode</th>
                <td><?php echo $row["gpostcode"]; ?></td>
            </tr>
            
        </table>
    </div>
    <div class="wrapper">
    <a href="main.php" class="btn btn-primary">Back</a>
    </div>

</body>
</html>