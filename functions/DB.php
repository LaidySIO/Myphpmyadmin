<?php

class DB
{
	/* ################################################### GENERAL ###################################################*/
	function connex() // Connexion à la DB
	{
		$servername = "localhost";
		$username = "root";
		$password = "";
		
		try {
			$conn = new PDO("mysql:host=$servername;dbname=php_project", $username, $password);
	    // set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		return $conn;
	}

	function exist($name, $type)
	{
		$req = "select * form $name";
		if($type == "db")
		{
			$req = "SHOW TABLES FROM $db";
		}
		try {

			$connexion = $this->connex();
			$stmt = $connexion->prepare($req);
			if($stmt->execute(array())) {
				return $stmt->rowCount();
			}
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
	}

	function executequery($query) //Créer DB
	{
		try{
			$connexion = $this->connex();
			$stmt = $connexion->prepare("$query");
			$stmt->execute();
			return(1);
		} 
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		
	}
/* ################################################### DATABASES ###################################################*/

	function getdb() // recupérer toutes les DB
	{
		try {

			$connexion = $this->connex();
			$stmt = $connexion->prepare("SHOW DATABASES");
			if($stmt->execute(array())) {
				return $stmt;
			}
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}

	}

	function getdbtables($db) //recupérer tables de DB
	{
		try {

			$connexion = $this->connex();
			$stmt = $connexion->prepare("SHOW TABLES FROM $db");
			if($stmt->execute(array())) {
				return $stmt;
			}
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}

	}

	function createdb($name) //Créer DB
	{
		try{
			$connexion = $this->connex();
			$stmt = $connexion->prepare("CREATE DATABASE IF NOT EXISTS $name ");
			$stmt->execute();
			return(1);
		} 
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		
	}

	function dropdb($name) //Supprimer DB
	{
		try{
			$connexion = $this->connex();
			$stmt = $connexion->prepare("DROP DATABASE $name ");
			$stmt->execute();
			return(1);
		} 
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
		
	}

	function renamedb($oldname, $newname) // renommer DB
	{
		try{
			  	$createdb = $this->createdb($newname);
			 if($createdb)
			 {
				$connexion = $this->connex();
				$stmt_table = $this->getdbtables($oldname); //On recupère les tables de la base
				$count_db =  $stmt_table->rowCount(); // on compte le nombre de table trouvées
				echo $count_db;
				if($count_db <= 0) // Si pas de tables on en crée une temporaire
				{
					$this->createtable("temp", $oldname);

				}
				while($row = $stmt_table->fetch(PDO::FETCH_ASSOC)) {
					foreach ($row as $key => $value) {
						$stmt = $connexion->prepare("RENAME TABLE ".$oldname.".".$value." TO ".$newname.".".$value."; ");
						$stmt->execute();
					}
				}
				 $dropdb = $this->dropdb($oldname);
			}
		} 
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
	}

	function getdbinfos($db) //recupérer tables de DB
	{
		try {

			$connexion = $this->connex();
			$stmt = $connexion->prepare("SELECT TABLE_NAME as Nom, CREATE_TIME as Date_Creation,TABLE_ROWS as NB_Lignes, round(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024),2) as DATA_Mo FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db' ");
			if($stmt->execute()) {
				return $stmt;
			}
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}

	}

	/* ################################################### TABLES ###################################################*/

	function createtable($db, $name, $columnname, $type, $size, $null, $auto) //Créer Table
	{
		try{
			$arg="";
			
			if(!$null)
			{
				$arg .= "NOT NULL";
			}

			if($auto)
			{
				$arg .= " AUTO_INCREMENT PRIMARY KEY";
			}

			$connexion = $this->connex();
			$stmt = $connexion->prepare("CREATE TABLE $db.$name ($columnname $type($size) $arg)");
			$stmt->execute();
			return 1;
		} 
		catch(PDOException $e)
		{
			echo "Creéation failed: " . $e->getMessage();
		}
		
	}

	function droptable($db, $name) //Créer supprimer table
	{
		try{
			$connexion = $this->connex();
			$stmt = $connexion->prepare("drop table $db.$name");
			$stmt->execute();
			var_dump($stmt);
		} 
		catch(PDOException $e)
		{
			echo "Creéation failed: " . $e->getMessage();
		}
	}

	function renametable($db, $oldname, $newname)
	{
		try{
			$connexion = $this->connex();
			$stmt = $connexion->prepare("ALTER TABLE $db.$oldname RENAME $db.$newname");
			$stmt->execute();
			return (1);
		} 
		catch(PDOException $e)
		{
			echo "Creéation failed: " . $e->getMessage();
		}
	}

	function gettableinfos($db, $table)
	{
		try{
			$connexion = $this->connex();
			$stmt = $connexion->prepare("SELECT * FROM $db.$table");
			if($stmt->execute(array())) {
				return $stmt;
			}
		} 
		catch(PDOException $e)
		{
			echo "Creéation failed: " . $e->getMessage();
		}
	}

	/* ################################################### COLONNES ###################################################*/

	function getcolonneinfos($db, $table)
	{

		try{
			$connexion = $this->connex();
			$stmt = $connexion->prepare("show columns from $db.$table");
			if($stmt->execute(array())) {
				return $stmt;
			}
		} 
		catch(PDOException $e)
		{
			echo "Creéation failed: " . $e->getMessage();
		}
	}
}
?>