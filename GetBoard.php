<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
    if ($_GET['img'] == "true"){
        header("Content-Type: image/png");
        header("Content-Disposition: inline; filename=tmp.png");
        $query_data = array("positions" => $_GET["positions"], "pieces" => $_GET["pieces"]);
        $send_url = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['SERVER_NAME'].parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) . "?" . http_build_query($query_data);
        Browsershot::url($send_url)->windowSize(520,565)->save("tmp.png");
        fpassthru(fopen('tmp.png', 'rb'));
        die();
    }

?>

<!DOCTYPE html>
<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Josefin+Sans');
        .black {
            background-color: sandybrown;
            width:62.5px;
            height:62.5px;
        }
        .white {
            background-color: white;
            width:62.5px;
            height:62.5px;
        }
        #chessboard {
            border: 1px solid black;
            width:500px;
            height: 500px;
        }
        th.title {
            font-family: 'Josefin Sans', "Fira Sans", sans-serif;
            padding: 2px;
        }
        .chesspiece {
            width:62.5px;
            height:62.5px;
        }
        body {
            width:500px;
            height:500px;
        }
        #chessboardHeader p{
            display:inline
        }
    </style>
</head>
<body>

<table>

    <tbody id="chessboard">
        <?php
        $pieces = explode(";", strtolower($_GET['pieces']));
        $positions = explode(";",strtolower($_GET['positions']));

        $pc_pos_map = array_combine($positions, $pieces);
        /*
                echo $pieces."<br>";
                echo $positions;*/

        $map_int_to_letter = array(
            "1" => "a",
            "2" => "b",
            "3" => "c",
            "4" => "d",
            "5" => "e",
            "6" => "f",
            "7" => "g",
            "8" => "h",
        );

        for ($i = 1; $i < 9; $i++){
            echo "<tr>";
            for ($j = 1; $j < 9; $j++) {
                $id = (string) $map_int_to_letter[$j] .strval(9 - $i) ;
                $show_piece = false;
                $piece_show = false;
                if (isset($pc_pos_map[$id])){
                    $piece_show = $pc_pos_map[$id];
                }

                if ($j == 1){
                    $num = 9 - $i;
                    echo "<th class='title'>$num</th>";
                }
                if ($i % 2 == 0){
                    if ($j % 2 == 0){
                        echo "<td class='white' id='$id'><img class='chesspiece' src='chesspieces/$piece_show.ico' alt='' /></td>";

                    }
                    else {
                        echo "<td class='black' id='$id'><img class='chesspiece' src='chesspieces/$piece_show.ico' alt='' /></td>";
                    }
                }
                elseif ($i % 2 == 1){
                    if ($j % 2 == 1){
                        echo "<td class='white' id='$id'><img class='chesspiece' src='chesspieces/$piece_show.ico' alt='' /></td>";
                    }
                    else {
                        echo "<td class='black' id='$id'><img class='chesspiece' src='chesspieces/$piece_show.ico' alt='' /></td>";
                    }
                }

            }
            echo "</tr>";
        }
        ?>
    </tbody>
    <tfoot id="chessboardHeader">
        <th class="title"></th>
        <th class="title">a</th>
        <th class="title">b</th>
        <th class="title">c</th>
        <th class="title">d</th>
        <th class="title">e</th>
        <th class="title">f</th>
        <th class="title">g</th>
        <th class="title">h</th>
    </tfoot>

</table>







<script>
    /*function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
                tmp = item.split("=");
                if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;
    }
    function populateBoard(){
        positions = findGetParameter("positions").split(";");
        pieces = findGetParameter("pieces").split(";");
        for (var i = 0; i < pieces.length; i++){
            document.getElementById(positions[i]).innerHTML = "<img class='chesspiece' src='chesspieces/" + pieces[i] + ".ico' alt='" + pieces[i] + "' />";
        }
    }*/

</script>
</body>
</html>
