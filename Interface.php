<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Josefin+Sans');
        .title {
            font-family: 'Josefin Sans', "Fira Sans", sans-serif;
            padding: 2px;
        }
        #chessBoard {
            background-color: lightgrey;
            width:600px;
            height: 600px;
            border-radius: 5px;
        }
        #chessBoard .center {
            font-family: 'Josefin Sans', "Fira Sans", sans-serif;
            text-align:center;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }
        .header {
           color: #6ca2ee;
        }
    </style>
</head>
<body>
<div class="header">
    <h1 class="title">
        ViperUI
    </h1>
</div>

    <div id="chessBoard">
        <div class="center">
            <img src="load.gif" />
            <p id="status">Loading....</p>
        </div>
    </div>
    <div id="debugBoardData">

    </div>

    <div id="statusMove"></div>
    <div id="movesList">

    </div>

    <script>
        var pre_b_url = "";
        var pre_moves = "";
        var moves_pieces = [];
        var moves_positions = [];
        var first = true;
        window.blank = true;

        window.setInterval(function(){
            populateBoard();
        }, 1000);
        function populateBoard(){
            boardIsBlank();

            if (window.blank){
                $("#chessBoard").css("background-color", "#ffc494");
                $("#status").text("Waiting for user to start Viper...");

            }
            else {
                $.get("/ChessBoard/API.php?q=get_board_url&short_board_url=true", function(boardurl, status){
                    //console.log("GET boardurl, next check: "+ boardurl);



                    if (status === "success" && (pre_b_url !== boardurl || first)){
                        first = false;
                        pre_b_url = boardurl;
                        $.get(boardurl, function(tabledata, status){
                            if (status === "success"){
                                //writeOnMove();
                                writeMoves();
                                $("#chessBoard").html(tabledata);
                                $("#chessBoard").css("background-color", "transparent");

                            }

                        })
                    }
                });
            }


        }
        function boardIsBlank(){
            $.get("/ChessBoard/API.php?q=board_is_blank", function(isBlank, status){
                //console.log("got board is blank as " + isBlank);
                if (isBlank === "false"){
                    window.blank = false;
                }

            });


        }
        function writeOnMove(){
            $.get("/ChessBoard/API.php?q=on_color_move", function(piece_color, status){
                console.log("on piece: " + piece_color);
                if (piece_color === "black"){
                    $("#statusMove").html("<p class='title'>Black is thinking...</p>");

                }
                else {
                    $("#statusMove").html("<p class='title'>White is thinking...</p>");
                }
            })
        }
        function writeMoves(){
            $.get("/ChessBoard/API.php?q=moves", function(moves, status){
                //console.log(moves);
                if (pre_moves === ""){
                    pre_moves = moves;
                }
                else {
                    //get lists of moves
                    var pre_pieces = pre_moves.split("\n")[0].split(';');
                    var pre_positions = pre_moves.split("\n")[1].split(';');

                    var new_pieces = moves.split("\n")[0].split(";");
                    var new_positions = moves.split("\n")[1].split(";");

                    for (var i = 0; i < pre_pieces.length; i++){
                        if (pre_pieces[i] !== new_pieces[i]){
                            moves_pieces.push(pre_pieces[i]);
                            moves_positions.push(pre_pieces[i]);
                        }
                    }
                    console.log(moves_pieces);
                    console.log(moves_positions);

                    pre_moves = moves;

                }

            })
        }
    </script>
</body>
</html>

