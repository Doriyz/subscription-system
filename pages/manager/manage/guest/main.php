<?php
include "../../../refresh.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="maysion">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../../../images/favicon.png" type="image/x-icon">
    <title>Newspaper Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <style>
        .btn-primary{
            font-size: large;
            border-radius: 15px;
            width: 50%;
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

        .wrapper{
            width: 80%;
            margin: 30px auto 0;
        }
        .wrapper2{
            width: 80%;
            padding: 50px 0;
            margin: 0 auto;
        }
        table {
            width: auto;
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
                margin: 0 auto;
            }
            .icon{
                width: 25px;
                height: 25px;
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
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div>
        <!-- add a icon to jump to homepage -->
        <a href="javascript:history.back()" title="return back"><img src="../../../../images/return.png" class="icon"></img></a>
        <a href=../../welcome.php title="jump to home page"><img src="../../../../images/homeicon.png" class="icon"></img></a>
    </div>

    <div class="mt-5 mb-3 clearfix">
        <h1>Guest Information</h1>
    </div>
    
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div>
                    <?php
                    // Include config file
                    require_once "../../login/config.php";
                    // Attempt select query execution
                    $sql = "SELECT * FROM Guest";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table-bordered">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Address</th>";
                                        echo "<th>Telephone</th>";
                                        echo "<th>Postcode</th>";
                                        echo "<th>Operation</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['gno'] . "</td>";
                                        echo "<td>" . $row['gname'] . "</td>";
                                        echo "<td>" . $row['gemail'] . "</td>";
                                        echo "<td>" . $row['gaddress'] . "</td>";
                                        echo "<td>" . $row['gtelephone'] . "</td>";
                                        echo "<td>" . $row['gpostcode'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?gno='. $row['gno'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?gno='. $row['gno'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?gno='. $row['gno'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                    </div>
                </div>
            </div>        
        </div>
    </div>

    <div class="wrapper2">
    <a href="create.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Guest</a>
    </div>

</body>
</html>