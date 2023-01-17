<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: indeks.php');
		exit();
	}
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
			
	try 
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if ($polaczenie->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			//pobierz kategorie wydatków użytkownika
			$rezultat = $polaczenie->query("SELECT * FROM expenses_category_assigned_to_users WHERE user_id = '$_SESSION[id_of_logged_user]' ");
			//$numbers_of_icome_category = $rezultat->num_rows;			
			$expense_categories= $rezultat->fetch_all(MYSQLI_ASSOC);
			
			$rezultat->free_result();	

			//pobierz metody płatności użytkownika
			$rezultat = $polaczenie->query("SELECT * FROM payment_methods_assigned_to_users WHERE user_id = '$_SESSION[id_of_logged_user]' ");				
			$payment_methods= $rezultat->fetch_all(MYSQLI_ASSOC);
			
			$rezultat->free_result();	
			
			}
	}
	
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		echo '<br />Informacja developerska: '.$e;
			
	}
	
	if (isset($_POST['amount']))
	{
		$amount_of_expense = $_POST['amount'];
		$date_of_expense = $_POST['date'];
		$id_of_expense_category = $_POST['category'];
		$id_of_payment_method = $_POST['method'];
		$comment_of_expense = $_POST['comment'];		
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
			
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$polaczenie->query("INSERT INTO expenses VALUES(NULL, '$_SESSION[id_of_logged_user]', '$id_of_expense_category', '$id_of_payment_method', '$amount_of_expense', '$date_of_expense', '$comment_of_expense' )" );			
								
				$_SESSION['info_expense_added']="Wydatek został dodany";
				header('Location: menu.php');
				exit();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;			
		}
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
				<a class="navbar-brand  text-center" href="indeks.php"><span><i class="icon-calc"></i></span>Personal Budget</a>
			</div>
					
			<blockquote class="blockquote mx-auto">					
				<p class="mb-1"> "Jeśli kupujesz rzeczy, których nie potrzebujesz, wkrótce będziesz musiał sprzedawać rzeczy, które są ci niezbędne"</p>
				<footer class="blockquote-footer mt-0">Warren Buffett</footer>						
			</blockquote>
					
		</div>

	</nav>	
		
	<div class="navcontainer rounded">
	
		<nav class="navbar navbar-light py-0 navbar-expand-lg">		
			
			<button class="navbar-toggler colapsed" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
					<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
			
				<ul class="navbar-nav d-inlineblock mx-auto py-0">
					<li class="nav-item">
						<a class="nav-link " href="menu.php"><i class="icon-home-1"></i>Strona główna</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="przychód.php"><i class="icon-money"></i>Dodaj przychód</a>
					</li>
					<li class="nav-item  active">
						<a class="nav-link" href="wydatek.php"><i class="icon-basket"></i>Dodaj wydatek</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="bilans.php"><i class="icon-chart-bar"></i>Przeglądaj bilans</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-wrench"></i>Ustawienia</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-off"></i>Wyloguj</a>
					</li>
				</ul>

			</div>
			
		</nav>
	
	</div>
	
	<main>
	
		<div class="inputContainer mt-3">			
			
			<header>
				<h2 class="font-weight-bold rounded">Dopisz wydatek</h2>
			</header>
		
			<form method="post">	
				
				<div class="input-group">
					<div class="input-group-prepend ">
						<span class="input-group-text  rounded-left icon"><i class="icon-gauge"></i></span>
					</div>			
					<input type="number" class="form-control  rounded-right " step="0.01" name="amount" placeholder="Kwota" required>	
				</div>
					
				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left icon"><i class="icon-calendar"></i></span>
					</div>
					<input type="date" class="form-control  rounded-right" name="date" required>
				</div>				
				
				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left icon"><i class="icon-cc-visa"></i></span>
					</div>
					<select class="choice rounded-right" name="method" required>
						<option value selected disabled hidden>Wybierz sposób płatności</option>
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
						<option value selected disabled hidden>Wybierz kategorię</option>
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
					<input type="text" class="form-control  rounded-right" name="comment" placeholder="Komentarz">	
				</div>				
				
				<a href="menu.php"><button  type="button" class="btn btn-danger btn-lg float-left mt-3">"Anuluj"</button></a>
				<button  type="submit" class="btn btn-success btn-lg  float-right mt-3">"Dodaj"</button>
									
			</form>		
			
		</div>
		
	</main>
		
	<footer>
	
		<div class="info rounded">
			Wszelkie prawa zastrzeżone &copy; 2022 Dziękuję za wizytę!
		</div>
		
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	
</body>

</html>