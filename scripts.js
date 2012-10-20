var currentSlide = "field1";

$(function() {
	$("#next").click(rotate);
	// Ajax request to pull data from database.
	$.get() {
		url: "ashadb_insert.php",
		success: successFunct, 
		dataType: "JSON"
	}
});

function successFunct(data) {
	$(".widget h1").text(data.project_name);
	$(".widget > p").text(data.focus);
	$(".widget img").attr("src", data.photo);
	var array = data.fields;
	for(var i = 0; i < array.length; i++){
		$(".widget h2").text(array[i].name);
		var detailsArray = array[i].details;
		$(".widget ul").children().remove();
		for(var j = 0; j < detailsArray.length; i++) {
			$("li").text(detailsArray[j]).appendTo($(".widget ul"));
		}
	}
}

function rotate() {
	$("." + currentSlide).hide();
	var current = parseInt(currentSlide[5]);
	current++;
	if(current > 4) {
		current = 1;
	}
	currentSlide = "field" + current;
	$("." + currentSlide).show();
}
