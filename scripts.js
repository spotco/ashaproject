// We're starting at the first field of information
var currentSlide = "field0";

// When the page is ready, add click handlers and start ajax request.
$(function() {
	$(".next").click(rotate);
	// Ajax request to pull data from database.
	$.get('jsout.php').done(successFunct).fail(ajaxFailure);
});

// Runs when the AJAX request was successful
function successFunct(data) {
	// TEST CODE - please delete!
	var data = {"array": [{"img_url":"https://lh3.googleusercontent.com/-wFK3xleOSdo/T_gNnQSN5fI/AAAAAAAAARU/N8VVN2l0WSc/s480/trinita.jpg","img_style":"max-width: none; width: 350px; height: 263px; margin-left: 0px; margin-top: -48px;","fields":[{"field_name":"Field 1! ","details":["Detail 1","Detail 2","Detail 3"]},{"field_name":"Field 2","details":["Detail 1","Detail 2"]}],"project_name":"Project Title Of Awesome","focus":"Focus grouuup"}]}
	var	data2 = {"array": [
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
    ]};
	$("#container").children().remove();

	for(var k = 0; k < data.array.length; k++ ) {

		//Build structure in container div
		
		var widget = $("<div>");
		widget.addClass("widget").addClass("span4").appendTo("#container");
		var photoDiv = $("<div>");
		photoDiv.addClass("row-fluid").addClass("mainPhoto").appendTo(widget);
		$("<img>").appendTo(photoDiv);
		$("<h2>").appendTo(widget);
		$("<h3>").appendTo(widget);
		$("<p>").attr("class", "focus").appendTo(widget);
		var row = $("<div>").addClass("fluid-row").appendTo(widget);
		var left = $("<div>").addClass("left").appendTo(row);
		$("<div>").appendTo(left);
		var paragraph = $("<p>");
		paragraph.addClass("next");
		paragraph.html("Next <span>&gt;&gt;<span>");
		paragraph.appendTo(left);
		paragraph.click(rotate);

		// Put in immediate information (name, focus paragraph, photo)
		$(widget.find("h2")).text(data.array[k].project_name);
		$(widget.find(".focus")).text(data.array[k].focus);
		var photoInfo;

		if (!data.array[k].img_url) {
			photoInfo = "http://placekitten.com/350/200";  // Adorable placeholder image, if use didn't upload one.
		} else {
			photoInfo = data.array[k].img_url;
		}

		var imageAndProperties = $(widget.find("img"));
		imageAndProperties.attr("src", photoInfo);
		var uglyString =  data.array[k].img_style;
		var uglyString2 = uglyString.split(";");
		var final = "";
		for (var m = 0; m < uglyString2.length - 1; m++) {
			var old = imageAndProperties.attr("style");
			var valuePair = uglyString2[m].split(":");
			imageAndProperties.css({old + "," + valuePair[0] + ":" + valuePair[1]});
			//final += '"' + valuePair[0].trim() + "': '" + valuePair[1].trim() + "', ";
		}
		//final = final.substring(0, (final.length -2));
		//final = '{' + final + '}';
		//console.log(final);
		
		//console.log(imageAndProperties);
		//Loop over all possible fields of information about project.
		var array = data.array[k].fields;
		for(var i = 0; i < array.length; i++){
			var div = $("<div>").addClass("field" + i).appendTo(($(widget.find(".left > div")))).hide();
			if (i == 0) {
				div.show();
			}
			var h3 = $("<h3>");
			h3.text(array[i].field_name);
			h3.appendTo(div);
			var innerDiv = $("<div>").appendTo(div);
			var ul = $("<ul>");
			ul.appendTo(innerDiv);

			//For each field, get each bulleted list item and put it into the page.
			for(var j = 0; j < array[i].details.length; j++) {
				$("<li>").text(array[i].details[j]).appendTo(ul);
			}
		}
	}
}

// Change "slides" of information 
function rotate(elem) {
	var widget = $(this).parent().parent().parent();
	var num = $(widget.find(".left > div > div")).length;
	/*console.log(num);*/
	$(widget.find("." + currentSlide)).hide();
	var current = parseInt(currentSlide[5]);
	current++;
	if(current > num - 1) {
		current = 0;
	}
	currentSlide = "field" + current;
	$(widget.find("." + currentSlide)).show();
}

// provided Ajax failure code (displays a useful log when something goes
// wrong with the Ajax request)
function ajaxFailure(xhr, status, exception) {
  console.log(xhr, status, exception);
}