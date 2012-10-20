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
	
	ul {
		font-size:30px;
		list-style-type:circle;
		
	}
	
	li {
		margin-top:10px;
	}
	</style>

	<script>
		window.onload=function(){
		var input = <?=$store?>;
		console.log(input);

		for(var i = 0; i < input.array.length; i++) {
			var newBlock = $("<li>");
			var link = $("<a>");
			
			
			link.text(input.array[i].project_name);
			link.attr({"href":"edit.php?id="+input.array[i].p_id});
			newBlock.append(link);
			
			
			newBlock.attr({"id":input.array[i].p_id});
			
			$("#projects").append(newBlock);
		}
		}
	</script>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">

				<a class="brand" href="http://www.ashanet.org/">
					<div id="logo" style="float:left;">
						<img src="http://www.ashanet.org/graphics/asha_logo.png" style="height:60px;" alt="Asha for Education"/>
					</div>
				</a>
				
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li><a href="index.html">Home</a></li>
						<li><a href="submit.php">Submit</a></li>
						<li><a href="edit_list.php">Edit</a></li>
					</ul>
				</div>
		</div>
	</div>


	<div class="container">
			<br/>
	<br/>
		<br/>
	<br/>
		<h1>Projects Directory</h1>
		<hr />
		<ul id="projects">
		</ul>
	</div>
</body>
</html>
