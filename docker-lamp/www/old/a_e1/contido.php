<?php

$n1 = $_REQUEST["valor1"];
$n2 = $_REQUEST["valor2"];
$n3 = $_REQUEST["valor3"];

$fd = fopen("/var/www/html/datosExercicio.txt","w");

fprintf($fd,"%s\n", $n1);
fprintf($fd,"%s\n", $n2);
fprintf($fd,"%s\n", $n3);

fflush($fd);
fclose($fd);

echo "<h1>Números guardados</h1>";
?>