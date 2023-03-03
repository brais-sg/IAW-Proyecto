<?php

echo "<html><body>\n";


$name = $_REQUEST["nombre"];
if($name == null){
    echo "Erro a introducir os datos. Faltan datos!";
} else {
    echo "Hola, o teu nome e: $name";
}

echo "</body></html>\n";

?>