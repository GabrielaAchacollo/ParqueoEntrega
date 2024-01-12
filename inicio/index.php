<?php
 
  $ruta="../";  
  session_start();
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
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div class="container">
            <div class="section">
              <div class="row">
                <div class="col s12 m4 l4">
                  <div class="col s12 m12 l12" style="font-size: 18px; text-align: center; font-weight: bold;">
                    SISTEMA DE CONTROL DE ENTRADA Y SALIDA DE VEHÍCULOS Y MOTOS
                     </div>
                  <div class="col s12 m12 l12">

                                <ul id="projects-collection" class="collection">
                                    <li class="collection-item avatar" style="background: #f4b00f;">
                                         <div class="col s6">
                                        <i class="mdi-social-group circle light-blue darken-4"></i>
                                        <span class="collection-header">Administrativos</span>
                                        </div>
                                        <div class="col s6">
                                             <span class="task-cat cyan" style="font-size: 15px;">10</span>
                                        </div>
                                    </li>
                                    <li class="collection-item avatar" style="background: #f4b00f;">
                                         <div class="col s6">
                                        <i class="mdi-image-timer-auto circle light-blue darken-4"></i>
                                        <span class="collection-header">Conductor</span>
                                        </div>
                                        <div class="col s6">
                                             <span class="task-cat green">5</span>
                                        </div>
                                    </li>
                                   
                                   
                                </ul>
                            </div>
                
                  
                </div>
                <div class="col s12 m8 l8">
                    <div class="slider">
                    <ul class="slides">
                      <li>
                        <img src="<?php echo $ruta ?>imagenes/slide/SL1.jpg"> <!-- random image -->
                        <!-- random image -->
                      
                      </li>
                      <li> 
                        <img src="<?php echo $ruta ?>imagenes/slide/SL2.jpg" alt="sample">
                         <div class="caption center-align">
                      </div>
                      </li>
                      <li>
                        <img src="<?php echo $ruta ?>imagenes/slide/SL3.jpg"> <!-- random image -->
                        <div class="caption center-align">
                        <h3>SISTEMA</h3>
                        <h5 class="light white-text text-lighten-3">SISTEMA DE CONTROL DE ENTRADA Y SALIDA
DE VEHÍCULOS Y MOTOS</h5>
                      </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <div id="breadcrumbs-wrapper">
            <div class="container">
             
            </div>
          </div>
          
          <!--start container-->
       
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
      $('#example').DataTable({
        responsive: true
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