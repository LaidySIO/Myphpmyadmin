<?php
include '../functions/DB.php';
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../files/css/bootstrap.min.css">
<link rel="stylesheet" href="../files/css/monstyle.css">
<link rel="stylesheet" href="../files/open-iconic-master/font/css/open-iconic-bootstrap.min.css">
<script src="../files/js/jquery-3.3.1.min.js"></script>
<script src="../files/js/bootstrap.min.js"></script>
<script src="../files/js/monjs.js"></script>
<title>My PHPMyAdmin</title>

</head>
<body>
 <input type="hidden" name="page_name" id="tables"/>
<!--<input type="hidden" name="db_target" id="<?php echo $_GET['db'];?>"/>
<form class="form-inline" name="createtable">
	<div class="form-group">
		<label for="tablename" class="col-sm-2 control-label">Table name</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="tablename" placeholder="Table Name">
		</div>
	</div>
	<button type="submit" id="create_table" class="btn btn-default">Créer</button>
</form> -->
<div id="list_table">

</div>
</body>
</html>