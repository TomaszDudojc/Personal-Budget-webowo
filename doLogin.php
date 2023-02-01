<?php

	session_start();

	if ((!isset($_POST['email'])) || (!isset($_POST['password'])))
	{
		header('Location: login.php');
		exit();
	}

	//require_once "connect.php";

	//$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	//if ($connection->connect_errno!=0)
	//{
		//echo "Error: ".$connection->connect_errno;
	//}
	
	
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
		//$email = $_POST['email'];
		//$password = $_POST['password'];
		//$email = filter_input(INPUT_POST, 'email');
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		$password = filter_input(INPUT_POST, 'password');
		
		//$email = htmlentities($email, ENT_QUOTES, "UTF-8");
		
	
		//if ($result = @$connection->query(
		//sprintf("SELECT * FROM users WHERE email='%s'",
		//mysqli_real_escape_string($connection,$email))))
		if (!empty($email))
		{
		$result = $db->prepare('SELECT * FROM users WHERE email = :email');
		$result->bindValue(':email', $email, PDO::PARAM_STR);
		$result->execute();
					
		//{
			$how_many_users = $result->rowCount();
			if($how_many_users>0)
			{
				//$row = $result->fetch_assoc();
				$row = $result->fetch();
				
				//if (password_verify($password, $row['password']))
				if ($row && password_verify($password, $row['password']))
				{
					$_SESSION['logged'] = true;
					$_SESSION['id_of_logged_user'] = $row['id'];
					$_SESSION['name_of_logged_user'] = $row['username'];				
					
					unset($_SESSION['error']);
					//$result->free_result();
					$_SESSION['info_welcome']="Witaj ".$_SESSION['name_of_logged_user']."!";
					header('Location: menu.php');
					//exit();
					//header('Location: menu.php');
				}
				else 
				{
					$_SESSION['error'] = 'Nieprawidłowy email lub hasło!';
					header('Location: login.php');
				}
				
			} else {
				
				$_SESSION['error'] = 'Nieprawidłowy email lub hasło!';
				header('Location: login.php');
				
			}
			
		//}
		//else
		//{
			//throw new Exception($connection->error);
		//}
		//$connection->close();
	//}
	
	//}
	
	//catch(Exception $e)
			//{
			//	echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			//	echo '<br />Informacja developerska: '.$e;
			
			//}
		}
	else 
	{	
	header('Location: index.php');
	exit();
	}
?>