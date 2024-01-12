<?php
 
  $ruta="../../";  
  session_start();
  include_once($ruta."class/seguimiento.php");
  $seguimiento=new seguimiento;
  include_once($ruta."class/tiposeguimiento.php");
  $tiposeguimiento=new tiposeguimiento;
  include_once($ruta."funciones/funciones.php");
  $lblcode=ecUrl(3898);
  //echo $lblcode;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo=$_SESSION["short"];
      $hd_titulo2=$_SESSION["descripcion"];
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
    
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1000;
          include_once($ruta."aside.php");

          $consulta="SELECT *
                      FROM seguimiento
                      WHERE activo=1 and estado=0 ORDER BY fecha DESC, fechacompromiso DESC";
        ?>
        <section id="content">         
          <div class="container">
            <div class="section">
              <div class="row">
                <div class="col s12">
                    <ul class="tabs tab-demo-active z-depth-1"><!-- cyan -->
                      <li class="tab col s3"><a class="waves-effect waves-light active" href="#sapien">Sapien</a>
                      </li>
                      <li class="tab col s3"><a class="waves-effect waves-light" href="#activeone">Active One</a>
                      </li>
                    </ul>
                  </div>
                  <div class="col s12">
                    <div id="sapien" class="col s12 cyan lighten-4">
                      <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                      <ol>
                        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                        <li>Aliquam tincidunt mauris eu risus.</li>
                        <li>Vestibulum auctor dapibus neque.</li>
                      </ol>

                    </div>
                    <div id="activeone" class="col s12 cyan lighten-4">
                      <dl>
                        <dt>Definition list</dt>
                        <dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</dd>
                        <dt>Lorem ipsum dolor sit amet</dt>
                        <dd>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</dd>
                      </dl>
                    </div>
                  </div>
                </div>
                  <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                       <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Nro</th>
                      <th>Respuesta de cliente</th> 
                      <th width="100px">Fecha Registro</th> 
                      <th>Fecha Compromiso</th>
                      <th>Hr. Compromiso</th>
                      <th>Observación</th>
                      <th>Usuario</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $contar=0;
                    foreach($seguimiento->sql($consulta) as $f)
                    {
                        //$totalCuotaResto=number_format($totalCuotaResto, 2, '.', '');
                      $regus=$vusuario2->muestra($f["usuariocreacion"]);
                      $contar++;
                      switch ($f['respuestallamada']) {
                        case '1':
                          $respuesta='BUENA';
                          $estilo="color: #00AB4E;";
                          break;
                        
                        case '2':
                          $respuesta='REGULAR';
                          $estilo="color: #FF892D;";
                          break;
                        case '3':
                          $respuesta='MALA';
                          $estilo="color: #FF1E1E;";
                          break;  
                      }
                    ?>
                    <tr>
                      <td><?php echo $contar ?></td>
                      <td style="font-weight: bold;<?php echo $estilo ?>"><?php echo $respuesta ?></td>
                      <td><?php echo $f['fecha'] ?></td>
                      <td><?php echo $f['fechacompromiso'] ?></td>
                      <td><?php echo $f['horacompromiso'] ?></td>
                      <td><?php echo $f['observacion'] ?></td>
                      <td><?php echo $regus['nombre'] ?></td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
                  </div>
               
              
              </div>
              
            </div>
          </div>
          <!--start container-->
          <div class="container">
            <!-- //////////////////////////////////////////////////////////////////////////// -->
            <!-- Floating Action Button -->
            <div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
              <a class="btn-floating btn-large">
                <i class="mdi-action-stars"></i>
              </a>
              <ul>
                <li><a href="css-helpers.html" class="btn-floating red"><i class="large mdi-communication-live-help"></i></a></li>
                <li><a href="app-widget.html" class="btn-floating yellow darken-1"><i class="large mdi-device-now-widgets"></i></a></li>
                <li><a href="app-calendar.html" class="btn-floating green"><i class="large mdi-editor-insert-invitation"></i></a></li>
                <li><a href="app-email.html" class="btn-floating blue"><i class="large mdi-communication-email"></i></a></li>
              </ul>
            </div>
          </div>
          <!--end container-->
        </section>
      </div>
    </div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    
    <!-- Toast Notification -->
    <script type="text/javascript">
      $(document).ready(function() {
      $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
   
    // Toast Notification
    $(window).load(function() {
        
        setTimeout(function() {
            Materialize.toast('<span>Bienvenido</span>', 1500);
        }, 1500);
        setTimeout(function() {
            Materialize.toast('<span>En el boton izquierdo puede ver tus opciones en el sistema</span>', 3000);
        }, 5000);
        setTimeout(function() {
            Materialize.toast('<span>No dudes en consultar al departamento de sistemas</span>', 3000);
        }, 15000);
    });
    </script>
</body>

</html>