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

    $select = "SELECT * FROM vehiculo_venda;";
    $query = mysqli_query($link, $select);
    
    if($query == false){
        echo "Por alguna extraña razón no se pueden mostrar los vehículos en venda, vuelve a intentarlo a ver si la siguiente vez funciona<br>";
        echo "Si no, F por la base de datos<br>";
    } else {

        echo "<h2>Vehículos disponibles para a venda:</h2>";
        echo "<form action=\"venda.php\" method=\"post\" enctype=\"multipart/form-data\">";
        echo "<table style=\"border: 1px solid black;\">";
        echo "<th>Modelo</th><th>Cantidade</th><th>Descrición</th><th>Marca</th><th>Prezo</th><th>Imaxe</th><th>Mercar</th>";

        $a_id = 0;
        while($value = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            echo "<tr>";

            foreach($value as $k => $v){
                echo "<td style=\"border: 1px solid black;\">$v</td>";
            }
            // Botón de alugar

            echo(sprintf("<td><input type=\"radio\" name=\"venda\" %s value=\"%s\"></td>", ($value["cantidade"] == 0 ? "disabled = \"true\"" : ""), $value["modelo"]));

            echo "</tr>";
            $a_id++;
        }
        echo "</table>";

        echo "<br><input type=\"submit\" value=\"Mercar\">";
        echo "</form>";
    }


    mysqli_free_result($query);
    mysqli_close($link);
}
?>