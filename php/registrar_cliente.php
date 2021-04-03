<?php
    session_start();
    include("conexion.php");

    $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST["correo"], FILTER_SANITIZE_STRING);
    $cedula = filter_var($_POST["cedula"], FILTER_SANITIZE_STRING);

    $nombre = mysqli_real_escape_string($link, $nombre);
    $correo = mysqli_real_escape_string($link, $correo);
    $cedula = mysqli_real_escape_string($link, $cedula);

    $sql = "INSERT INTO clientes (`nombre`, `correo`, `cedula`) VALUES ('$nombre', '$correo', '$cedula')";
    $result = mysqli_query($link, $sql);
    if(!$result){
        $errorMessage = '<div id="alert" class="alert alert-warning collapse">Error al ingresar en la base de datos.<a class="close" data-dismiss="alert">&times;</a></div>';
        echo json_encode(array("code" => 400, "data"=> $errorMessage));
    }else{
        echo json_encode(array("code" => 200, "data"=> mysqli_insert_id($link)));
    }
?>