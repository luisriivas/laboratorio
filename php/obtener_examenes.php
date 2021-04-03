<?php
    session_start();
    include('conexion.php');

    $sql = "SELECT * FROM clientes INNER JOIN examenes ON clientes.id_cliente = examenes.id_cliente";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
            $return_arr = array();
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $row_array['id_examen'] = $row['id_examen'];
                $row_array['id_cliente'] = $row['id_cliente'];
                $row_array['nombre_examen'] = $row['nombre_examen'];
                $row_array['estado'] = $row['estado'];
                $row_array['resultados'] = $row['resultados'];
                $row_array['nombre'] = $row['nombre'];
                $row_array['correo'] = $row['correo'];
                $row_array['cedula'] = $row['cedula'];
                array_push($return_arr,$row_array);
            }
            echo json_encode(array("code" => 200, "data"=> $return_arr));
        }else{
            $resultMessage = '<div class="alert alert-warning">No tiene registrado ningun examen de laboratorio.<a class="close" data-dismiss="alert">&times;</a></div>';
            echo json_encode(array("code" => 404, "mensaje"=> $resultMessage));
            exit;
        }
    } else {
        $resultMessage = '<div class="alert alert-warning">Un error ha ocurrido en la consulta. intente de nuevo mas tarde.<a class="close" data-dismiss="alert">&times;</a></div>';
        echo json_encode(array("code" => 404, "mensaje"=> $resultMessage));
    }
?>