<?php
	$store = true;
	include 'jsout.php';
	
?>

<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
.nav > li {
	height:60px;
	float:right;
}
.nav > li > a {
	margin-top:20px;
	font-size:30px;
}
	</style>
	<title>Existing Projects</title>
	<script src="jquery.js"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="jcrop/js/jquery.Jcrop.min.js"></script>
	<link href="jcrop/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	body {
		background-image:url("diamond.png");
	}
	tr:nth-child(even)    { background-color:#ddd; }
	tr:nth-child(odd)    { background-color:#fff; }
	table {
		font-size:30px;

	}
	
	tr {
		height:40px;
	}
	
	td {
		padding:5px;
	}
	
	.container {
		background-color: white;
		padding: 10em;
		box-shadow: 0px 0px 20px #888888;
	}

	</style>

	<script>
		window.onload=function(){
		var input = <?=$store?>;
		console.log(input);

		for(var i = 0; i < input.array.length; i++) {
			var newBlock = $("<tr>");
			var newLine = $("<td>");
			var link = $("<a>");
			
			
			link.text(input.array[i].project_name);
			link.attr({"href":"edit.php?id="+input.array[i].p_id});
			newLine.append(link);
			newBlock.append(newLine);
			
			newBlock.attr({"id":input.array[i].p_id});
			
			$("#projects").append(newBlock);
		}
		}
	</script>
</head>
<body>

	<?php include('common.php');
	headerbar();
	?>


	<div class="container">
			<br/>
	<br/>
		<br/>
	<br/>
		<h1>Projects Directory</h1>
		<hr />
		<table id="projects" border="1">
		</table>
	</div>
</body>
</html>
