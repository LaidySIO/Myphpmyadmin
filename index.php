<?php

include 'functions/DB.php';

$connexion = new DB();
$connexion->connex();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="files/css/bootstrap.min.css">
<link rel="stylesheet" href="files/css/monstyle.css">
<script src="files/js/bootstrap.min.js"></script>
<script src="files/js/jquery-3.3.1.min.js"></script>
<script src="files/js/monjs.js"></script>
<title>My PHPMyAdmin</title>

</head>
<body>
<body>
	<h1>Gestionnaire de Base de données</h1>
	<div class="main container">
  			<a href="includes/databases.php" id="load_databases">Gestion Bases de données</a>  		
  			<a href="includes/tables.php">Gestion des tables</a>  		
  			<!-- <a href="data.php">Gestion du contenu des tables</a>  		 -->
  			<a href="includes/request.php">Editeur de requêtes SQL</a>  		
	</div>

</body>
</html>