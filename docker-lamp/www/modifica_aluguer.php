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



echo '
            <form action="modificando_aluguer.php" method="post" enctype="multipart/form-data" style="border: 1px solid black;">
                <p>Completa los campos que quieras editar, deja vacíos los que no quieras modificar</p>
                <br>
                Modelo: <input type="text" name="model" value=""><br>
                Cantidade: <input type="text" name="quantity" value=""><br>
                Descrición: <input type="text" name="description"  value=""><br>
                Marca: <input type="text" name="brand" value=""><br>
                Prezo: <input type="text" name="price" value=""><br>
                Foto: <input type="text" name="photo" value=""><br>
                <br>

                <input type="submit" value="Modificar datos (aluguer)">
            </form>
        ';

        echo '
        <form action="menu_admin.php" method="get" enctype="multipart/form-data" style="display: inline-block;">
            <input type="submit" value="Cancelar">
        </form>
        ';

?>