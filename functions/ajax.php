<?php

include '../functions/DB.php';

/* ##############################################LISTER ############################################## */

if(isset($_POST['load_database'])) //afficher toutes les bases
{
	$list_db= "<table class='bdlist table'>";
	$connexion = new DB();
	$stmt = $connexion->getdb();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		foreach ($row as $key => $value) {
			$list_db .= "<tr>".
							"<td>".
								"<a href='edit.databases.php?db=$value'>$value</a>".
							"</td>".
							"<td>".
								"<a href='edit.databases.php?db=$value'>".
									"<span class='icon-edit oi oi-pencil' id='".$value."'</span>".
								"</a>".
								"<span class='icon-delete oi oi-x' id='".$value."'></span>".
							"</td>".
						"</tr>";
		}
	}
	$list_db .= "</table>";
	echo $list_db;
}

if(isset($_POST['load_tables'])) //afficher toutes les tables
{

	$list_table= "<table class='tablelist table'>";
	$connexion = new DB();
	$stmt = $connexion->getdb();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		foreach ($row as $key => $value) {
			$list_table .= "<tr class='table-primary'>".
								"<td>$value</td>".
							"</tr>";
			$stmt_t = $connexion->getdbtables($value);
			while($row_t = $stmt_t->fetch(PDO::FETCH_ASSOC)) {
				foreach ($row_t as $key_t => $value_t) {
					$list_table .= "<tr class='hide'>".
										"<td>".
											"<a href='edit.tables.php?db=$value&table=$value_t'>".
											"$value_t</a>".
										"</td>".
									"</tr>";
				}
			}
		}
	}
	$list_table .= "</table>";
	echo $list_table;
}

/* ############################################## ACTION DB ##############################################*/

if(isset($_POST['create_database']) && isset($_POST['database_name'])) // créer DB
{
	$name = $_POST['database_name'];
	$connexion = new DB();
	$bool = $connexion->createdb($name);
	echo $bool;
}

if(isset($_POST['target']) && isset($_POST['drop_database'])) // supprimer DB
{
	$target = $_POST['target'];
	$connexion = new DB();
	$bool = $connexion->dropdb($target);
	echo $bool;
}

if(isset($_POST['target']) && isset($_POST['edit_database'])) // modifier DB
{
	$target = $_POST['target'];
	$form = "<form class='form-inline' name='createdb'>
			<div class='form-group'>
				<label for='dbname' class='col-sm-2 control-label'>Database Name</label>
				<div class='col-sm-10'>
					<input type='text' class='form-control' value='".$target."' id='dbname' placeholder='Database Name'>
				</div>
			</div>
			<button type='button' id='rename_database' class='btn btn-default'>Renommer</button>
		</form>";

	echo $form;
}

if(isset($_POST['rename_database']) && isset($_POST['database_oldname']) && isset($_POST['database_newname'])) // Renomer DB
{
	$newname = $_POST['database_newname'];
	$oldname = $_POST['database_oldname'];
	$connexion = new DB();
	$bool = $connexion->renamedb($oldname, $newname);
	echo $bool;
}

/* ############################################## ACTIONS TABLES ############################################## */

if(isset($_POST['target']) && isset($_POST['edit_table'])) // modifier nom table
{
	$target = $_POST['target'];
	$form = "<form class='form-inline' name='renametable'>
			<div class='form-group'>
				<label for='dbname' class='col-sm-2 control-label'>Database Name</label>
				<div class='col-sm-10'>
					<input type='text' class='form-control' value='".$target."' id='tablename' placeholder='Database Name'>
				</div>
			</div>
			<button type='button' id='rename_table' class='btn btn-default'>Renommer</button>
		</form>";

	echo $form;
}

if(isset($_POST['db']) && isset($_POST['tablename']) && isset($_POST['columnname']) && isset($_POST['type']) && isset($_POST['size']) && isset($_POST['null']) && isset($_POST['auto']) && isset($_POST['create_table'])) // creer table
{
	$db = $_POST['db'];
	$tablename = $_POST['tablename'];
	$columnname = $_POST['columnname'];
	$type = $_POST['type'];
	$size = $_POST['size'];
	$null = $_POST['null'];
	$auto = $_POST['auto'];

	$connexion = new DB();
	$bool = $connexion->createtable($db, $tablename, $columnname, $type, $size, $null, $auto);
	echo $bool;
}

if(isset($_POST['target']) && isset($_POST['form_table'])) // formulaire creation de table
{
	// $target = $_POST['target'];
	$form = "<hr><form class='createtable form-inline' name='createtable'>".
				"<div class='form-group'>".
					"<label for='' class='col-sm-2 control-label'>Table Name</label>".
					"<div class='col-sm-10'>".
						"<input type='text' class='form-control' value='' id='tablename' placeholder='Table Name'>".
					"</div>".
				"</div>".
				"<button type='button' id='create_table_form' class='btn btn-default'>Creer</button>".
			"</form>";
	echo $form;
}

if(isset($_POST['column_arg'])) // creer colonne
{
	// $form = "<form class='form-inline' name='createtable'>
	// 		<div class='form-group'>
	// 			<label for='tablename' class='col-sm-2 control-label'>Table Name</label>
	// 			<div class='col-sm-10'>
	// 				<input type='text' class='form-control' value='".$target."' id='tablename' placeholder='Table Name'>
	// 			</div>";
			$form = generate_column_arg();

	echo $form;
}

if(isset($_POST['rename_table']) && isset($_POST['table_oldname']) && isset($_POST['table_newname']) && isset($_POST['db'])) // Renommer table
{
	$newname = $_POST['table_newname'];
	$oldname = $_POST['table_oldname'];
	$db = $_POST['db'];
	$connexion = new DB();
	$bool = $connexion->renametable($db, $oldname, $newname);
	echo $bool;
}

if(isset($_POST['db']) && isset($_POST['target']) && isset($_POST['drop_table'])) // supprimer Table
{
	$target = $_POST['target'];
	$db = $_POST['db'];
	$connexion = new DB();
	$bool = $connexion->droptable($db, $target);
	echo $bool;
}

/* ############################################## INFOS ############################################## */

if(isset($_POST['load_dbinfos']) && isset($_POST['target'])) //afficher infos DB
{
	$dbname = $_POST['target'];
	$rep = "<table class='bdindos table'>".
				"<tr>";
	$connexion = new DB();
	$stmt = $connexion->getdbinfos($dbname);
	$name = "";

	if($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // <TH>
        foreach ($row as $key => $value) {
            $rep.="<th>".$key."</th>";
        }
        $rep.="<th> Actions</th>";
        $rep.="</tr>";
        $stmt2 = $connexion->getdbinfos($dbname);
        while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) { // <TD>
            $rep.="<tr>";
            foreach ($row as $key => $value) {
                if($key == "Nom"){
                    $name = $value;
                    $rep.="<td><a href='edit.tables.php?table=$value&db=$dbname'>".$value."</a></td>";
                }
                else{
                    $rep.="<td>".$value."</td>";
                }
            }
            $rep .= "<td>".
                        "<a href='edit.tables.php?db=$dbname&table=".$name."'>".
                            "<span class='icon-edit oi oi-pencil' id=''</span>".
                        "</a>".
                        "<span class='icon-delete oi oi-x'  name='$name' id=''></span>".
                    "</td>";
            $rep.="</tr>";
        }
    }
    else{
        $rep .= "<td>NO DATA</td></tr>";
    }

    $rep.= "</table>";
	echo $rep;
}

if(isset($_POST['load_tableinfos']) && isset($_POST['dbname']) && isset($_POST['target'])) //afficher infos Table
{
	$dbname = $_POST['dbname'];
	$target = $_POST['target'];
	$rep = "<table class='bdindos table'>".
				"<tr>";
	$connexion = new DB();

	//LISTE DES COLONNES
	$stmt = $connexion->getcolonneinfos($dbname, $target);

	$row = $stmt->fetch(PDO::FETCH_ASSOC);  // <TH>
	foreach ($row as $key => $value) {
		$rep.="<th>".$key."</th>";
	}
	$rep.="<th> Actions</th>";
	$rep.="</tr>";
	$stmt2 = $connexion->getcolonneinfos($dbname, $target);
	while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) { // <TD>
		$rep.="<tr>";
		foreach ($row as $key => $value) {
				$rep.="<td>".$value."</td>";
		}
		$rep.="</tr>";
	}
	$rep.="</table>";

	//DONNEES DE LA TABLE

	$rep .= "<table class='bdindos table'>".
				"<tr>";
	$stmt = $connexion->gettableinfos($dbname, $target);

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))  // <TH>
	{
		foreach ($row as $key => $value) {
			$rep.="<th>".$key."</th>";
		}
		$rep.="<th> Actions</th>";
		$rep.="</tr>";
		$stmt2 = $connexion->gettableinfos($dbname, $target);
		while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) { // <TD>
			$rep.="<tr>";
			foreach ($row as $key => $value) {
					$rep.="<td>".$value."</td>";
			}
			$rep.= "<td>".
						"<a href='edit.databases.php?db=$value'>".
							"<span class='icon-edit oi oi-pencil' id='".$row["id"]."'</span>".
						"</a>".
						"<span class='icon-delete oi oi-x' id='".$row["id"]."'></span>".
					"</td>";
			$rep.="</tr>";
		}
	}
	else{
		$rep .= "<td>NO DATA</td></tr>";
	}
	
	$rep.= "</table>";

	echo $rep;
}
	
/* ############################################## Editeur de requetes ############################################## */


if(isset($_POST['query']) && isset($_POST['execute_query'])) // créer DB
{
	$query = $_POST['query'];

	$bool = execquery($query);
	echo $bool;
}

/* ############################################## Fonctions ############################################## */

function execquery($query)
{
	$query = str_replace(";", "", $query);
	$connexion = new DB();
	return $connexion->executequery($query);
}

 function generate_column_arg()
 {
 	$form = "<div class='column_arg form-group row'>".
 				"<div class='col-sm-10'>".
					"<input type='text' class='form-control' value='' id='columnname' placeholder='column_name'>".
				"</div>".
				"<div class='col-sm-10'>".
					"<select name='' id='typeselect'>".
						"<option id=''>int</option>".
						"<option id=''>varchar</option>".
					"</select>".
				"</div>".
				"<div class='col-sm-10'>".
					"<input type='number' class='form-control' value='' id='typesize' placeholder='size'>".
				"</div>".
				"<div class='col-sm-10'>".
					"<input id='null' type='checkbox'> null ".
				"</div>".
				"<div class='col-sm-10'>".
					"<input id='auto' type='checkbox'>  Auto Increment".
				"</div>".
			"</div>";


	return $form;
 }
?>