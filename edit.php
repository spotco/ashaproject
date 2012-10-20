<script>
var input = {"img_url":"","img_style":"max-width:none;","fields":[{"field_name":"field 1","details":["field 1 detail 1","field 1 detail 2"]},{"field_name":"field 2","details":["field 2 detail 1"]}],"project_name":"project 1","focus":"project 1 focus"};
</script>

<!DOCTYPE html>
<html>
<head>
	<title>Project Upload/Edit</title>
	<script src="jquery.js"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<style type="text/css">
.fieldcombo {
	margin-bottom: 50px;
	margin-top: 50px;
}
.enterfield,#project  {
	font-size: 30px !important;
	height:35px !important;
	width: 50% !important;
}
#focus {
	width: 40%;
}
.more {
	cursor:pointer;
	margin:10px;
}
.detailfield {
	width:40%;
}

	</style>
	<script>
$(function(){
	$("#project").val(input.project_name);
	$("#focus").val(input.focus);
	input.fields.forEach(function(i){
		console.log(i);
	})
});

	</script>
	<script>

	</script>
</head>
<body>
	<div class="container">
		<h1>Project Edit</h1>
		<hr />
		<div class="row">
			<div class="span12">
				<h2>Project Title</h2>
				<input type="text" id="project" name="project"/><br>
				<h3>Focus</h3>
				<textarea rows="2" id="focus" name="focus"  ></textarea><br>

				<div id="fields">
				</div>

				<button class="btn btn-primary" id="submit">Submit</button>

			</div>
		</div>
	</div>
</body>
</html>