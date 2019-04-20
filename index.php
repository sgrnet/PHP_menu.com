<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Главная</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<link rel="stylesheet" href='../css/style.css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>	
		<script type="text/javascript" src="../js/custom.js"></script>
	</head>
	<body>
	<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                    <a href="create.php" class="btn btn-success pull-left">Добавить блюдо</a>
                        <h2 class="pull-right">Меню столовой "Огонёк"</h2>
                    </div>
                    <?php
                    // Include config file
                    require_once "connection.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM menu";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>Наименование</th>";
                            echo "<th>Состав</th>";
                            echo "<th>Порция</th>";
                            echo "<th>Цена</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = $result->fetch_array()){
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['composition'] . "</td>";
                                echo "<td>" . $row['portion'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td>";
                                echo "<a href='details.php?id=". $row['id'] ."' title='Просмотреть запись' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                echo "<a href='edit.php?id=". $row['id'] ."' title='Редактировать запись' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                echo "<a href='delete.php?id=". $row['id'] ."' title='Удалить запись' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            $result->free();
                        } else{
                            echo "<p class='lead'><em>Записи не найдены.</em></p>";
                        }
                    } else{
                        echo "ОШИБКА: Невозможно выполнить $sql. " . $mysqli->error;
                    }
                    
                    // Close connection
                    $mysqli->close();
                    ?>
                </div>
            </div>        
        </div>
    </div>

	</body>
</html>