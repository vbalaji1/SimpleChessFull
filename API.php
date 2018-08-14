<?php
    function getBoardURL(){

        $pieces = strtolower(explode("\n", file_get_contents("Viper/latest"))[0]);
        $pieces = substr($pieces, 0, strlen($pieces) - 1);
        $positions = strtolower(explode("\n", file_get_contents("Viper/latest"))[1]);
        $positions = substr($positions, 0, strlen($positions) - 1);

        $query_data = array(
            "pieces" => $pieces,
            "positions" => $positions
        );

        $board_url = 'http'.(empty($_SERVER['HTTPS'])? '':'s').'://'.$_SERVER['SERVER_NAME']. "/ChessBoard/GetBoard.php?" . http_build_query($query_data);
        if ($_GET["short_board_url"] == "true"){
            $board_url = "/ChessBoard/GetBoard.php?" . http_build_query($query_data);
        }
        return $board_url;
    }
    function getBoardIsBlank(){
        if (file_get_contents("Viper/latest") == ""){
            return "true";
        }
        else {
            return "false";
        }

    }
    function getTurn(){
        $pieces = strtolower(explode("\n", file_get_contents("Viper/latest"))[0]);
        $pieces = substr($pieces, 0, strlen($pieces) - 1);
        $positions = strtolower(explode("\n", file_get_contents("Viper/latest"))[1]);
        $positions = substr($positions, 0, strlen($positions) - 1);

        $pieces_arr = explode(';', $pieces);
        $last_piece = $pieces_arr[count($pieces_arr) - 1]; //last piece
        if (substr($last_piece, 0,1) == "w"){
            return "white";
        }
        else {
            return "black";
        }


    }

    function getMoves()
    {
        //get all moves in match so far
        return file_get_contents("Viper/latest");

    }
if ($_GET["q"] == "get_board_url"){
    echo getBoardURL();
}
elseif ($_GET["q"] == "board_is_blank"){
    echo getBoardIsBlank();
}
elseif ($_GET["q"] == "moves"){
    echo getMoves();
}
