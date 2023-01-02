<?php
include "../../refresh.php";
?>

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login/login.php");
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
    global $link;
    global $Orders;
    // get the added subscription from the page
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $gno = $_SESSION['id'];
        $onum = 0;
        $Orders = array(); // collect the orders in this bill
        
        // before adding orders, we need to get the correct ono
        $sql = "SELECT count(ono) AS ONUM FROM Orders";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $onum);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }

        // before adding bills, we need to get the datetime
        $now = "";
        $sql = "SELECT NOW() AS NOW;";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $now);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }
        // now onum is the number of total orders
        // we need to add 1 to get the ono of a new order

        // add a flag to judge if add orders
        $change = 0;

        if(gettype($PaperInfor) != "string"){
            // if the paper information is not empty
            foreach($PaperInfor as $row){
                $pno = $row['pno'];
                $addNumber = $_POST["number".$pno];
                $addPeriod = $_POST["period".$pno];
                if($addNumber != "0"){
                    $change = 1;
                    // add an order to the database
                    $sql = "INSERT INTO Orders (ono, gno, pno, onumber, period) VALUES (?, ?, ?, ?, ?)";
                    if($stmt = mysqli_prepare($link, $sql)){
                        // bind variables
                        mysqli_stmt_bind_param($stmt, "sssii", $param_ono, $param_gno, $param_pno, $param_onumber, $param_period);
                        // set parameters
                        $param_ono = $onum + 1;
                        $param_gno = $gno;
                        $param_pno = $row['pno'];
                        $param_onumber = $addNumber;
                        $param_period = $addPeriod;
                        if(mysqli_stmt_execute($stmt)){
                            array_push($Orders, $param_ono);
                            $onum = $onum + 1;
                            echo "Order added successfully.";
                        }
                        else{
                            echo "Something went wrong when try to add order.";
                        }
                        mysqli_stmt_close($stmt);
                    }

                    $sql = "INSERT INTO Bill (btime, ono) VALUES (?, ?)";
                    if($stmt = mysqli_prepare($link, $sql)){
                        mysqli_stmt_bind_param($stmt, "ss", $para_datetime, $param_ono);
                        $para_datetime = $now;
                        // echo $para_datetime;
                        if(mysqli_stmt_execute($stmt)){
                            echo "<br>Bill added succcessfully.<br>";
                        }
                        else{
                            echo "<br>Something went wrong when try to add bill<br>";
                        }
                    }
                }
            }
            if($change == 1){
                // jump to the pay page
                $_SESSION['Orders'] = $Orders;
                header("location: ../pay/pay.php");
            }
            else{
                echo "<span>do not add any subscription</span";
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
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link rel="shortcut icon" href="../../../images/favicon.png" type="image/x-icon">
    <link href="../../../styles/style.css" rel="stylesheet">
    <style>
        div {
            width: 400px;
        }
        body{
            padding-bottom: 50px;
        }
        .wrapper{ 
            width: 360px; 
            padding: 20px; 
            margin: 0 auto;
        }
        .wrapper2{
            text-align: left;
            display: inline;
        }

        table {
            width: auto;
            height: auto;
            line-height: 33px;
            text-align: center;
            padding: 2px;
            border-radius: 1em;
            overflow: hidden;
            margin: 0 auto;
            font-size: 17px;
        }

        table tr th{
            background-color: #B5D5C5;
            color: #002a00;
            font-size: 20px;
            line-height: 40px;
        }
        table tr th, table tr td{
            padding: 5px 10px;
        }

        th, td {
            padding: 1em;
            background: #F5F5DC;
            border-bottom: 1px solid white;

        }

        input[type="number"]{
            text-align: center;
            font-size: 18px;
        }
        input[type="submit"]{
            margin-top: 2%;
            margin-left: 45%;
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

        span {
            color: red;
            font-size: 20px;
        }
</style>
    
</head>


<body>
    <div>
        <!-- add a icon to jump to homepage -->
        <a href="javascript:history.back()" title="return back"><img src="/subscription-system/images/return.png" class="icon"></img></a>
        <a href="../welcome.php" title="jump to home page"><img src="/subscription-system/images/homeicon.png" class="icon"></img></a>
    </div>
    <div class="wrapper2">
    <h1><b>view and purchase</b></h1>

    <!-- build the information table -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                    <th><b>Number</b></th>
                    <th><b>Period(months)</b></th>
                    <!-- <th><b>Total Price</b></th> -->
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
                        echo '<td><input type="number" name="'."number".$row['pno'].'" value="0" min="0" style="width: 25%; padding:0,0; margin:0,0"></td>';
                        echo '<td><input type="number" name="'."period".$row['pno'].'" value="1" min="0" style="width: 25%;padding:0,0; margin:0,0"></td>';
                        // echo '<td>' . $totalPrice . '</td>';
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>

        </table>
    <input type="submit" class="btn btn-primary" value="Submit" >
    </div>

</form>
</body>
</html>