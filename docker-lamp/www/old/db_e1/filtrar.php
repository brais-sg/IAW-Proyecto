<html lang="es">
<meta charset="UTF-8">
<head>
    <title>Ejercicios con base de datos, E1</title>
</head>
<body>
<?php
    $link = mysqli_connect("db", "root", "test", "Inmobiliaria");

    if(mysqli_connect_errno()){
        echo "Ha fallado la conexión a la base de datos";
    } else {
        // Obtiene el tipo de vivienda a filtrar por
        $tipo = $_REQUEST["tipo"];

        // Listado de viviendas
        $select = "SELECT * FROM Vivendas WHERE Tipo LIKE '%".$tipo."%'";
        $query = mysqli_query($link, $select);

        echo "Query: ".$select."<br>";
        echo "Filtrando por: ".$tipo;
        echo "<br>";

        while($value = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            echo "<br>";
            foreach($value as $k => $v){
                echo "<b>$k</b> : $v ";
            }
        }

        mysqli_free_result($query);
        mysqli_close($link);
    }
?>
</body>
</html>
