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
	
	.delete {
		color:red;
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
			
			input.array.forEach(function(i) {
				var newBlock = $("<tr>");
				var newLine = $("<td>");
				var link = $("<a>");
				var deleteLink = $("<a>");
				var deleteCell = $("<td>");
				
				
				link.text(i.project_name);
				link.attr({"href":"edit.php?id="+i.p_id});
				deleteLink.text("X");
				deleteLink.attr({"href":"#","class":"delete"});
				
				
				var cur = i.p_id;
				deleteLink.click(function(){
					$.post("asha_delete.php",{p_id:cur},function(e){
						window.location.reload();
					});
				});
				newLine.append(link);
				newBlock.append(newLine);
				deleteCell.append(deleteLink);
				newBlock.append(deleteCell);
				
				newBlock.attr({"id":i.p_id});
				
				$("#projects").append(newBlock);
			});

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
