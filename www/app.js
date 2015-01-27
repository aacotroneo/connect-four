/**
 * Created by Alejandro on 26/01/2015.
 */


//disclaimer: I dont have anything handy to make this tidy.. I wish I could make some angular (know the basics), but I'm so late.
//So here is just the code :(


// A $( document ).ready() block.
$(document).ready(function ()
{
	console.log("ready!");

	//refresh board via ajax
	refreshBoard();

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
					if (result['success'] == 'yes') {
						var player = result['player'];
						var column = result['column'];
						var row = result['row'];
						var newValue = getDiscForPlayer(player);

						placeDisc(player, column, row, newValue);
					} else {
						alert("You cant make that move");
					}

				},
				error: function (result)
				{
					alert("There was an error: " + result.error);
				}

			}
		);

	});

	function refreshBoard()
	{
		var baseUrl = getBaseUrl();

		if(baseUrl.indexOf("/games") <= -1) return; //main page

		var serviceUrl = baseUrl + "/board";

		$.ajax({
				url: serviceUrl ,
				type: 'POST',
				dataType: 'json',
				success: function (result)
				{

					if (result['success'] == 'yes') {
						var board = result['board'];

						$.each( board, function( row_ix, row_data ) {

							$.each( row_data, function( col_ix, cell ) {

								placeDisc(cell, col_ix, row_ix, getDiscForPlayer(cell));
							});

						});
					} else {
						alert("Unkown error");
					}

				},
				error: function (result)
				{
					alert("There was an error" + result.error)
				}

			}
		);
	}




	function placeDisc(player, column, row, value)
	{

		//disc-hole-{{ key_row }}-{{ key_cell }}
		var hole_id = '#disc-hole-' + row + "-" + column;
		$(hole_id).html(value);
		console.log('disc successfully placed from ' + player + ' in column ' + column)

	}

	function getDiscForPlayer(player){
		if(player == 1){
			return "(1)"
		} else if(player == 2){
			return "(2)";
		}else return "( )";
	}

	function getBaseUrl()
	{
		var getUrl = window.location;
		var baseUrl = getUrl.protocol + "//" + getUrl.host + getUrl.pathname;
		return baseUrl;
	}

});


