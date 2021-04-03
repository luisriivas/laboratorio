<?php
session_start();
include('../../php/conexion.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel Administrativo</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"></link>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!--fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" 
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </head>
  <body>
    <div id="wrapper">
      <div class="overlay"></div>

      <!-- Sidebar -->
      <nav class="fixed-top align-top" id="sidebar-wrapper" role="navigation">
        <div class="simplebar-content" style="padding: 0px;">
          <a class="sidebar-brand" href="index.html">
            <span class="align-middle">Laboratorio</span>
          </a>
          <ul class="navbar-nav align-self-stretch">
            <li class="sidebar-header active">Opciones</li>
            <li class="">
              <a class="nav-link text-left" style="color:#ffffff !important;" role="button" aria-haspopup="true" aria-expanded="false">
                Dashboard
              </a>
            </li>
            <li class="">
              <a href="../registrar_cliente" class="nav-link text-left" style="color:#ffffff !important;"  role="button" aria-haspopup="true" aria-expanded="false">
                Registrar clientes
              </a>
            </li>
            <li class="">
              <a href="../solicitar_examen" class="nav-link text-left" style="color:#ffffff !important;"  role="button" aria-haspopup="true" aria-expanded="false">
                Solicitud de examen
              </a>
            </li>
            <li class="">
              <a href="../enviar-examen" class="nav-link text-left" style="color:#ffffff !important;"  role="button" aria-haspopup="true" aria-expanded="false">
                envio de examen
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Page Content -->
      <div id="page-content-wrapper">
        <div id="content">
          <div class="container-fluid p-0 px-lg-0 px-md-0">
            <nav class="navbar navbar-expand navbar-light my-navbar">
              <div type="button"  id="bar" class="nav-icon1 hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
                <span></span>
                <span></span>
                <span></span>
              </div>
              <ul class="navbar-nav ml-auto">
                <li class="nav-item d-sm-none">
                  <?php echo $_SESSION['correo']; ?>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>

      <div class="container-fluid px-lg-4">
        <div class="row">
          <div class="col-md-12 mt-lg-4 mt-4">
            Dashboard
          </div>

          <!-- contenido -->
          <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-body custom-c">
                <!-- titulo -->
                <div class="d-md-flex align-items-center">
                  <div>
                    <h4 class="card-title">Examenes de laboratorio registrados</h4>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table v-middle">
                  <thead>
                    <tr class="bg">
                      <th class="border-top-0">Cliente</th>
                      <th class="border-top-0">Correo</th>
                      <th class="border-top-0">Cedula</th>
                      <th class="border-top-0">Examen</th>
                      <th class="border-top-0">Estado</th>
                      <th class="border-top-0">Resultado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sqltable = "SELECT * FROM clientes INNER JOIN examenes ON clientes.id_cliente = examenes.id_cliente ORDER by clientes.nombre DESC";
                      if($rstable = mysqli_query($link, $sqltable)){
                          if(mysqli_num_rows($rstable) > 0){
                              while( $row = mysqli_fetch_array($rstable, MYSQLI_ASSOC) ) {
                                echo '<tr>
                                        <td>
                                          <div class="d-flex align-items-center">
                                            <div class="">
                                              <h4 class="m-b-0 font-16">'.$row['nombre'].'</h4>
                                            </div>
                                          </div>
                                        </td>
                                        <td>'.$row['correo'].'</td>
                                        <td>'.$row['cedula'].'</td>
                                        <td>'.$row['nombre_examen'].'</td>
                                        <td>'.$row['estado'].'</td>
                                        <td>'.$row['resultados'].'</td>
                                      </tr>';
                              }
                          } else{
                              echo 'No existen clientes en la base de datos';
                          }
                      } else {
                          $errorMessage = '<div id="alert" class="alert alert-warning collapse">Hubo un problema al obtener los registros de la base de datos.<a class="close" data-dismiss="alert">&times;</a></div>';
                          echo 'Error al obtener la información de la base de datos';
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>

    <footer class="footer">
      <div class="container-fluid">
        <div class="row text-muted">
          <div class="col-6 text-left">
            <p class="mb-0">
              <a href="index.html" class="text-muted"><strong>Laboratorio </strong></a> &copy
            </p>
          </div>
          <div class="col-6 text-right">
            <ul class="list-inline">
              <li class="footer-item">
                <a class="text-muted" href="#">Support</a>
              </li>
              <li class="footer-item">
                <a class="text-muted" href="#">Help Center</a>
              </li>
              <li class="footer-item">
                <a class="text-muted" href="#">Privacy</a>
              </li>
              <li class="footer-item">
                <a class="text-muted" href="#">Terms</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
    $('#bar').click(function(){
      $(this).toggleClass('open');
      $('#page-content-wrapper ,#sidebar-wrapper').toggleClass('toggled' );
    });
    </script>

</body>
</html>