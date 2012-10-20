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
		data =  JSON.parse('{
    "array": [
        {
            "fields": [
                {
                    "field_name": "testing more stuff",
                    "details": [
                        "lolstuf",
                        "lolstufffffls cool"
                    ]
                },
                {
                    "field_name": "so much stuff",
                    "details": [
                        "lkj sdoifj e"
                    ]
                }
            ],
            "project_name": "lolwat",
            "focus": "testing"
        },
        {
            "fields": [
                {
                    "field_name": "stuff2",
                    "details": [
                        "hello",
                        "cats"
                    ]
                },
                {
                    "field_name": "om nom",
                    "details": [
                        "step 1"
                    ]
                }
            ],
            "project_name": "foo",
            "focus": "bar"
        }
    ]
}');
	}

	for(var k = 0; k < data.array.length; k++ ) {

		//Build structure in container div
		$(".container").children().remove();
		var widget = $("<div>").addClass("widget").addClass("span4").appendTo(".container");
		var photoDiv = $("<div>").addClass("row-fluid").addClass("mainPhoto").appendTo(widget);
		$("<img>").appendTo(photoDiv);
		$("<h2>").appendTo(widget);
		$("<h3>").appendTo(widget);
		$("<p>").appendTo(widget);
		var row = $("<div>").addClass("fluid-row").appendTo(widget);
		var left = $("<div>").addClass("left").appendTo(row);
		$("<div>").appendTo(left);
		$("<p>").attr("id", "next").text("Next <span>&gt;&gt;<span>").appendTo(left);


		// Put in immediate information (name, focus paragraph, photo)
		$(".widget h2").text(data.array[k].project_name);
		$(".widget > p").text(data.array[k].focus);
		var photoInfo;
		if (!data.array[k].photo) {
			photoInfo = "http://placekitten.com/350/200";  // Adorable placeholder image, if use didn't upload one.
		} else {
			photoInfo = data.array[k].photo;
		}
		$(".widget img").attr("src", photoInfo);

		//Loop over all possible fields of information about project.
		var array = data.array[k].fields;
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