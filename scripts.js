// We're starting at the first field of information
var currentSlide = "field0";
var currentProject = 0;
// Rotation time in milliseconds.
var timer = setInterval(nextProject, 1800000);


// When the page is ready, add click handlers and start ajax request.
$(function() {
	//Hide all projects except for the first
	$(".widget").hide();
	$($(".widget")[0]).show();

	//Attach click handlers
	$(".next").click(rotate);

	// Ajax request to pull data from database.
	$.get('jsout.php').done(successFunct).fail(ajaxFailure);
});

// Runs when the AJAX request was successful
function successFunct(data) {
	data = JSON.parse(data);
	console.log(data);
	$("#container").children().remove();

	for(var k = 0; k < data.array.length; k++ ) {

		//Build structure in container div
		
		var widget = $("<div style='overflow:hidden;width:350px;'>");
		widget.addClass("widget").appendTo("#container");
		var photoDiv = $("<div>");
		photoDiv.addClass("row-fluid").addClass("mainPhoto").appendTo(widget).attr({"style": "width: 350px;height: 200px;overflow: hidden;"});
		$("<img>").appendTo(photoDiv);
		$("<h2>").appendTo(widget);
		$("<p>").attr("class", "focus").appendTo(widget);
		var row = $("<div>").addClass("fluid-row").appendTo(widget);
		var left = $("<div>").addClass("left").appendTo(row);
	
		$("<div>").appendTo(left);


		var p1 = $("<p>");
		p1.addClass("previous");
		p1.html("Previous <span>&lt;&lt;</span>");
		p1.appendTo(left);
		p1.click(rotateBack);

		var paragraph = $("<p>");
		paragraph.addClass("next");
		paragraph.html("Next <span>&gt;&gt;</span>");
		paragraph.appendTo(left);
		paragraph.click(rotate);

		// Put in immediate information (name, focus paragraph, photo)
		$(widget.find("h2")).text(data.array[k].project_name);
		$(widget.find(".focus")).html("<strong>Focus:</strong> " + data.array[k].focus);
		var photoInfo;

		if (!data.array[k].img_url) {
			photoInfo = "http://placekitten.com/350/200";  // Adorable placeholder image, if use didn't upload one.
		} else {
			photoInfo = data.array[k].img_url;
		}

		var imageAndProperties = $(widget.find("img"));
		imageAndProperties.attr("src", photoInfo);
		var uglyString =  data.array[k].img_style;
		imageAndProperties.attr("style", uglyString);
		//Loop over all possible fields of information about project.
		var array = data.array[k].fields;
		for(var i = 0; i < data.array[k].fields.length; i++){
			var div = $("<div>").addClass("field" + i).appendTo(($(widget.find(".left > div")))).hide();
			var header3 = $("<h3>");
			header3.appendTo(div);
			header3.text(data.array[k].fields[i].name);
			if (i == 0) {
				div.show();
			}
			var innerDiv = $("<div>").appendTo(div);
			var ul = $("<ul>");
			ul.appendTo(innerDiv);

			//For each field, get each bulleted list item and put it into the page.
			for(var j = 0; j < array[i].details.length; j++) {
				$("<li>").text(array[i].details[j]).appendTo(ul);
			}
		}
	}

	$(".widget").hide();
	$($(".widget")[0]).show();
}

// Change "slides" of information going forward
function rotate(elem) {
	var widget = $(this).parent().parent().parent();
	var num = $(widget.find(".left > div > div")).length;
	$(widget.find("." + currentSlide)).hide();
	var current = parseInt(currentSlide[5]);
	current++;
	if(current > num - 1) {
		current = 0;
	}
	currentSlide = "field" + current;
	$(widget.find("." + currentSlide)).show();
}

// Change "slides" of information going backwards
function rotateBack(elem) {
	var widget = $(this).parent().parent().parent();
	var num = $(widget.find(".left > div > div")).length;
	$(widget.find("." + currentSlide)).hide();
	var current = parseInt(currentSlide[5]);
	current--;
	if(current < 0) {
		current = (num - 1);
	}
	currentSlide = "field" + current;
	$(widget.find("." + currentSlide)).show();
}


// provided Ajax failure code (displays a useful log when something goes
// wrong with the Ajax request)
function ajaxFailure(xhr, status, exception) {
  console.log(xhr, status, exception);
}


function nextProject() {
	var length = $(".widget").length;
	$($(".widget")[currentProject]).hide();
	currentProject++;
	if(currentProject > length - 1) {
		currentProject = 0;
	}
	$($(".widget")[currentProject]).show();
}