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
        // Inserta unha vivenda
        $select = "DELETE FROM Vivendas WHERE Tipo='Casa'";
        $query = mysqli_query($link, $select);

        if($query){
            echo "Eliminación correcta<br>";
        } else {
            echo "Eliminación incorrecta<br>";
        }
        mysqli_close($link);
    }

?>
</body>
</html>