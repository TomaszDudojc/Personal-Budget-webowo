<?php

	session_start();			
		
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		$_SESSION['e_registred_user'] = "Aby zarejestrować kolejne konto musisz wylogować się z aktualnego!";
		header('Location: menu.php');
		exit();
	}
	
	else
	{
		if (isset($_POST['email']))
		{
			//Udana walidacja? Załóżmy, że tak!
			$wszystko_OK=true;
			
			//Sprawdź poprawność nickname'a
			$nick = $_POST['nick'];
			
			//Sprawdzenie długości nicka
			if ((strlen($nick)<3) || (strlen($nick)>20))
			{
				$wszystko_OK=false;
				$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
			}
			
			if (ctype_alnum($nick)==false)
			{
				$wszystko_OK=false;
				$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (od 3 do 20 znaków, bez polskich ogonków)";
			}
			
			// Sprawdź poprawność adresu email
			$email = $_POST['email'];
			$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
			
			if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
			{
				$wszystko_OK=false;
				$_SESSION['e_email']="Podaj poprawny adres e-mail!";
			}
			
			//Sprawdź poprawność hasła
			$haslo1 = $_POST['haslo1'];
			$haslo2 = $_POST['haslo2'];
			
			if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
			{
				$wszystko_OK=false;
				$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
			}
			
			if ($haslo1!=$haslo2)
			{
				$wszystko_OK=false;
				$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
			}	

			$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
			
			
			//Zapamiętaj wprowadzone dane
			$_SESSION['fr_nick'] = $nick;
			$_SESSION['fr_email'] = $email;
			$_SESSION['fr_haslo1'] = $haslo1;
			$_SESSION['fr_haslo2'] = $haslo2;
				
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
					//Czy email już istnieje?
					$rezultat = $polaczenie->query("SELECT id FROM users WHERE email='$email'");
					
					if (!$rezultat) throw new Exception($polaczenie->error);
					
					$ile_takich_maili = $rezultat->num_rows;
					if($ile_takich_maili>0)
					{
						$wszystko_OK=false;
						$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
					}		

					//Czy nick jest już zarezerwowany?
					$rezultat = $polaczenie->query("SELECT id FROM users WHERE username='$nick'");
					
					if (!$rezultat) throw new Exception($polaczenie->error);
					
					$ile_takich_nickow = $rezultat->num_rows;
					if($ile_takich_nickow>0)
					{
						$wszystko_OK=false;
						$_SESSION['e_nick']="Istnieje już osoba o takim nicku! Wybierz inny.";
					}
					
					if ($wszystko_OK==true)
					{
						//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
						
						if ($polaczenie->query("INSERT INTO users VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
						{		
							
							$polaczenie->query("INSERT INTO expenses_category_assigned_to_users (name) SELECT name FROM expenses_category_default");
							$polaczenie->query("INSERT INTO incomes_category_assigned_to_users (name) SELECT name FROM incomes_category_default");
							$polaczenie->query("INSERT INTO payment_methods_assigned_to_users (name) SELECT name FROM payment_methods_default");
													
							$rezultat = $polaczenie->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");
							$wiersz = $rezultat->fetch_assoc();
							$_SESSION['registered_user_id']=$wiersz['id'];
							$rezultat->free_result();
							
							$polaczenie->query("UPDATE expenses_category_assigned_to_users SET user_id=$_SESSION[registered_user_id] WHERE user_id=''");
							$polaczenie->query("UPDATE incomes_category_assigned_to_users SET user_id=$_SESSION[registered_user_id] WHERE user_id=''");					
							$polaczenie->query("UPDATE payment_methods_assigned_to_users SET user_id=$_SESSION[registered_user_id] WHERE user_id=''");					
													
							$_SESSION['udanarejestracja']=true;
							header('Location: logowanie.php');
						}
						else
						{
							throw new Exception($polaczenie->error);
						}
						
					}
					
					$polaczenie->close();
				}
				
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
				echo '<br />Informacja developerska: '.$e;
			
			}
			
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
		
	<main>
	
		<div class="inputContainer mt-3">

			<header>
				<h2 class="register font-weight-bold rounded">Rejestracja</h2>
			</header>
		
			<form  method="post">
				
				<div class="input-group">	
					<div class="input-group-prepend ">
						<span class="input-group-text  rounded-left iconregister"><i class="icon-user-3"></i></span>
					</div>
					<input type="text" class="form-control  rounded-right register" name="nick" value="<?php
					if (isset($_SESSION['fr_nick']))
					{
						echo $_SESSION['fr_nick'];
						unset($_SESSION['fr_nick']);
					}
					?>"  placeholder="Imię" required>						
				</div>
				<?php
					if (isset($_SESSION['e_nick']))
					{
						echo '<div class="error rounded text-center" >'.$_SESSION['e_nick'].'</div>';
						unset($_SESSION['e_nick']);
					}
					?>
				
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text  rounded-left iconregister"><i class="icon-mail-3"></i></span>
					</div>
					<input type="email" class="form-control  rounded-right register" name="email"  value="<?php
						if (isset($_SESSION['fr_email']))
						{
							echo $_SESSION['fr_email'];
							unset($_SESSION['fr_email']);
						}
					?>" placeholder="Email" required>					
				</div>
				<?php
						if (isset($_SESSION['e_email']))
						{
							echo '<div class="error rounded text-center">'.$_SESSION['e_email'].'</div>';
							unset($_SESSION['e_email']);
						}
					?>
					
				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left iconregister"><i class="icon-lock"></i></span>
					</div>
					<input type="password" class="form-control  rounded-right register" name="haslo1" value="<?php
						if (isset($_SESSION['fr_haslo1']))
						{
							echo $_SESSION['fr_haslo1'];
							unset($_SESSION['fr_haslo1']);
						}
					?>" placeholder="Hasło" required>					
				</div>
				<?php
						if (isset($_SESSION['e_haslo']))
						{
							echo '<div class="error rounded text-center">'.$_SESSION['e_haslo'].'</div>';
							unset($_SESSION['e_haslo']);
						}
					?>	
					
				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left iconregister"><i class="icon-lock"></i></span>
					</div>
					<input type="password" class="form-control  rounded-right register" name="haslo2"  value="<?php
						if (isset($_SESSION['fr_haslo2']))
						{
							echo $_SESSION['fr_haslo2'];
							unset($_SESSION['fr_haslo2']);
						}
					?>" placeholder="Powtórz hasło" required>					
				</div>
					
				<button  type="submit" class="btn register">Zarejestruj się</button>
					
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