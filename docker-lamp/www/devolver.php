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
echo "</div>";
echo "<hr>";

$link = mysqli_connect("localhost", "root", "", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
    die();

} else {
    $usuario = $_SESSION["user"];

    // Mostramos los vehículos de los que dispone el usuario
    // NOTA: EN UN SELECTOR!
    $select = sprintf("SELECT * FROM vehiculo_alugado WHERE usuario = '%s'", $usuario);
    $query = mysqli_query($link, $select);

    if(mysqli_num_rows($query) > 0){
        // El usuario dispone de vehículos, creamos el selector
        echo "
            <h3>Selecciona un vehículo para devolver</h3><br>
            <form action=\"devolver_op.php\" method=\"post\" enctype=\"multipart/form-data\">
            <select name=\"devolver_alugado\">
        ";

        // Generamos el selector
        while($elemento_alugar = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            echo(sprintf("<option value=\"%s\">%s</option>", $elemento_alugar["modelo"], sprintf("%s %s (Cantidade: %d)", $elemento_alugar["marca"], $elemento_alugar["modelo"], $elemento_alugar["cantidade"])));
        }

        echo "
            </select>
            <br>
            <br>
            <input type=\"submit\" value=\"Devolver\">
            </form>
        ";

    } else {
        echo "<h3>O usuario $usuario non dispón de ningún vehículo en aluguer actualmente</h3>";
    }

    mysqli_close($link);
}



?>