<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "../login/config.php";
?>

<?php
    // get the newspaper information from the database
$tableName = "Paper";
$columns = ["pno", "pname", "pprice", "frequency", "pwidth", "pheight", "ppublisher"];
$PaperInfor = fetchData($tableName, $columns);
function fetchData($tableName, $columns){
    global $link;
    if(empty($link)){
        $msg = "Database connection failed";
        return $msg;
    }
    $columnName = implode(", ", $columns);
    $sql = "SELECT ".$columnName." FROM ".$tableName." ORDER BY pno";
    $result = mysqli_query($link, $sql);
    if($result == true) {
        if($result->num_rows > 0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $msg = $row;
        }
        else{
            $msg = "No Newspaper";
        }
    }
    else{
        $msg = mysqli_error($link);
    }
    return $msg;
}
?>


<?php
    // get the added subscription from the page
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(gettype($PaperInfor) != "string"){
            foreach($PaperInfor as $row){
                $pno = $row['pno'];
                $addNumber = $_POST[$pno];
                if($addNumber != "0"){
                    // add an order to the database









use a array to record the all ono, 
then add then with an same DateTime






                }
            }
        }
        else{
            echo '<span class="invalid-feedback"><?php echo $email_err; ?></span>';
        }
    }      
?>



 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="3"> -->
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon">
    <link href="../../styles/style.css" rel="stylesheet">
    <!-- <link href="../../styles/log_in.css" rel="stylesheet"> -->
    <!-- <meta http-equiv="refresh" content="30"> -->
    <style>
        div {
            width: 400px;
        }
        body{ font: 14px sans-serif;
            text-align: center;}
        .wrapper{ 
            width: 360px; 
            padding: 20px; 
            margin: 0 auto;}
    </style>
    
</head>


<body>
    <h1 class="my-5"><b>The Newspaper Information</b></h1>

    <!-- build the information table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>no</th>
                    <th>name</th>
                    <th>price</th>
                    <th>frequency</th>
                    <th>width</th>
                    <th>height</th>
                    <th>publisher</th>
                    <th><b>Add</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($PaperInfor == "No Newspaper"){
                    echo "<tr><td colspan='7'>No Newspaper</td></tr>";
                }
                elseif(gettype($PaperInfor) == "string"){
                    echo "<tr><td colspan='7'>".$PaperInfor."</td></tr>";
                }
                else{
                    foreach($PaperInfor as $row){
                        echo "<tr>";
                        echo "<td>".$row['pno']."</td>";
                        echo "<td>".$row['pname']."</td>";
                        echo "<td>".$row['pprice']."</td>";
                        echo "<td>".$row['frequency']."</td>";
                        echo "<td>".$row['pwidth']."</td>";
                        echo "<td>".$row['pheight']."</td>";
                        echo "<td>".$row['ppublisher']."</td>";
                        echo '<td><input type="number" name="'.$row['pno'].'" value="0" min="0"></td>';
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>

        </table>
    <input type="submit" class="btn btn-primary" value="Submit">
</body>
</html>