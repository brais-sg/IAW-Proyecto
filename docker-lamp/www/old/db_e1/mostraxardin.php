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
        // Listado de viviendas
        $select = "SELECT * FROM Vivendas WHERE Extras LIKE '%Xardín%'";
        $query = mysqli_query($link, $select);

        echo "Vivendas:<br>";
        while($value = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            echo "<br>";
            foreach($value as $element){
                echo "$element<br>";
            }
        }

        mysqli_close($link);
    }
?>
</body>
</html>
