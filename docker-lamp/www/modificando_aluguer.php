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
} else {
    // Obtenemos los datos actuales
    // TODO: Cuidado con los blancos
    mysqli_set_charset($link, "utf8");

    $modelo      = $_REQUEST["model"];
    $cantidade   = $_REQUEST["quantity"];
    $descricion  = $_REQUEST["description"];
    $marca       = $_REQUEST["brand"];
    $precio      = $_REQUEST["price"];
    $foto        = $_REQUEST["photo"];


    if(isset($modelo)){
        // Buscamos se o modelo existe na base de datos
        $select = sprintf("SELECT * FROM vehiculo_aluguer WHERE modelo = '%s'", $modelo);
        $query  = mysqli_query($link, $select);

        if(mysqli_num_rows($query) > 0){
            // Detectamos blancos, modificamos campos que no estén en blanco
            if(isset($cantidade) && !empty($cantidade)){
                $select = sprintf("UPDATE vehiculo_aluguer SET cantidade='%s' WHERE modelo='%s'", $cantidade, $modelo);
                $query  = mysqli_query($link, $select);

                if($query == false){
                    echo "Error o modificar a candidade de vehículos (É o dato numérico?)!<br>";
                } else {
                    echo "Modificouse a cantidade a ".$cantidade."<br>";
                }
            }

            if(isset($descricion) && !empty($descricion)){
                $select = sprintf("UPDATE vehiculo_aluguer SET descricion='%s' WHERE modelo='%s'", $descricion, $modelo);
                $query  = mysqli_query($link, $select);

                if($query == false){
                    echo "Error o modificar a descrición do vehículo<br>";
                } else {
                    echo "Modificouse a descrición do vehículo a $descricion <br>";
                }
            }

            if(isset($marca) && !empty($marca)){
                $select = sprintf("UPDATE vehiculo_aluguer SET marca='%s' WHERE modelo='%s'", $marca, $modelo);
                $query  = mysqli_query($link, $select);

                if($query == false){
                    echo "Error ao modificar a marca do vehículo<br>";
                } else {
                    echo "Modificouse a marca do vehículo a $marca <br>";
                }
            }

            if(isset($precio) && !empty($precio)){
                $select = sprintf("UPDATE vehiculo_aluguer SET prezo='%s' WHERE modelo='%s'", $precio, $modelo);
                $query  = mysqli_query($link, $select);

                if($query == false){
                    echo "Error ao modificar o prezo do vehículo (Dato numérico?) <br>";
                } else {
                    echo "Modificouse o prezo do vehículo a $precio <br>";
                }
            }

            if(isset($foto) && !empty($foto)){
                $select = sprintf("UPDATE vehiculo_aluguer SET foto='%s' WHERE modelo='%s'", $foto, $modelo);
                $query  = mysqli_query($link, $select);

                if($query == false){
                    echo "Error ao modificar a foto do vehículo!<br>";
                } else {
                    echo "Modificouse a URL da foto do vehículo a $foto<br>";
                }
            }
        } else {
            echo "O modelo seleccionado non existe na base de datos!";
        }
    } else {
        echo "Pasouse un modelo en branco<br>";
    }

    echo "<br><a href='menu_admin.php'>Volver al menú</a>";

    mysqli_close($link);
}



?>