/**
 * Created by Alejandro on 26/01/2015.
 */


//disclaimer: I dont have anything handy to make this tidy.. I wish I could make some angular (know the basics), but I'm so late.
//So here is just the code :(


// A $( document ).ready() block.
$(document).ready(function ()
{
	console.log("ready!");

	$(".game-btn").click(function ()
	{


		var location = $(this).attr("data-column");

		var baseUrl = getBaseUrl();

		var serviceUrl = baseUrl + "/put/" + location;

		$.ajax({
				url: serviceUrl,
				type: 'POST',
				dataType: 'json',
				success: function (result)
				{
					if( result['success'] == 'yes') {
						var player = result['player'];
						var column = result['column'];
						placeDisc(player, column)
					}else {
						alert("You cant make that move");
					}

				},
				error: function (result)
				{
					alert("There was an error")
				}

			}
		);

	});

	function placeDisc(player, column){

		alert('disc successfully added from ' + player + ' in column ' + column)

	}

	function getBaseUrl()
	{
		var getUrl = window.location;
		var baseUrl = getUrl.protocol + "//" + getUrl.host + getUrl.pathname;
		return baseUrl;
	}

});


