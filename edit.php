<?php
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$name = $composition = $portion = $price = "";
$name_err = $composition_err = $portion_err = $price_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate Name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Введите наименование.";     
    } else{
        $name = $input_name;
    }
	
    // Validate Model
    $input_composition = trim($_POST["composition"]);
    if(empty($input_composition)){
        $composition_err = "Введите состав.";     
    } else{
        $composition = $input_composition;
    }
	
	// Validate LastRepair
    $input_portion = trim($_POST["portion"]);
    if(empty($input_portion)){
        $portion_err = "Введите размер порции.";     
    } else{
        $portion = $input_portion;
    }
	
	// Validate NextRepair
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Введите цену.";     
    } else{
        $price = $input_price;
    }
    
    // Check input errors before inserting in database
	if(empty($name_err) && empty($composition_err) && empty($portion_err) && empty($price_err))
	{
        // Prepare an update statement
        $sql = "UPDATE menu SET name=?, composition=?, portion=?, price=? WHERE id=?";
 
		if($stmt = $mysqli->prepare($sql))
		{
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssi",  $param_name, $param_composition, $param_portion, $param_price, $param_id);
            
            // Set parameters
          	$param_name = $name;
			$param_composition = $composition;
			$param_portion = $portion;
			$param_price = $price;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
			if($stmt->execute())
			{
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
			} else
			{
                echo "Что-то пошло не так!. Попробуйте после чашечки кофе!.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM menu WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                  	$name = $row["name"];
					$composition = $row["composition"];
					$portion = $row["portion"];
					$price = $row["price"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Редактировать запись</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href='../css/style.css'>
	</head>
	<body>
		<div class="wrapper_c">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
							<h2>Обновить запись</h2>
						</div>
						<p>Измените значения в полях и нажмите кнопку Отправить.</p>
						<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
							<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
								<label>Наименование:</label>
								<input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
								<span class="help-block"><?php echo $name_err;?></span>
							</div>
							<div class="form-group <?php echo (!empty($composition_err)) ? 'has-error' : ''; ?>">
								<label>Состав:</label>
								<input type="text" name="composition" class="form-control" value="<?php echo $composition; ?>">
								<span class="help-block"><?php echo $composition_err;?></span>
							</div>
							<div class="form-group <?php echo (!empty($portion_err)) ? 'has-error' : ''; ?>">
								<label>Порция:</label>
								<input type="text" name="portion" class="form-control" value="<?php echo $portion; ?>">
								<span class="help-block"><?php echo $portion_err;?></span>
							</div>
							<div class="form-group <?php echo (!empty($nextRepair_err)) ? 'has-error' : ''; ?>">
								<label>Цена:</label>
								<input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
								<span class="help-block"><?php echo $price_err;?></span>
							</div>
							<input type="hidden" name="id" value="<?php echo $id; ?>"/>
							<hr>
							<input type="submit" class="btn btn-primary" value="Сохранить">
							<a href="index.php" class="btn btn-default pull-right">Отмена</a>
							<hr>
						</form>
					</div>
				</div>        
			</div>
		</div>
		
	</body>
</html>