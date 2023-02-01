<?php

	session_start();
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
	}	
	
	//require_once "connect.php";
	//mysqli_report(MYSQLI_REPORT_STRICT);
	require_once 'database.php';
			
	//try 
	//{
		//$connection = new mysqli($host, $db_user, $db_password, $db_name);
		//if ($connection->connect_errno!=0)
		//{
			//throw new Exception(mysqli_connect_errno());
		//}
		//else
		//{
			//pobierz kategorie wydatków użytkownika
			//$result = $connection->query("SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$_SESSION[id_of_logged_user]' ");
			$result = $db->query("SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$_SESSION[id_of_logged_user]' ");
					
			//$expense_categories= $result->fetch_all(MYSQLI_ASSOC);
			$expense_categories= $result->fetchAll();
			
			//$result->free_result();	

			//pobierz metody płatności użytkownika
			//$result = $connection->query("SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$_SESSION[id_of_logged_user]' ");				
			$result = $db->query("SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$_SESSION[id_of_logged_user]' ");				
			//$payment_methods= $result->fetch_all(MYSQLI_ASSOC);
			$payment_methods= $result->fetchAll();
			
			//$result->free_result();	
			
			//}
	//}
	
	//catch(Exception $e)
	//{
		//echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		//echo '<br />Informacja developerska: '.$e;
			
	//}
	
	if (isset($_POST['amount']))
	{
		//$amount_of_expense = $_POST['amount'];
		//$date_of_expense = $_POST['date'];
		//$id_of_expense_category = $_POST['category'];
		//$id_of_payment_method = $_POST['method'];
		//$comment_of_expense = $_POST['comment'];
		$amount_of_expense = filter_input(INPUT_POST, 'amount');
		$date_of_expense = filter_input(INPUT_POST, 'date');
		$id_of_expense_category = filter_input(INPUT_POST, 'category');
		$id_of_payment_method = filter_input(INPUT_POST, 'method');
		$comment_of_expense = filter_input(INPUT_POST, 'comment');
		
		//require_once "connect.php";
		//mysqli_report(MYSQLI_REPORT_STRICT);
			
		//try 
		//{
			//$connection = new mysqli($host, $db_user, $db_password, $db_name);
			//if ($connection->connect_errno!=0)
			//{
				//throw new Exception(mysqli_connect_errno());
			//}
			//else
			//{
				$db->query("INSERT INTO expenses VALUES(NULL, '$_SESSION[id_of_logged_user]', '$id_of_expense_category', '$id_of_payment_method', '$amount_of_expense', '$date_of_expense', '$comment_of_expense' )" );			
								
				$_SESSION['info_expense_added']="Expense has been added";
				header('Location: menu.php');
				exit();
			//}
			
		//}
		//catch(Exception $e)
		//{
			//echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;			
		//}
	}
		
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Personal Budget</title>
	
	<meta name="description" content="Aplikacja ułatwiająca zarządzanie własnymi finansami">
	<meta name="keywords" content="budżet osobisty, budżet domowy, zarządzanie swoimi finansami, oszczedzanie">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" type="text/css">
	<link rel="stylesheet" href="css/fontello.css" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Lato&family=swap" rel="stylesheet">
	
</head>

<body>	
		
	<nav class="navbar navbar-default mainNav rounded">
			
		<div class="container">
				
			<div class="navbar-header mx-auto">
				<a class="navbar-brand  text-center" href="index.php"><span><i class="icon-calc"></i></span>Personal Budget</a>
			</div>
					
			<blockquote class="blockquote mx-auto">					
				<p class="mb-1"> "If you buy things you don't need, soon you will have to sell things you need"</p>
				<footer class="blockquote-footer mt-0">Warren Buffett</footer>						
			</blockquote>
					
		</div>

	</nav>	
		
	<div class="navcontainer rounded">
	
		<nav class="navbar navbar-light py-0 navbar-expand-lg">		
			
			<button class="navbar-toggler colapsed" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Navigation switch">
					<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
			
				<ul class="navbar-nav d-inlineblock mx-auto py-0">
					<li class="nav-item">
						<a class="nav-link " href="menu.php"><i class="icon-home-1"></i>Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="income.php"><i class="icon-money"></i>Add income</a>
					</li>
					<li class="nav-item  active">
						<a class="nav-link" style="color: #060B95;" href="expense.php"><i class="icon-basket"></i>Add expense</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="balance.php"><i class="icon-chart-bar"></i>View balance</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-wrench"></i>Settings</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-danger" href="logout.php"><i class="icon-off"></i>Log out</a>
					</li>
				</ul>

			</div>
			
		</nav>
	
	</div>
	
	<main>
	
		<div class="inputContainer mt-3">			
			
			<header>
				<h2 class="font-weight-bold rounded">Nowy wydatek<i class="icon-basket ml-3"></i></h2>
			</header>
		
			<form method="post">	
				
				<div class="input-group">
					<div class="input-group-prepend ">
						<span class="input-group-text  rounded-left icon"><i class="icon-gauge"></i></span>
					</div>			
					<input type="number" class="form-control  rounded-right " step="0.01" min="0.01" name="amount" placeholder="Amount" required>	
				</div>
					
				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left icon"><i class="icon-calendar"></i></span>
					</div>
					<input type="date" class="form-control  rounded-right" name="date" value="<?php echo date('Y-m-d')?>" required>
				</div>				
				
				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left icon"><i class="icon-cc-visa"></i></span>
					</div>
					<select class="choice rounded-right" name="method" required>
						<option value selected disabled hidden>Choose payment method</option>
						<?php						
							foreach ($payment_methods as $payment_method)
							{
								echo"<option value=$payment_method[id]>$payment_method[name]</option>";
							}						
						?>
					</select>
				</div>	

				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left icon"><i class="icon-ok"></i></span>
					</div>
					<select class="choice rounded-right" name="category" required>						
						<option value selected disabled hidden>Select a category</option>
						<?php						
							foreach ($expense_categories as $expense_category)
							{
								echo"<option value=$expense_category[id]>$expense_category[name]</option>";
							}									
						?>						
					</select>
				</div>	

				<div class="input-group">	
					<div class="input-group-prepend ">
						<span class="input-group-text  rounded-left icon"><i class="icon-pencil"></i></span>
					</div>
					<input type="text" class="form-control  rounded-right" name="comment" placeholder="Comment">	
				</div>				
				
				<a href="menu.php"><button  type="button" class="btn btn-danger btn-lg float-left mt-3">Cancel</button></a>
				<button  type="submit" class="btn btn-success btn-lg  float-right mt-3">Add</button>
									
			</form>		
			
		</div>
		
	</main>
		
	<footer>
	
		<div class="info rounded">
			All rights reserved &copy; 2022 Thank you for visit!
		</div>
		
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	
</body>

</html>