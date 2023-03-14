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


$link = mysqli_connect("localhost", "root", "", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
    die();

} else {    
    mysqli_set_charset($link, "utf8");

    $select = "SELECT * FROM vehiculo_devolto";
    $query = mysqli_query($link, $select);

    while($actual = mysqli_fetch_array($query, MYSQLI_ASSOC)){
        $modelo    = $actual["modelo"];
        $cantidade = $actual["cantidade"];


        // Ejecutamos el update en la tabla de aluguer
        $select_aluguer = sprintf("UPDATE vehiculo_aluguer SET cantidade = cantidade + %s WHERE modelo = '%s'", $cantidade, $modelo);
        $query_aluguer  = mysqli_query($link, $select_aluguer);

        if($query_aluguer == false){
            echo "Produciuse un error ao modificar a cantidade do vehículo $modelo<br>";
        } else {
            // Eliminamos el vehículo de la tabla devolto
            echo "Devolvéronse correctamente $cantidade unidades do vehículo $modelo<br>";

            $select_devolto = sprintf("DELETE FROM vehiculo_devolto WHERE modelo = '%s'", $modelo);
            $query_devolto  = mysqli_query($link, $select_devolto);

            if($query_devolto == false){
                echo "Produciuse un error ao eliminar o vehículo $modelo da taboa devoltos<br>";
            } else {
                echo "Eliminouse correctamente o vehículo $modelo da taboa de devoltos<br>";
            }
        }
    }


    echo "<h2>Operación realizada con éxito</h2>";

    echo "<br>Pulsa <a href='menu_admin.php'>aquí</a> para volver al menú principal\n";

    mysqli_close($link);
}




?>