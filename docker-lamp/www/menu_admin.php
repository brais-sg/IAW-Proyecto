<?php
session_start();

// Si la sesión no está iniciada (alguien acabó aquí sin pasar por el login, o expiró), lo redireccionamos a la página principal
if(!isset($_SESSION["user"])){
    header("Location: index.html", TRUE, 301);
    die();
}

// Mostramos el menú principal

echo "<div align=\"right\">";
echo "Hola <b>".$_SESSION["user"]."</b> [Como administrador]";
echo " <a href=\"salir.php\">Pechar sesión</a>";
echo "</div>";
echo "<hr>";

/*
echo "<div class=\'menu\'>\n";
echo "<h2>Menú de administrador</h2>";
echo "<input type=\"button\" onclick=\"location.href='listar_admitir.php'\" value=\"Admitir novos usuarios\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='introducir_aluguer.php'\" value=\"Introducir novos vehículos de aluguer\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='introducir_venda.php'\" value=\"Introducir novos vehículos para venda\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='eliminar_aluguer.php'\" value=\"Eliminar vehiculos para aluguer\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='eliminar_venda.php'\" value=\"Eliminar vehiculos para venda\">";
echo "<br><br>";

echo "<input type=\"button\" onclick=\"location.href='modifica_aluguer.php'\" value=\"Modificar vehiculos para aluguer\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='modifica_venda.php'\" value=\"Modificar vehiculos para venda\">";
echo "<br><br>";

echo "<input type=\"button\" onclick=\"location.href='informe_alugar.php'\" value=\"Informe de vehiculos para alugar\">";
echo "<br><br>";
echo "<input type=\"button\" onclick=\"location.href='informe_venda.php'\" value=\"Informe de vehiculos para venda\">";
echo "<br><br>";

echo "<input type=\"button\" onclick=\"location.href='devoltos_a_aluguer.php'\" value=\"Pasar vehiculos devoltos a aluguer\">";
echo "<br><br>";
*/

// Menú con submits
echo "<div class='menu'>\n";
echo "<h2>Menú principal</h2>";
echo "<form action='listar_admitir.php' method='get'><input type='submit' value='Admitir novos usuarios'></form>";
echo "<form action='introducir_aluguer.php' method='get'><input type='submit' value='Introducir novos vehículos de aluguer'></form>";
echo "<form action='introducir_venda.php' method='get'><input type='submit' value='Introducir novos vehículos para venda'></form>";
echo "<form action='eliminar_aluguer.php' method='get'><input type='submit' value='Eliminar vehiculos para aluguer'></form>";
echo "<form action='eliminar_venda.php' method='get'><input type='submit' value='Eliminar vehiculos para venda'></form>";

echo "<form action='modifica_aluguer.php' method='get'><input type='submit' value='Modificar vehiculos para aluguer'></form>";
echo "<form action='modifica_venda.php' method='get'><input type='submit' value='Modificar vehiculos para venda'></form>";

echo "<form action='informe_alugar.php' method='get'><input type='submit' value='Informe de vehiculos para alugar'></form>";
echo "<form action='informe_venda.php' method='get'><input type='submit' value='Informe de vehiculos para venda'></form>";

echo "<form action='devoltos_a_aluguer.php' method='get'><input type='submit' value='Pasar vehiculos devoltos a aluguer'></form>";
echo "</div>";



echo "</div>\n";


?>