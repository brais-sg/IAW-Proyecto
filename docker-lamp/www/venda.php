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
    if(isset($_REQUEST["venda"])){
        $mercado = $_REQUEST["venda"];
        $usuario = $_SESSION["user"];
        
        // Primero: Buscamos el vehículo en la tabla vehiculo_venda
        // Existe mais de un? Decrementamos : Eliminamos o vehículo
        
        $select = sprintf("SELECT * FROM vehiculo_venda WHERE modelo='%s'", $mercado);
        $query = mysqli_query($link, $select);

        $elemento = mysqli_fetch_array($query, MYSQLI_ASSOC);

        // TODO: Cantidad!!! Arreglar esto!
        // Brais del futuro (3/2): arreglado
        if($elemento["cantidade"] > 1){
            // Decrementamos en venda
            $select = sprintf("UPDATE vehiculo_venda SET cantidade = cantidade - 1 WHERE modelo='%s'", $mercado);
            $query = mysqli_query($link, $select);

            if($query == false){
                echo "Error al actualizar los vehículos en venta!<br>";
            } else {
                echo "Vehículo en venta decrementado correctamente!<br>";
            }
        } else {
            // Eliminamos
            $select = sprintf("DELETE FROM vehiculo_venda WHERE modelo='%s'", $mercado);
            $query = mysqli_query($link, $select);

            if($query == false){
                echo "Error al eliminar desde los vehículos en venta!<br>";
            } else {
                echo "Vehículo en venta eliminado correctamente!<br>";
            }
        }

        // Obtenemos los datos del usuario que compra el vehículo
        $select = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $usuario);
        $query  = mysqli_query($link, $select);

        $datosusuario = mysqli_fetch_array($query, MYSQLI_ASSOC);

        // Creamos el ticket
        $nombre_ticket = sprintf("ticket/venda-%s-%s-%s.txt",$datosusuario["nome"],$mercado,date("Y-m-d H:i:s"));

        $ticket = fopen($nombre_ticket,"w");
        fprintf($ticket, "TICKET DE COMPRA PARA %s:\n\n", $mercado);
        fprintf($ticket, " Fecha de compra: %s\n", date("Y-m-d H:i:s"));
        fprintf($ticket, " Modelo: %s\n", $elemento["modelo"]);
        fprintf($ticket, " Cantidade: %s\n", 1);
        fprintf($ticket, " Descrición: %s\n", $elemento["descricion"]);
        fprintf($ticket, " Marca: %s\n", $elemento["marca"]);
        fprintf($ticket, " Prezo: %s\n", $elemento["prezo"]);
        fprintf($ticket, "\n");
        fprintf($ticket, "Datos del comprador:\n");
        fprintf($ticket, " Nombre: %s\n", $datosusuario["nome"]);
        fprintf($ticket, " Dirección: %s\n", $datosusuario["direccion"]);
        fprintf($ticket, " Telefono: %s\n", $datosusuario["telefono"]);
        fprintf($ticket, " NIF: %s\n", $datosusuario["nifdni"]);
        fprintf($ticket, " Email: %s\n", $datosusuario["email"]);

        fflush($ticket);
        fclose($ticket);


        echo "Has comprado un vehículo correctamente!<br>";
        echo "Pulsa <a href=\"menu.php\">aquí</a> para volver o menú principal<br><br>";

        // echo "Tu ticket es el siguiente:<br><br><br>";
        // highlight_file($nombre_ticket);

    } else {
        echo "Debes seleccionar un vehículo!<br>";
    }

    echo "<br>Pulsa <a href='menu.php'>aquí</a> para volver al menú principal\n";

    mysqli_close($link);
}





?>