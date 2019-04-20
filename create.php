<?php
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$name = $composition = $portion = $price = "";
$name_err = $composition_err = $portion_err = $price_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
      
    // Validate Name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Введите название блюда.";     
    } else{
        $name = $input_name;
    }
	
    // Validate Сomposition
    $input_composition = trim($_POST["composition"]);
    if(empty($input_composition)){
        $composition_err = "Введите состав блюда!";     
    } else{
        $composition = $input_composition;
    }
	
	// Validate Portion
    $input_portion = trim($_POST["portion"]);
    if(empty($input_portion)){
        $portion_err = "Введите размер порции!";     
    } else{
        $portion = $input_portion;
    }
	
	// Validate Price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Введите цену.";     
    } else{
        $price = $input_price;
    }

    // Check input errors before inserting in database
    if( empty($name_err) && empty($composition_err) && empty($portion_err) && empty($price_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO menu ( name, composition, portion, price) VALUES (?, ?, ?, ?)";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_name, $param_composition, $param_portion, $param_price);
            
            // Set parameters
			$param_name = $name;
			$param_composition = $composition;
			$param_portion = $portion;
			$param_price = $price;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Что-то пошло не так!. Попробуйте после чашечки кофе!.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Создать новую запись</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<link rel="stylesheet" href='../css/style.css'>
	</head>
	<body>
		<div class="wrapper_c">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Добавить блюдо</h2>
                    </div>
                    <p>Заполните форму.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Наименование:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" placeholder='Новое блюдо'>
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($composition_err)) ? 'has-error' : ''; ?>" >
                            <label>Состав:</label>
                            <input type="text" name="composition" class="form-control" value="<?php echo $composition; ?>" placeholder= 'Ингридиенты блюда'>
                            <span class="help-block"><?php echo $composition_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($portion_err)) ? 'has-error' : ''; ?>">
                            <label>Порция:</label>
                            <input type="text" name="portion" class="form-control" value="<?php echo $portion; ?>" placeholder= '150'>
                            <span class="help-block"><?php echo $portion_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Цена:</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>" placeholder= '2.35'>
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>
                        <hr>
                        <input type="submit" class="btn btn-primary pull-left" value="Сохранить">
                        <a href="index.php" class="btn btn-default pull-right">Отмена</a>
                    </form>
                </div>
            </div>        
                    <div class="page-footer">
                       <hr>
                    </div>
        </div>
    </div>
	</body>
</html>