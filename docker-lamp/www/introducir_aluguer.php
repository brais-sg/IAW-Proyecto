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
echo " <a href=\"modificar.php\">Modificar os meus datos</a>";
echo "</div>";
echo "<hr>";

// Formulario de insercción de vehículo 
echo "
    <form action=\"introducir_aluguer_accion.php\" method=\"post\" enctype=\"multipart/form-data\" style=\"border: 1px solid black;\">
    <div>
    <p>Introduce os datos do novo vehículo de aluguer:</p>
        Modelo: <input type=\"text\" name=\"modelo_aluguer\"><br>
        Cantidade: <input type=\"text\" name=\"cantidade_aluguer\"><br>
        Descricion: <input type=\"text\" name=\"descricion_aluguer\"><br>
        Marca: <input type=\"text\" name=\"marca_aluguer\"><br>
        Prezo: <input type=\"text\" name=\"prezo_aluguer\"><br>
        Foto:  <input type=\"text\" name=\"foto_aluguer\"><br>
    </div>
    <br>
    <input type=\"submit\" value=\"Registrar vehículo\">

    </form>
";

?>