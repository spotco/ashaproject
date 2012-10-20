<?php
function headerbar() {
?>
<style>
.nav > li {
	height:60px;
	float:right;
}
.nav > li > a {
	margin-top:20px;
	font-size:30px;
}
body {
	background-image:url("diamond.png");
}
.widget {
	background-color:white;
}
</style>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">

				<a class="brand" href="http://www.ashanet.org/">
					<div id="logo" style="float:left;margin-left:15px;">
						<img src="http://www.ashanet.org/graphics/asha_logo.png" style="height:60px;" alt="Asha for Education"/>
					</div>
				</a>
				
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li><a href="index.php">Home</a></li>
						<li><a href="submit.php">Submit</a></li>
						<li><a href="edit_list.php">Edit</a></li>
						<li><a href="webservice.php">Webservice</a></li>
						<li><a href="TESTING.html">Example</a></li>
					</ul>
				</div>
		</div>
	</div>
	<?php
}?>