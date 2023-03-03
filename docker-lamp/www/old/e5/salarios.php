<html>
<head>
    <title>Ejercicio 5 - Salarios</title>
</head>
<body>
<?php

$salario_hora = 10.5;

function calcsalario($horas, $dias){
    global $salario_hora;
    return $horas * $dias * $salario_hora;
}

function neto($bruto){
    return $bruto - ($bruto * .12);
}

$horas = $_REQUEST["horas"];
$dias  = $_REQUEST["dias"];

$bruto = calcsalario($horas, $dias);

echo "Tu salario neto es de ".neto($bruto)."€";

?>
</body>

</html>