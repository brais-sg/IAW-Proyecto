<?php
session_start();

// Si la sesión no está iniciada (alguien acabó aquí sin pasar por el login, o expiró), lo redireccionamos a la página principal
if(!isset($_SESSION["user"])){
    header("Location: index.html", TRUE, 301);
    die();
}

// Mostramos el menú principal

echo "<div align=\"right\">";
echo "Hola <b>".$_SESSION["user"]."</b>";
echo " <a href=\"salir.php\">Pechar sesión</a>";
echo " <a href=\"modificar.php\">Modificar os meus datos</a>";
echo "</div>";
echo "<hr>";

// Mostramos opciones de vehículos en alquiler o venta
echo "<div class=\'menu\'>\n";
echo "<h2>Menú principal</h2>";
echo "<input type=\"button\" onclick=\"location.href='sololista_aluguer.php'\" value=\"Listar vehículos en aluguer\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='sololista_venda.php'\" value=\"Listar vehículos en venda\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='lista_aluguer.php'\" value=\"Mostrar vehículos en aluguer\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='lista_venda.php'\" value=\"Mostrar vehículos en venda\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='devolver.php'\" value=\"Devolver un vehículo alugado\">";
echo "</div>\n";


// Menu pero con submit
echo "<div class='menu'>\n";
echo "<h2>Menú principal</h2>";
echo "";



?>