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
	<input type="hidden" name="page_name" id="edit_tables"/>
	<input type="hidden" name="db_target" id="<?php echo $_GET['db'];?>"/>
	<input type="hidden" name="table_target" id="<?php echo $_GET['table'];?>"/>
	<div id="form_table">
		
	</div>
	<div id="infos_table">
		
	</div>
</body>
</html>