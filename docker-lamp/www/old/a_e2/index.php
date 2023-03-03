<?php

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

$sumaTotal = obtenerSuma("numeros.txt");
echo $sumaTotal;


?>