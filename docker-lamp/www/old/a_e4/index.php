<?php

function escribirTresNumeros($nombreFichero){
    $fd = fopen($nombreFichero,"w");

    fprintf($fd,"2\n8\n14\n");

    fflush($fd);
    fclose($fd);
}


function obtenerArray($nombreArchivo){
    $array = array();

    $fd = fopen($nombreArchivo, "r");
    while(!feof($fd)){
        $array[] = fgets($fd);
    }

    fclose($fd);
    return $array;
}

function obtenerSuma($nombreArchivo){
    $suma = 0;

    $fd = fopen($nombreArchivo, "r");
    while(!feof($fd)){
        $linea = fgets($fd);
        $suma += $linea;
    }

    fclose($fd);
    return $suma;
}

escribirTresNumeros("/var/www/html/numeros.txt");
$suma  = obtenerSuma("/var/www/html/numeros.txt");
$array = obtenerArray("/var/www/html/numeros.txt");

echo "<h1>A suma é: $suma</h1>";

foreach($array as $k => $v){
    echo "$k: $v<br/>";
}

?>