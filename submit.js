var arrayOfDefaults = ["Sustainability / Future Vision", "Ongoing Work", "Strength / Success Stories", "Challenges"];


/**
Activates/manages image loader+crop tool
**/
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



		//console.log("Loading:"+$("#imgurl").val());

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

	

	

$(function(){

	image_loader();

	

	var firstcombo = makecombo();

	var addfield = $('<a style="margin-left:20px;">(Add Another Field)</a>');

	firstcombo.find(".enterfield").after(addfield);

	

	var self = function(){

		var addfield = $('<a style="margin-left:20px;">(Add Another Field)</a>');

		var delfield = $('<a style="margin-left:20px;" >(Delete Field)</a>');

		var new_field = makecombo();

		new_field.find(".enterfield").after(delfield);

		new_field.find(".enterfield").after(addfield);

		$("#fields").append(new_field);

		delfield.click(function() {

			new_field.hide(250,function(){new_field.remove()});

		});	

		addfield.click(self);

		

		var position = new_field.position();

		//scroll(0,position.top);

		$("html,body").animate({

			scrollTop:new_field.offset().top

		},250);

	}

	addfield.click(self);

	$("#fields").append(firstcombo);

	$("#submit").click(function() {

		var output = {};

		output.video = $("#video").val();

		output.img_url = $("#imgurl").val();

		output.img_style = $("#preview").attr("style");



		output.fields = [];

		output.project_name = $("#project").val();

		output.focus = $("#focus").val();



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

		$.post("ashadb_insert.php",{output:jason},function(r) {

			//console.log(r);

		});

		//console.log(jason);

		alert("Submission successful!");

		window.location = "index.php";

		$("input, textarea").val("");



	})

})



function makecombo() {

	var newcombo = $("<div class='fieldcombo'><hr /></div>");

	newcombo.append($('<h4>Field:</h4><input class="enterfield" type="text" name="field" />'));

	var adddetail = $('<a style="margin-left:25px;">(Add Another Detail)</a>');

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

		//var position = new_detail.position();

		//scroll(0,position.top);

		$("html,body").animate({

			scrollTop:new_detail.offset().top

		},250);

	});

	return newcombo;

}



function get_detail() {

	var li = $("<li>");

	li.append($('<h5>Details</h5>'));

	li.append($('<textarea cols="10" rows="2" class="detailfield"></textarea>'));

	return li;

}

