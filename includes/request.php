
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
	<input type="hidden" name="page_name" id="request"/>
	<form class="form-inline" name="query_form">
	<div class="form-group">
		<label for="request" class="col-sm-2 control-label">Requête SQL</label>
		<div class="col-sm-10">
			<textarea class="form-control" id="request" placeholder="Saisissez votre requête"></textarea>
		</div>
	</div>
	<button type="button" id="execute_query" class="btn btn-default">Créer</button>
</form>
</body>
