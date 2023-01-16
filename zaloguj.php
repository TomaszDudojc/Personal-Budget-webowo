<?php

	session_start();

	if ((!isset($_POST['email'])) || (!isset($_POST['haslo'])))
	{
		header('Location: logowanie.php');
		exit();
	}

	//require_once "connect.php";

	//$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	//if ($polaczenie->connect_errno!=0)
	//{
		//echo "Error: ".$polaczenie->connect_errno;
	//}
	
	
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
		$email = $_POST['email'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM users WHERE email='%s'",
		mysqli_real_escape_string($polaczenie,$email))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				
				if (password_verify($haslo, $wiersz['password']))
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['id_of_logged_user'] = $wiersz['id'];
					$_SESSION['name_of_logged_user'] = $wiersz['username'];				
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: menu.php');
				}
				else 
				{
					$_SESSION['blad'] = 'Nieprawidłowy email lub hasło!';
					header('Location: logowanie.php');
				}
				
			} else {
				
				$_SESSION['blad'] = 'Nieprawidłowy email lub hasło!';
				header('Location: logowanie.php');
				
			}
			
		}
		else
		{
			throw new Exception($polaczenie->error);
		}
		$polaczenie->close();
	}
	
	}
	
	catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
				echo '<br />Informacja developerska: '.$e;
			
			}
?>