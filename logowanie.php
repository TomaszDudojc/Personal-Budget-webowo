<?php

	session_start();		
		
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: menu.php');
		exit();
	}
	
	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
		
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);		
	
	//Usuwanie błędów l
	if ((isset($_SESSION['udanarejestracja'])))unset($_SESSION['blad']);	
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
		
	<main>
	
		<div class="inputContainer mt-3">			
			
			<header>
				<h2 class="font-weight-bold rounded">Logowanie</h2>
			</header>
		
			<form action="zaloguj.php" method="post">			
								
				<div class="input-group">
					<div class="input-group-prepend ">
						<span class="input-group-text  rounded-left icon"><i class="icon-mail-3"></i></span>
					</div>
					<input type="email" class="form-control  rounded-right " name="email" placeholder="Email" required>	
				</div>
					
				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left icon"><i class="icon-lock"></i></span>
					</div>
					<input type="password" class="form-control  rounded-right" name="haslo" placeholder="Hasło" required>
				</div>
				
				<?php			
					if(isset($_SESSION['blad']))echo '<div class="error rounded text-center" >'.$_SESSION['blad'].'</div>';					
				?>
				
				<button  type="submit" class="btn login">"Zaloguj się"</button>
				
			</form>	
			<?php
					if (isset($_SESSION['udanarejestracja']))
					{
						echo '<div class="information rounded text-center">Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto!</div>';
						unset($_SESSION['udanarejestracja']);
					}
				?>
			
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