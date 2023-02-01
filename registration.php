<?php
	
	session_start();			
		
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		$_SESSION['e_registred_user'] = "To register another account, you must log out of the current one!";
		header('Location: menu.php');
		exit();
	}
	
	else
	{
		if (isset($_POST['email']))
		{
			//Udana walidacja? Załóżmy, że tak!
			$everything_OK=true;
			
			//Sprawdź poprawność nickname'a
			//$nick = $_POST['nick'];
			$nick = filter_input(INPUT_POST, 'nick');
			//Sprawdzenie długości nicka
			if ((strlen($nick)<3) || (strlen($nick)>20))
			{
				$everything_OK=false;
				$_SESSION['e_nick']="Nick must be between 3 and 20 characters long!";
			}
			
			if (ctype_alnum($nick)==false)
			{
				$everything_OK=false;
				$_SESSION['e_nick']="Nick can only consist of letters and numbers (from 3 to 20 characters, without Polish tails)!";
			}
			
			// Sprawdź poprawność adresu email
			//$email = $_POST['email'];
			$email = filter_input(INPUT_POST, 'email');
			$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
			
			if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
			{
				$everything_OK=false;
				$_SESSION['e_email']="Please enter a valid email address!";
			}
			
			//Sprawdź poprawność hasła
			//$password1 = $_POST['password1'];
			//$password2 = $_POST['password2'];
			$password1 = filter_input(INPUT_POST, 'password1');
			$password2 = filter_input(INPUT_POST, 'password2');
			
			if ((strlen($password1)<8) || (strlen($password1)>20))
			{
				$everything_OK=false;
				$_SESSION['e_password']="The password must be between 8 and 20 characters long!";
			}
			
			if ($password1!=$password2)
			{
				$everything_OK=false;
				$_SESSION['e_password']="The passwords provided are not identical!";
			}	

			$password_hash = password_hash($password1, PASSWORD_DEFAULT);
			
			
			//Zapamiętaj wprowadzone dane
			$_SESSION['fr_nick'] = $nick;
			$_SESSION['fr_email'] = $email;
			$_SESSION['fr_password1'] = $password1;
			$_SESSION['fr_password2'] = $password2;
				
			//require_once "connect.php";
			//mysqli_report(MYSQLI_REPORT_STRICT);
			require_once 'database.php';
			
			/*try 
			{
				$connection = new mysqli($host, $db_user, $db_password, $db_name);
				if ($connection->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}*/				
							
				//else
				//{
					//Czy email już istnieje?
					//$result = $connection->query("SELECT id FROM users WHERE email='$email'");
					$result = $db->prepare('SELECT id FROM users WHERE email = :email');
					$result->bindValue(':email', $email, PDO::PARAM_STR);
					$result->execute();
					
					//if (!$result) throw new Exception($connection->error);
					
					$how_many_emails = $result->rowCount();
					if($how_many_emails>0)
					{
						$everything_OK=false;
						$_SESSION['e_email']="There is already an account assigned to this email address!";
					}		

					//Czy nick jest już zarezerwowany?
					//$result = $connection->query("SELECT id FROM users WHERE username='$nick'");
					$result = $db->prepare('SELECT id FROM users WHERE username = :nick');
					$result->bindValue(':nick', $nick, PDO::PARAM_STR);
					$result->execute();
					
					//if (!$result) throw new Exception($connection->error);
					
					$how_many_nicks = $result->rowCount();
					if($how_many_nicks>0)
					{
						$everything_OK=false;
						$_SESSION['e_nick']="There is already a person with this nick! Choose another!";
					}
					
					if ($everything_OK==true)
					{
						//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
						
						if ($db->query("INSERT INTO users (`username`, `password`, `email`) VALUES ('$nick', '$password_hash', '$email')"))
						{		
							//przypisanie kategorii dla zarejestrowanego użytkownika
							$db->query("INSERT INTO expenses_category_assigned_to_users (name) SELECT name FROM expenses_category_default");							
							$db->query("INSERT INTO incomes_category_assigned_to_users (name) SELECT name FROM incomes_category_default");
							$db->query("INSERT INTO payment_methods_assigned_to_users (name) SELECT name FROM payment_methods_default");
							
							
							//pobranie id zarejestrowanego użytkownika
							$result = $db->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");

							$row = $result->fetch();
							$_SESSION['registered_user_id']=$row['id'];
							//$result->free_result();

							$id = $row['id'];
							
							//wstawienie id zarejestrowanego użytkownika do tabeli z kategoriami
							$db->query("UPDATE expenses_category_assigned_to_users SET user_id = '$id' ORDER BY id DESC LIMIT 16");
							$db->query("UPDATE incomes_category_assigned_to_users SET `user_id` = '$id' ORDER BY id DESC LIMIT 4");					
							$db->query("UPDATE payment_methods_assigned_to_users SET `user_id` = '$id' ORDER BY id DESC LIMIT 3");					
													
							$_SESSION['successful_registration']=true;
							header('Location: login.php');
							
						}
						//else
						//{
							//throw new Exception($connection->error);
						//}
						
					}
					
					//$connection->close();
				//}
				
			}
			//catch(Exception $e)
			//{
				//echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
				//echo '<br />Informacja developerska: '.$e;			
			//}
			
		}
	
	//}
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
		
	<main>
	
		<div class="inputContainer mt-3">

			<header>
				<h2 class="register font-weight-bold rounded">Registration</h2>
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
					?>"  placeholder="Name" required>						
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
					<input type="password" class="form-control  rounded-right register" name="password1" value="<?php
						if (isset($_SESSION['fr_password1']))
						{
							echo $_SESSION['fr_password1'];
							unset($_SESSION['fr_password1']);
						}
					?>" placeholder="Password" required>					
				</div>
				<?php
						if (isset($_SESSION['e_password']))
						{
							echo '<div class="error rounded text-center">'.$_SESSION['e_password'].'</div>';
							unset($_SESSION['e_password']);
						}
					?>	
					
				<div class="input-group">
					<div class="input-group-prepend">				
						<span class="input-group-text  rounded-left iconregister"><i class="icon-lock"></i></span>
					</div>
					<input type="password" class="form-control  rounded-right register" name="password2"  value="<?php
						if (isset($_SESSION['fr_password2']))
						{
							echo $_SESSION['fr_password2'];
							unset($_SESSION['fr_password2']);
						}
					?>" placeholder="Repeat password" required>					
				</div>
					
				<button  type="submit" class="btn register">Register</button>
					
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