<html>
<body>
<?php
$nombre = $_REQUEST["nombre"];
$peso   = $_REQUEST["peso"];

echo "Producto $nombre, ";
if($peso <= 10){
    echo "Peso deficiente";
} else if($peso > 10 && $peso <= 20){
    echo "Peso normal";
} else if($peso > 20){
    echo "Peso excesivo";
}


?>

<body>
</html>