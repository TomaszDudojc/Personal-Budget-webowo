<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: indeks.php');
		exit();
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
				
				<ul class="navbar-nav mx-auto py-0">
					<li class="nav-item active">
						<a class="nav-link " href="indeks.php"><i class="icon-home-1"></i>Strona główna</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="przychód.php"><i class="icon-money"></i>Dodaj przychód</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="wydatek.phpl"><i class="icon-basket"></i>Dodaj wydatek</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="bilans.php"><i class="icon-chart-bar"></i>Przeglądaj bilans</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-wrench"></i>Ustawienia</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php"><i class="icon-off"></i>Wyloguj</a>
					</li>
				</ul>

			</div>
				
		</nav>
		
	</div>
		
	<main>
	
		<div class="container mt-3 mb-5">
		
			<div class="row">
			
				<div class="col-7  text-center rounded mx-auto mb-5" style="background-color: #D3DDE9; border: 1px solid  #c2cce8;">
					<?php
					echo "<h3>Witaj ".$_SESSION['name_of_logged_user']."!</h3>";
					echo "<h3>Wybierz opcję z powyższego menu</h3>";					
					?>			
				</div>
				<?php												
					if(isset($_SESSION['e_registred_user']))echo '<div class="error rounded text-center m-auto p-2 w-100" >'.$_SESSION['e_registred_user'].'</div>';	
					unset($_SESSION['e_registred_user']);	
					if(isset($_SESSION['info_logged_user']))echo '<div class="information rounded text-center mx-auto p-2 w-100" >'.$_SESSION['info_logged_user'].'</div>';	
					unset($_SESSION['info_logged_user']);	
				?>			
				<div class="w-100"></div>
				
				<div class="col-9  mx-auto mt-5">
					<div class="row">
						<div class="col-lg-5 col-9 mt-3 mx-auto">				
							<img class="img-thumbnail" src="img/plan.jpg" alt="plan">
						</div>
						<div class="col-lg-5 col-9 mt-3 mx-auto">	
							<img class="img-thumbnail" src="img/plan2.jpg" alt="plan2">		
						</div>
					</div>
				</div>			
				
			</div>
		
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