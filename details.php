<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "connection.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM menu WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Retrieve individual field value
				$name = $row["Name"];
				$model = $row["composition"];
				$lastRepair = $row["portion"];
				$nextRepair = $row["price"];			
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Что-то пошло не так!. Попробуйте после чашечки кофе!.";
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $mysqli->close();
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Просмотреть запись</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href='../css/style.css'>
</head>
<body>
    <div class="wrapper_c">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Просмотр записи</h1>
                        </div>
                    <div class="form-group">
                        <label>Наименование</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Состав</label>
                        <p class="form-control-static"><?php echo $row["composition"]; ?></p>
                        <hr>
                    </div>
					<div class="form-group">
                        <label>Размер порции</label>
                        <p class="form-control-static"><?php echo $row["portion"]; ?></p>
                        <hr>
                    </div>
					<div class="form-group">
                        <label>Цена</label>
                        <p class="form-control-static"><?php echo $row["price"]; ?></p>
                    </div>
                    <hr>
                    <p><a href="index.php" class="btn btn-primary">На главную</a></p>
                    <hr>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>