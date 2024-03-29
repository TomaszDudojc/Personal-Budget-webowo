<?php

	session_start();
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
	}	
	
	$current_year = date('Y');
	
	//require_once "connect.php";
	//mysqli_report(MYSQLI_REPORT_STRICT);
	require_once 'database.php';		
		//try 
		//{
			//$connection = new mysqli($host, $db_user, $db_password, $db_name);
			//if ($connection->connect_errno!=0)
			//{
				//throw new Exception(mysqli_connect_errno());
		//	}
			
			//else
			//{	//INCOMES			
				//$result=($connection->query("SELECT incomes_category_assigned_to_users.name, incomes.income_category_assigned_to_user_id, users.username, incomes.date_of_income, incomes.income_comment, incomes.amount, SUM(incomes.amount) AS AmountOfIncomes FROM incomes, incomes_category_assigned_to_users, users  WHERE  users.id='$_SESSION[id_of_logged_user]' AND incomes.date_of_income LIKE'$current_year-%'  AND  users.id=incomes_category_assigned_to_users.user_id AND users.id=incomes.user_id AND incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id GROUP BY incomes.income_category_assigned_to_user_id ORDER BY AmountOfIncomes DESC"));
				$result= $db->query("SELECT incomes_category_assigned_to_users.name, incomes.income_category_assigned_to_user_id, users.username, incomes.date_of_income, incomes.income_comment, incomes.amount, SUM(incomes.amount) AS AmountOfIncomes FROM incomes, incomes_category_assigned_to_users, users  WHERE  users.id='$_SESSION[id_of_logged_user]' AND incomes.date_of_income LIKE'$current_year-%'  AND  users.id=incomes_category_assigned_to_users.user_id AND users.id=incomes.user_id AND incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id GROUP BY incomes.income_category_assigned_to_user_id ORDER BY AmountOfIncomes DESC");
				
				//$number_of_incomes = $result->num_rows;				
				$number_of_incomes = $result->rowCount();				
				
				//$categories= $result->fetch_all(MYSQLI_ASSOC);
				$categories= $result->fetchAll();
								
				//$result->free_result();				
				
				//$result=($connection->query("SELECT incomes_category_assigned_to_users.name, incomes.income_category_assigned_to_user_id, users.username, incomes.date_of_income, incomes.income_comment, incomes.amount FROM incomes, incomes_category_assigned_to_users, users  WHERE  users.id='$_SESSION[id_of_logged_user]' AND incomes.date_of_income LIKE'$current_year-%'  AND  users.id=incomes_category_assigned_to_users.user_id AND users.id=incomes.user_id AND incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id  ORDER BY incomes.date_of_income"));
				$result= $db->query("SELECT incomes_category_assigned_to_users.name, incomes.income_category_assigned_to_user_id, users.username, incomes.date_of_income, incomes.income_comment, incomes.amount FROM incomes, incomes_category_assigned_to_users, users  WHERE  users.id='$_SESSION[id_of_logged_user]' AND incomes.date_of_income LIKE'$current_year-%'  AND  users.id=incomes_category_assigned_to_users.user_id AND users.id=incomes.user_id AND incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id  ORDER BY incomes.date_of_income");
				
				//$incomes= $result->fetch_all(MYSQLI_ASSOC);				
				$incomes= $result->fetchAll();	
				//$result->free_result();					
					
				//$result=($connection->query("SELECT SUM(incomes.amount) AS AmountOfAllIncomes FROM incomes WHERE  incomes.user_id='$_SESSION[id_of_logged_user]' AND incomes.date_of_income LIKE '$current_year-%' "));		
				$result=$db->query("SELECT SUM(incomes.amount) AS AmountOfAllIncomes FROM incomes WHERE  incomes.user_id='$_SESSION[id_of_logged_user]' AND incomes.date_of_income LIKE '$current_year-%' ");		
								
				//$row = $result->fetch_assoc();	
				$row = $result->fetch();				
				$_SESSION['amount_of_all_incomes'] = $row['AmountOfAllIncomes'];
				//$result->free_result();
				//EXPENSES
				//$result=($connection->query("SELECT expenses_category_assigned_to_users.name, expenses.expense_category_assigned_to_user_id, users.username, expenses.date_of_expense, expenses.expense_comment, expenses.amount, SUM(expenses.amount) AS AmountOfExpenses FROM expenses, expenses_category_assigned_to_users, users  WHERE  users.id='$_SESSION[id_of_logged_user]' AND expenses.date_of_expense LIKE'$current_year-%'  AND  users.id=expenses_category_assigned_to_users.user_id AND users.id=expenses.user_id AND expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id GROUP BY expenses.expense_category_assigned_to_user_id ORDER BY AmountOfExpenses DESC"));
				$result= $db->query("SELECT expenses_category_assigned_to_users.name, expenses.expense_category_assigned_to_user_id, users.username, expenses.date_of_expense, expenses.expense_comment, expenses.amount, SUM(expenses.amount) AS AmountOfExpenses FROM expenses, expenses_category_assigned_to_users, users  WHERE  users.id='$_SESSION[id_of_logged_user]' AND expenses.date_of_expense LIKE'$current_year-%'  AND  users.id=expenses_category_assigned_to_users.user_id AND users.id=expenses.user_id AND expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id GROUP BY expenses.expense_category_assigned_to_user_id ORDER BY AmountOfExpenses DESC");
				
				//$number_of_expenses = $result->num_rows;	
				$number_of_expenses = $result->rowCount();	
				
				//$categories_of_expense= $result->fetch_all(MYSQLI_ASSOC);
				$categories_of_expense= $result->fetchAll();	
								
				//$result->free_result();				
				
				//$result=($connection->query("SELECT expenses_category_assigned_to_users.name, expenses.expense_category_assigned_to_user_id, users.username, expenses.date_of_expense, expenses.expense_comment, expenses.amount FROM expenses, expenses_category_assigned_to_users, users  WHERE  users.id='$_SESSION[id_of_logged_user]' AND expenses.date_of_expense LIKE'$current_year-%'  AND  users.id=expenses_category_assigned_to_users.user_id AND users.id=expenses.user_id AND expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id  ORDER BY expenses.date_of_expense"));
				$result= $db->query("SELECT expenses_category_assigned_to_users.name, expenses.expense_category_assigned_to_user_id, users.username, expenses.date_of_expense, expenses.expense_comment, expenses.amount FROM expenses, expenses_category_assigned_to_users, users  WHERE  users.id='$_SESSION[id_of_logged_user]' AND expenses.date_of_expense LIKE'$current_year-%'  AND  users.id=expenses_category_assigned_to_users.user_id AND users.id=expenses.user_id AND expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id  ORDER BY expenses.date_of_expense");
				
				//$expenses= $result->fetch_all(MYSQLI_ASSOC);				
				$expenses= $result->fetchAll();			
				//$result->free_result();					
					
				//$result=($connection->query("SELECT SUM(expenses.amount) AS AmountOfAllExpenses FROM expenses WHERE  expenses.user_id='$_SESSION[id_of_logged_user]' AND expenses.date_of_expense LIKE '$current_year-%' "));		
				$result=$db->query("SELECT SUM(expenses.amount) AS AmountOfAllExpenses FROM expenses WHERE  expenses.user_id='$_SESSION[id_of_logged_user]' AND expenses.date_of_expense LIKE '$current_year-%' ");		
								
				//$row = $result->fetch_assoc();				
				$row = $result->fetch();				
				$_SESSION['amount_of_all_expenses'] = $row['AmountOfAllExpenses'];
				//$result->free_result();	
				
				$_SESSION['balance'] = $_SESSION['amount_of_all_incomes'] - $_SESSION['amount_of_all_expenses'];
				$_SESSION['balance'] = number_format($_SESSION['balance'] , 2, '.', '');	
				
				//$connection->close();
		//	}
	//	}
		
		//catch(Exception $e)
			//{
				//echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
				//echo '<br />Informacja developerska: '.$e;			
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
	
	<script>
		window.onload = function () {

		var chart = new CanvasJS.Chart("chartContainer", {
			exportEnabled: true,
			animationEnabled: true,
			title:{
				text: "Expense structure"
			},
			legend:{
				cursor: "pointer",
				itemclick: explodePie
			},
			data: [{
				type: "pie",
				showInLegend: true,
				toolTipContent: "{name}: <strong>{y} PLN</strong>",
				indexLabel: "{name} - {y} PLN",
				dataPoints: [
				<?php
					foreach ($categories_of_expense as $category_of_expense)
					{	
						echo "{"."y: ".$category_of_expense['AmountOfExpenses'].", "."name: ".'"'.$category_of_expense['name'].'"'.", exploded: true"."}".",";
					}
				?>			
				]
			}]
		});
		chart.render();
		}

		function explodePie (e) {
			if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
			} else {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
			}
			e.chart.render();
	}
</script>		
	
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
			
				<ul class="navbar-nav mx-auto py-0">
				
					<li class="nav-item">
						<a class="nav-link" href="menu.php"><i class="icon-home-1"></i>Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="income.php"><i class="icon-money"></i>Add income</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="expense.php"><i class="icon-basket"></i>Add expense</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" style="color: #060B95;" href="balance.php"><i class="icon-chart-bar"></i>View balance</a>
					</li>					
					<li class="nav-item ">

					<ul class="navbar-nav py-0 px-3 active">				
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" style="color: #060B95;" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu"><i class="icon-calendar"></i>Select a period</a>						
							<div class="dropdown-menu" aria-labelledby="submenu" style="background-color: #E2FDFA; border: 1px solid #a5cda5;">						
								<a class="dropdown-item" style="color: #060B95;" href="balance.php">Current month</a>
								<a class="dropdown-item" style="color: #060B95;" href="balanceOfPreviousMonth.php">Previous month</a>
								<a class="dropdown-item active" style="color:#060B95;" href="balanceOfCurrentYear.php">Current year</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" style="color: #060B95;" data-toggle="modal" data-target="#dateRange" href="#">Custom</a>						
							</div>
						</li>					
					</ul>
					</li>					
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-wrench"></i>Settings</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-danger" href="logout.php"><i class="icon-off"></i>Log out</a>
					</li>
					
				</ul>		
				
			</div>			
			
			<div class="modal" id="dateRange" style="display: none">
			  <div class="modal-dialog">
				<div class="modal-content table rounded" style="background-color: #E2FDFA;">
						  <div class="modal-header">
							<h3 class="modal-title">Select a date range</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
				  
						  <div class="modal-body">
							<form action="balanceFromSelectedDateRange.php" method="post">
								<div class="input-group">
									<div class="input-group-prepend">				
										<span class="input-group-text  rounded-left icon my-0"><i class="icon-calendar"></i></span>
									</div>						
									<input type="date" class="form-control  rounded-right my-0 mr-2" name="starting_date" required>
									
									<div class="input-group-prepend">				
										<span class="input-group-text  rounded-left icon  my-0 ml-2"><i class="icon-calendar"></i></span>
									</div>
									<input type="date" class="form-control  rounded-right my-0" name="end_date" required>
								</div>
								
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-success">Save</button>
								</div>														
							</form>					
						</div>				
								
					</div> 		
				</div>
			</div>
		
		</nav>
		
	</div>
	
	<main>
	
	<div class="container my-3 text-center pb-5">
	
		<div class="row">	
			
				<h2 class="col-10 col-md-6 font-weight-bold rounded mx-auto"><i class="icon-calendar mr-3"></i>Current year</h2>			
						
			<div class="w-100"></div>		
											
				<div class="table col-10 col-md-5 mx-auto rounded mt-2 mb-0">		
					<h3 style="background-color: #D3DDE9; border: 1px solid  #c2cce8;" class="rounded">Incomes<i class="icon-money ml-5"></i><?php	echo $_SESSION['amount_of_all_incomes'];?></h3>
					<?php						
						if  ($number_of_incomes == 0)
						{								
								echo '<div class="information rounded text-center mx-auto p-2 w-100" >No income in the selected period</div>';	
							}						
							
						else
							{
								foreach ($categories as $category)
								{				
														
									echo'<h5 class="rounded bg-white my-2" style="color: #060B95;">'."$category[name]".'<i class="icon-money ml-3"></i>'."$category[AmountOfIncomes]</h5>";				
								
									foreach ($incomes as $income)
									{								
										if ($category['income_category_assigned_to_user_id']==$income['income_category_assigned_to_user_id'])
										echo'<h6 class="bg-white rounded">'.'<i class="icon-money">'."</i>$income[date_of_income]".'<span class="mx-2">&#8680</span>'."$income[income_comment]".'<span class="mx-2">&#8680;</span>'."$income[amount]</h6>";
									}
								}						
								
							}
						
					
					?>
					
				</div>
					
				<div class="table col-10 col-md-5 mx-auto rounded mt-2 mb-0">		
					<h3 style="background-color: #D3DDE9; border: 1px solid  #c2cce8;" class="rounded">Expenses<i class="icon-basket ml-5"></i><?php	echo $_SESSION['amount_of_all_expenses'];?></h3>
					<?php						
						if  ($number_of_expenses == 0)
						{								
								echo '<div class="information rounded text-center mx-auto p-2 w-100" >No expenses in the selected period</div>';	
							}
						
						else 
						{	
							foreach ($categories_of_expense as $category_of_expense)
							{					
								echo'<h5 class="rounded bg-white my-2" style="color: #060B95;">'."$category_of_expense[name]".'<i class="icon-basket ml-3"></i>'."$category_of_expense[AmountOfExpenses]</h5>";
														
								foreach ($expenses as $expense)
								{								
									if ($category_of_expense['expense_category_assigned_to_user_id']==$expense['expense_category_assigned_to_user_id'])
									echo'<h6 class="bg-white rounded">'.'<i class="icon-basket">'."</i>$expense[date_of_expense]".'<span class="m-2">&#8680</span>'."$expense[expense_comment]".'<span class="m-2">&#8680;</span>'."$expense[amount]</h6>";
								}
							}
						}
					?>
					
				</div>

			<div class="w-100"></div>	
			
			<div class="table col-10 col-md-6 mx-auto rounded mt-2 mb-0">
					<h3 style="background-color: #D3DDE9; border: 1px solid  #c2cce8;" class="rounded">Balance<i class="icon-chart-bar ml-5 mr-1"></i><?php echo $_SESSION['balance'] ;?></h3>					
					<h4 class="font-weight-bold bg-white rounded" style="color: #060B95;"></h4>
					<?php
						if ($_SESSION['balance']!=0)
						{
							if ($_SESSION['balance']<0)					
						echo'<h4 class="text-danger bg-white rounded">&#128201; Watch out, you are getting into debt!</h4>';
						else
						echo '<h4 class="text-success bg-white rounded">&#128200; Congratulations. You manage your finances very well!</h4>';
						}					
					?>
			</div>
			
			<?php
				if  ($_SESSION['amount_of_all_expenses']!=0)				
				echo '<div id="chartContainer" style="height: 450px; width: 90%; margin-left: auto; margin-right: auto;"></div>';
			?>
				
			<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>		
				
		</div>
	
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