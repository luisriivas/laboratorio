<?php
    session_start();

    $update = '';
    $cupdate = '';
    $correom = '';
    $ccorreom = '';

    include_once "../librerias/dompdf/autoload.inc.php";
    use Dompdf\Dompdf;

    require_once("../librerias/PHPMailer/class.phpmailer.php");

    include("conexion.php");

    $resultados = $_POST["resultados"];
    $id_examen = $_POST["id_examen"];

    $update_laboratorysql = "UPDATE examenes SET resultados = '$resultados', estado = 'E' WHERE id_examen = '$id_examen'";
    $r_laboratorysql = mysqli_query($link, $update_laboratorysql);
    if(!$r_laboratorysql){
        $update = '<div id="alert" class="alert alert-warning collapse">Error al actualizar el estado.<a class="close" data-dismiss="alert">&times;</a></div>';
        $cupdate = 400;
    }else{
        $update = '<div id="alert" class="alert alert-info collapse">Se actualizo correctamente.<a class="close" data-dismiss="alert">&times;</a></div>';
        $cupdate = 200;
    }

    if($r_laboratorysql){
        $sqldata = "SELECT * FROM clientes INNER JOIN examenes ON clientes.id_cliente = examenes.id_cliente where examenes.id_examen = '$id_examen'";
        $rdata = mysqli_query($link, $sqldata);
        if(!$rdata){
            $update = '<div id="alert" class="alert alert-warning collapse">Hubo un problema al insertar el registro en la base de datos.<a class="close" data-dismiss="alert">&times;</a></div>';
            $cupdate = 400;
        }else{
            $update = '<div id="alert" class="alert alert-info collapse">Se registraron los resultados ingresados.<a class="close" data-dismiss="alert">&times;</a></div>';
            $cupdate = 200;
            $resultdata = mysqli_fetch_array($rdata);
        }

        $codigo = '
                    <table style="width: 100%;" border="3">
                        <tr>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Examen</th>
                            <th>fecha</th>
                            <th>Resultado</th>
                        </tr>';
        $codigo .= ' <tr>
                    <td>'.$resultdata["nombre"].'</td>
                    <td>'.$resultdata["cedula"].'</td>
                    <td>'.$resultdata['nombre_examen'].'</td>
                    <td>'.$resultdata["fecha_examen"].'</td>
                    <td>'.$resultdata["resultados"].'</td>
                </tr>';
        $codigo .= '
            </table>';

        $file_name = md5(rand()) . '.pdf';
        $html = $codigo;
        $pdf = new Dompdf();
        $pdf->load_html($html);
        $pdf->render();
        $file = $pdf->output();
        file_put_contents($file_name, $file);

        // Cambiar 1
        $from = "luisrivas.urbe@gmail.com";
        // Cambiar 2
        $emailto = $resultdata['correo'];
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        // cambiar 1
        $mail->Username = "luisrivas.urbe@gmail.com";
        $mail->Password = "1234567890yo";
        // cambiar 2
        $mail->setFrom($from, '');
        $mail->addAddress($emailto, '');
        $mail->IsHTML(true);
        $mail->AddAttachment($file_name);
        $mail->Subject = 'Resultados';
        $mail->Body = 'Se le envia un archivo adjunto con los resultados de su examen';
        if($mail->Send()) {
            $correom = '<div id="alert" class="alert alert-info collapse">El correo se envio con exito.<a class="close" data-dismiss="alert">&times;</a></div>';
            $ccorreom = 200;
        } else {
            $correom = '<div class="alert alert-warning">Hubo un fallo al enviar el correo.<a class="close" data-dismiss="alert">&times;</a></div>';
            $ccorreom = 400;
            $correom = $mail->ErrorInfo;
        }
        echo json_encode(array("update" => $update, "cUpdate" => $cupdate, "correo"=> $correom, "codecorreo"=>$ccorreom));
    }


?>