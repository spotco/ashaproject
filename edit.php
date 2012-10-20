<?php

if (!isset($_REQUEST["id"]) || !is_numeric($_REQUEST["id"])) {
	die("set url param (id) = (target id)");
}

$target_id = $_REQUEST["id"];
$store = true;
include("jsout.php");
?>

<script>
var input = <?=$store?>;

for(var i = 0; i < input.array.length; i++) {
	if (input.array[i].p_id == <?=$target_id?>) {
		input = input.array[i];
		break;
	}
}
console.log(input);
</script>

<!DOCTYPE html>
<html>
<head>
	<title>Project Upload/Edit</title>
	<script src="jquery.js"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="jcrop/js/jquery.Jcrop.min.js"></script>
	<link href="jcrop/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
.fieldcombo {
	margin-bottom: 50px;
	margin-top: 50px;
}
.enterfield,#project  {
	font-size: 30px !important;
	height:50px !important;
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
.container {
	background-color: white;
	padding: 10em;
	box-shadow: 0px 0px 20px #888888;
}

	</style>
	<script>
var NOSCROLL = false;
$(function(){
	image_loader();

	NOSCROLL = true;
	$("#project").val(input.project_name);
	$("#focus").val(input.focus);
	input.fields.forEach(function(i){
		var nfield = make_field();
		nfield.find(".enterfield").val(i.name);
		$("#fields").append(nfield);

		nfield.find("li").remove();

		i.details.forEach(function(i){
			$(".adddetailclick").click();
			nfield.find(".detailfield").last().val(i);
		});
	});
	$("#imgurl").val(input.img_url);
	$("#loadimg").click();
	$(".fieldcombo li").each(function(i,e){
		e = $(e);
		if (e.find(".detailfield").val() == "") {
			e.remove();
		}
	})
	$("#video").val(input.video);
	NOSCROLL = false;

	$("#submit").click(serialize_and_submit);

});

function image_loader() {
	var TAR_WID = 350;
	var TAR_HEI = 200;

	var showPreview = function(coords){
		var rx = TAR_WID / coords.w;
		var ry = TAR_HEI / coords.h;
		var IMG_HEI = parseInt($(".jcrop-holder").css("height"));
		var IMG_WID = parseInt($(".jcrop-holder").css("width"));
		//console.log(IMG_WID+","+IMG_HEI);
		$('#preview').css({
			width: Math.round(rx * IMG_WID) + 'px',
			height: Math.round(ry * IMG_HEI) + 'px',
			marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			marginTop: '-' + Math.round(ry * coords.y) + 'px'
		});
	}

	$("#loadimg").click(function() {
		$(".jcrop-holder").remove();

		$(".jcrop_target").remove();
		$("#jcrop_add").after($('<img class="jcrop_target" src="" />'));

		console.log("Loading:"+$("#imgurl").val());
		var url = $("#imgurl").val();
		$(".jcrop_target").attr({"src":url});
		$(".jcrop_target").load(function() {
			$("#preview").attr({"src":url});
			$('.jcrop_target').Jcrop({
				onChange: showPreview,
				onSelect: showPreview,
				aspectRatio: TAR_WID/TAR_HEI
			});
		});
		
	});
}


function serialize_and_submit() {
	var output = {};

	output.img_url = $("#imgurl").val();
	output.img_style = $("#preview").attr("style");

	output.fields = [];
	output.project_name = $("#project").val();
	output.focus = $("#focus").val();
	output.video = $("#video").val();

	$("#fields > .fieldcombo").each(function(index,e) {
		e = $(e);
		var field = {};
		field.field_name =e.find(".enterfield").val();
		field.details = [];
		e.find(".detailfield").each(function(index,e) {
			e = $(e);
			field.details.push(e.val());
		});
		output.fields.push(field);
	})

	var jason = JSON.stringify(output);
	$.post("update.php",{output:jason,p_id:<?=$target_id?>},function(r) {
		console.log(r);
		alert("edits saved!");
	});
	console.log(jason);

}

function make_field(){
	var addfield = $('<a style="margin-left:20px;">(Add Another Field)</a>');
	var delfield = $('<a style="margin-left:20px;" >(Delete Field)</a>');
	var new_field = makecombo();
	new_field.find(".enterfield").after(delfield);
	new_field.find(".enterfield").after(addfield);
	
	delfield.click(function() {
		new_field.hide(250,function(){new_field.remove()});
	});	
	addfield.click(function() {
		var t = make_field();
		$("#fields").append(t);
		t.on_append();
	});
	

	new_field.on_append = function() {
		var position = new_field.position();
		//scroll(0,position.top);
		if (!NOSCROLL) {
			$("html,body").animate({
				scrollTop:new_field.offset().top
			},250);
		}
	}

	return new_field;
}


function makecombo() {
	var newcombo = $("<div class='fieldcombo'><hr /></div>");
	newcombo.append($('<h4>Field:</h4><input class="enterfield" type="text" name="field" />'));
	var adddetail = $('<a class="adddetailclick" style="margin-left:25px;">(Add Another Detail)</a>');
	var list = $("<ul>");
	var detail = get_detail();
	list.append(detail);
	newcombo.append(list);
	newcombo.append(adddetail);
	adddetail.click(function(){
		var deldetail = $('<a style="margin-left:20px; vertical-align:-70%;" >(Delete Detail)</a>');
		var new_detail = get_detail();
		new_detail.append(deldetail);
		list.append(new_detail);
		deldetail.click(function() {
			new_detail.hide(250,function(){new_detail.remove()});
		});
		if (!NOSCROLL) {
			$("html,body").animate({
				scrollTop:new_detail.offset().top
			},250);
		}
	});
	return newcombo;
}

function get_detail() {
	var li = $("<li>");
	li.append($('<h5>Details</h5>'));
	li.append($('<textarea cols="10" rows="2" class="detailfield"></textarea>'));
	return li;
}


	</script>
	<script>

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
		<h1>Project Edit</h1>
		<hr />
		<div class="row" style="margin-bottom:50px;">
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
				<button style="margin-top:-10px" class="btn" id="loadimg">Load</button>
				<br />
				<br id="jcrop_add" />
				<img class="jcrop_target" src="" />
				<br />
				<br />
				<div style="width:350px;height:200px;overflow:hidden;">
					<img id="preview" style="max-width:none;" src="" />
				</div>
			</div>
		</div>
	</div>
</body>
</html>