<?php
    session_start();
    include("conexion.php");

    $correo = filter_var($_POST["Correo"], FILTER_SANITIZE_EMAIL);
    $clave = filter_var($_POST["clave"], FILTER_SANITIZE_STRING);

    $correo = mysqli_real_escape_string($link, $correo);
    $clave = mysqli_real_escape_string($link, $clave);

    $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND clave='$clave'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo '<div class="alert alert-warning">No se pudo ejecutar la consulta intente de nuevo.<a class="close" data-dismiss="alert">&times;</a></div>';
        exit;
    }

    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class="alert alert-warning">correo o clave inválidos.<a class="close" data-dismiss="alert">&times;</a></div>';
    }
    else {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['correo'] = $row['correo'];
        echo 'success';
    }

?>