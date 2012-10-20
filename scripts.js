// We're starting at the first field of information
var currentSlide = "field1";
var width;
var height;

// When the page is ready, add click handlers and start ajax request.
$(function() {
	$("#next").click(rotate);
	// Ajax request to pull data from database.
	$.get("ashadb_insert.php", successFunct, "JSON")
		.done(successFunct);
});

// Runs when the AJAX request was successful
function successFunct(data) {
	// TEST CODE - please delete!
	if(!data) {
		data =  JSON.parse('{"fields":[{"field_name":"testing more stuff","details":["lolstuf","lolstufffffls cool"]},{"field_name":"so much stuff","details":["lkj sdoifj e"]}],"project_name":"lolwat","focus":"testing"}');
	}

	// Put in immediate information (name, focus paragraph, photo)
	$(".widget h2").text(data.project_name);
	$(".widget > p").text(data.focus);
	var photoInfo;
	if (!data.photo) {
		photoInfo = "http://placekitten.com/350/200";  // Adorable placeholder image, if use didn't upload one.
	} else {
		photoInfo = data.photo;
	}
	$(".widget img").attr("src", photoInfo);

	//Loop over all possible fields of information about project.
	var array = data.fields;
	console.log(array.length);
	for(var i = 1; i <= array.length; i++){
		var div = $("<div>").addClass("field" + i).appendTo(($(".widget .left > div"))).hide();
		if (i == 1) {
			div.show();
		}
		var h3 = $("<h3>");
		h3.text(array[(i - 1)].name)
		h3.appendTo(div);
		var innerDiv = $("<div>").appendTo(div);
		$("<ul>").appendTo(innerDiv);
		var detailsArray = array[(i - 1)].details;

		//For each field, get each bulleted list item and put it into the page.
		console.log(detailsArray.length);
		for(var j = 0; j < detailsArray.length; j++) {
			$("<li>").text(detailsArray[j]).appendTo($(".widget ul"));
		}
	}
}

// Change "slides" of information 
function rotate() {
	var num = $(".widget .left > div > div").length
	$("." + currentSlide).hide();
	var current = parseInt(currentSlide[5]);
	current++;
	if(current > num) {
		current = 1;
	}
	currentSlide = "field" + current;
	$("." + currentSlide).show();
}