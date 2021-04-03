<?php
    session_start();
    include("conexion.php");

    $id_cliente = filter_var($_POST["id_cliente"], FILTER_SANITIZE_STRING);
    $nombre_examen = filter_var($_POST["nombre_examen"], FILTER_SANITIZE_STRING);
    $fecha_examen = filter_var($_POST["fecha_examen"], FILTER_SANITIZE_STRING);
    $estado = 'P';
    $resultados = '-';

    $id_cliente = mysqli_real_escape_string($link, $id_cliente);
    $nombre_examen = mysqli_real_escape_string($link, $nombre_examen);
    $fecha_examen = mysqli_real_escape_string($link, $fecha_examen);

    $sql = "INSERT INTO examenes (`id_cliente`, `resultados`, `nombre_examen`, `estado`, `fecha_examen`) VALUES ('$id_cliente','$resultados','$nombre_examen','$estado','$fecha_examen')";
    $result = mysqli_query($link, $sql);
    if(!$result){
        $error = '<div id="alert" class="alert alert-warning collapse">Error al ingresar en la base de datos.<a class="close" data-dismiss="alert">&times;</a></div>';
        echo json_encode(array("code" => 400, "mensaje"=> $error));
    }else{
        echo json_encode(array("code" => 200, "mensaje"=> mysqli_insert_id($link)));
    }
?>