<?php

echo "<html><body>\n";

function add($n1, $n2){
    return $n1 + $n2;
}

function sub($n1, $n2){
    return $n1 - $n2;
}

function mul($n1, $n2){
    return $n1 * $n2;
}

function div($n1, $n2){
    return $n1 / $n2;
}

function mod($n1, $n2){
    return $n1 % $n2;
}

$n1 = $_REQUEST["valor1"];
$n2 = $_REQUEST["valor2"];

echo "</br>Suma: ". add($n1, $n2);
echo "</br>Resta: ". sub($n1, $n2);
echo "</br>Multiplicación: ". mul($n1, $n2);
echo "</br>División: ". div($n1, $n2);
echo "</br>Resto: ". mod($n1, $n2);


echo "\n</body></html>";


?>