<html lang="es">
<meta charset="UTF-8">
<head>
    <title>Subir archivo en PHP</title>
</head>
<body>
<?php
$link = mysqli_connect("db", "root", "test", "Inmobiliaria");

if(mysqli_connect_errno()){
    echo "<h1 style=\"color: red;\">Ha fallado la conexión a la base de datos</h1>";
} else {
    $to_parse = $_FILES["to_upload"]["tmp_name"];
    $file = fopen($to_parse, "r");

    while(!feof($file)){
        // Leemos línea
        $line = fgets($file);
        // \r\n Únicamente?
        if(strlen($line) < 2) continue;

        list($tipo, $zona, $dormitorios, $precio, $tamano, $extras, $imgref) = array_pad(explode(";", $line), 7, null);
        
        $tipo        = trim($tipo);
        $zona        = trim($zona);
        $dormitorios = trim($dormitorios);
        $precio      = trim($precio);
        $tamano      = trim($tamano);
        $extras      = trim($extras);

        if(isset($imgref)){
            echo "imgref configurada: $imgref<br>";
            $imgref = trim($imgref);
        }

        // Insertamos en la base de datos
        $select = "";
        if(isset($imgref)){
            $select = "INSERT INTO Vivendas values('$tipo', '$zona', '$dormitorios', '$precio', '$tamano', '$extras', '$imgref');";
        } else {
            $select = "INSERT INTO Vivendas values('$tipo', '$zona', '$dormitorios', '$precio', '$tamano', '$extras', NULL);";
        }
       
        $query = mysqli_query($link, $select);

        if($query){
            echo "<p>Se insertó el elemento $tipo, $zona, $dormitorios, $precio, $tamano, $extras</p>";
            echo "<p>SQL ejecutado: $select</p>";
            // echo "<br>";
        } else {
            echo "<h1 style=\"color: red;\">ERROR AL INSERTAR! ($tipo, $zona, $dormitorios, $precio, $tamano, $extras)</h1>";
            echo "<p>SQL ejecutado: $select</p>";
            echo "<br>";
        }
    }

    fclose($file);
    mysqli_close($link);
}



?>
</body>
</html>