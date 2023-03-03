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


$link = mysqli_connect("db", "root", "test", "frota");
if(mysqli_connect_errno()){
    echo "Ha fallado la conexión a la base de datos";
    die();

} else {    
    mysqli_set_charset($link, "utf8");

    if(isset($_REQUEST["alugar"])){
        $modelo  = $_REQUEST["alugar"];
        $usuario = $_SESSION["user"];

        $select = sprintf("SELECT * FROM vehiculo_aluguer WHERE modelo='%s';", $_REQUEST["alugar"]);
        $query = mysqli_query($link, $select);

        $aluguer = mysqli_fetch_array($query, MYSQLI_ASSOC);

        $nova_cantidade = $aluguer["cantidade"] - 1;
        
        if($nova_cantidade < 0){
            echo "Non foi posible alugar dito vehículo, dado a que non quedan unidades disponibles!<br>";
            echo "Pulsa <a href=\"menu.php\">aquí</a> para volver o menú";
        } else {
            /*
                ALGORITMO:
                    Comprobamos se na tabla vehículo_alugado dito vehículo existe e pertence o usuario (Si quere alugar máis de un)
                    Se existe, incrementamos o contador de cantidade do vehículo de ese usuario
                    Se non existe, creamos una nova insercción co vehículo

                    Finalmente, decrementamos nunha unidade a cantidade de vehículos disponibles na tabla de vehiculo_aluguer

            */
            
            // Buscamos si el cliente tiene un vehículo igual en su tabla de alugados
            $select = sprintf("SELECT * FROM vehiculo_alugado WHERE modelo='%s' AND usuario='%s';", $modelo, $usuario);
            $query  = mysqli_query($link, $select);

            if(mysqli_num_rows($query) > 0){
                // Existe, incrementamos dicho modelo!
                $select = sprintf("UPDATE vehiculo_alugado SET cantidade = cantidade + 1 WHERE modelo='%s' AND usuario='%s';", $modelo, $usuario);
                $query = mysqli_query($link, $select);

                // echo "Query: $select<br>"; // DEBUG
                

                if($query == false){
                    echo "<h2>Error al actualizar la cantidad de vehículo!</h2><br>";
                } else {
                    echo "Se actualizó correctamente la cantidad de vehículos alugados para $usuario!<br>";
                }
            } else {
                // No existe, insertamos
                $select = sprintf("INSERT INTO vehiculo_alugado VALUES('%s', '%d', '%s', '%s', '%s', '%s');", $aluguer["modelo"], 1, $aluguer["descricion"], $aluguer["marca"], $aluguer["foto"], $usuario);
                $query = mysqli_query($link, $select);

                // echo "Query: $select<br>"; // DEBUG

                if($query == false){
                    echo "<h2>Error al insertar un vehículo nuevo en la tabla!</h2><br>";
                } else {
                    echo "Se creó con éxito el vehículo en la tabla vehículos alugados<br>";
                }
            }

            // Decrementar os vehículos disponibles!
            $select = sprintf("UPDATE vehiculo_aluguer SET cantidade = cantidade - 1 WHERE modelo='%s'", $modelo);
            $query = mysqli_query($link, $select);

            if($query == false){
                echo "<h2>Error al decrementar vehículo en la tabla de aluguer!</h2><br>";
            } else {
                echo "Se modificó con éxito la tabla de vehículos por aluguer!<br>";
            }

        }

    } else {
        echo "Debes seleccionar un vehículo para alugar!<br>";
    }

    echo "<br>Pulsa <a href='menu.php'>aquí</a> para volver al menú principal\n";

    mysqli_close($link);
}

?>
