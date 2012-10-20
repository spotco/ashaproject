<? include ("common.php"); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Project Upload/Edit</title>
		<script src="jquery.js"></script>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="jcrop/js/jquery.Jcrop.min.js"></script>
		<link href="jcrop/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
		<script src="submit.js"></script>
		<link href="submit.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<? headerbar(); ?>
		
		<div class="container">
			<h1>Project Upload</h1>
			<hr />
			<div class="row">
				<div class="span10">
					<h2>Project Title</h2>
					<input type="text" id="project" name="project"/><br>
					<h3>Focus</h3>
					<textarea rows="2" id="focus" name="focus"  ></textarea><br>

					<div id="fields">
					</div>

					<button class="btn btn-primary" id="submit">Submit</button>
				</div>
				<div class="span2">

					<h3>YouTube Video (Optional)</h3>
					<p>Please include the URL to the YouTube video (Be sure it's the embedded URL!)</p>
					<input type="text" size="7" id="video" name="video" />

					<h3>Image URL(Optional)</h3>
					<p>Click load, then drag to crop image</p>
					<input type="text" size="7" id="imgurl" name="imgurl"/>
					<button class="btn" id="loadimg">Load</button>
					<br />
					<br id="jcrop_add" />
					<img class="jcrop_target" src="" />
					<br />
					<br />
					<div>
						<img id="preview" src="" />
					</div>
					
				</div>
			</div>
		</div>
	</body>
</html>