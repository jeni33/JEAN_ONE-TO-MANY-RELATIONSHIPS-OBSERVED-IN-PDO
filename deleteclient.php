<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Delete Client</title>
</head>
<style>
	body {
			font-family: "system-ui";
			background-color: #FDE0DF;
		}
	input {
			font-size: 1.5em;
			height: 40px;
			width: 200px;
			background-color: #FDE0DF;
		}
</style>
<body>
	<a href="index.php">Return to home</a>
	<h1>Are you sure you want to delete this client?</h1>
	<?php $getClientByID = getClientByID($pdo, $_GET['client_id']); ?>
	<div class="container" style="border-style: solid; height: 380px; background-color: #F1EBDA;">
		<h2>First Name: <?php echo $getClientByID['first_name']; ?></h2>
		<h2>Last Name: <?php echo $getClientByID['last_name']; ?></h2>
		<h2>Contact Number: <?php echo $getClientByID['contact_number']; ?></h2>
        
		<div class="deleteBtn" style="float: right; margin-right: 10px;">
			<form action="core/handleForms.php?client_id=<?php echo $_GET['client_id']; ?>" method="POST">
				<input type="submit" name="deleteClientBtn" value="Delete">
			</form>			
		</div>	

	</div>
</body>
</html>