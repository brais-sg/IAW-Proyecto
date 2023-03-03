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

// Mostramos el form para eliminar vehiculos para venda
echo '
            <form action="eliminar_venda_accion.php" method="post" enctype="multipart/form-data" style="border: 1px solid black;">
                <p>Formulario para eliminar vehículos para venda</p>
                <br>
                Modelo: <input type="text" name="vehiculo" value=""><br>
                Cantidade: <input type="text" name="cantidade" value=""><br>
                <br>
                
                <input type="submit" value="Eliminar">
                <a href="menu_admin.php">Volver al menú</a>
            </form>
    ';



?>