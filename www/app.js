var backend_server = "ws://localhost:9000";
var conn;

var player_id;

// A $( document ).ready() block.
$(document).ready(function () {
    console.log("ready!");


    $(".game-btn").click(function () {

            var location = $(this).attr("data-column");

            //we send our player id - we should send credentials and store this in the server
            sendMessage({'action': 'move', 'column': location, 'player': player_id});
        }
    );

    $(".refresh").click(function () {

            sendMessage({'action': 'get_board', 'player': player_id});
        }
    );

    player_id = getPlayerId();

    connect();

    function connect() {
        conn = new WebSocket(backend_server);
        conn.onopen = function (e) {
            console.log("Connection established!");

            sendMessage({'action': 'get_board', 'player': player_id});

        };

        conn.onmessage = function (e) {
            console.log(e.data);
            var msge = JSON.parse(e.data);

            if (msge.error) {
                alert(msge.error);
                return;
            }

            var action = msge.action;


            switch (action) {
                case 'init':
                    receiveInit(msge.data);
                    break;
                case 'get_board':
                    receiveBoard(msge.data);
                    break;
                case 'move':
                    receiveMove(msge.data);
                    break;
            }

        };

    }

    function receiveInit(data) {
        console.log("connceted to server. Game on!");
        console.log(data);
    }

    function receiveBoard(board) {

        $.each(board, function (row_ix, row_data) {

            $.each(row_data, function (col_ix, cell) {

                placeDisc(cell, col_ix, row_ix, getDiscForPlayer(cell));
            });

        });

    }

    function receiveMove(data) {
        var newValue = getDiscForPlayer(data.player);

        placeDisc(data.player, data.column, data.row, newValue);

    }


    function placeDisc(player, column, row, value) {

        //disc-hole-{{ key_row }}-{{ key_cell }}
        var hole_id = '#disc-hole-' + row + "-" + column;
        $(hole_id).html(value);
        console.log('disc successfully placed from ' + player + ' in column ' + column)

    }

    function getDiscForPlayer(player) {
        if (player == 1) {
            return "(1)"
        } else if (player == 2) {
            return "(2)";
        } else return "( )";
    }

    function sendMessage(message) {
        conn.send(JSON.stringify(message));

    }

    function getPlayerId() {
        //get this from server based on credentials - here is the url
        var path = window.location.pathname.split('/');
        return path[path.length - 1];
    }


});







