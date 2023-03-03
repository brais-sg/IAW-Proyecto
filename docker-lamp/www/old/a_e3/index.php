<?php

function obtenerArray($nombreArchivo){
    $array = array();

    $fd = fopen($nombreArchivo, "r");
    while(!feof($fd)){
        $array[] = fgets($fd);
    }

    fclose($fd);
    return $array;
}

$arrayFinal = obtenerArray("valores.txt");

foreach($arrayFinal as $k => $v){
    echo "$k: $v<br/>";
}

?>