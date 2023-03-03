<?php

echo "<html><body>\n";

function euros($dolares){
    return $dolares * 1.00;
}

$dolares = $_REQUEST["dolares"];
echo "$dolares en euros: ".euros($dolares)."€\n";

echo "</body></html>\n";

?>