<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/admejecutivo.php");
  $admejecutivo=new admejecutivo;
  include_once($ruta."class/conductor.php");
  $conductor=new conductor;
  include_once($ruta."class/rol.php");
  $rol=new rol;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/transporte.php");
  $transporte=new transporte;
  include_once($ruta."class/transporteasig.php");
  $transporteasig=new transporteasig;
  include_once($ruta."class/tarjeta.php");
  $tarjeta=new tarjeta;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
   $fechaHoy=date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="LISTAR DE CONDUCTOR";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
      include_once($ruta."includes/head_tablax.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1094;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row " >
              <div class="col s12 m8 l8" style="background: #f4b00f; text-align: center; color:#1C2637; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                <?php echo $hd_titulo; ?>
              </div>
              <div class="col s12 m4 l4" style="background: white; text-align: center; color:#1C2637; border-radius: 5px; border: #CBCBCB 1px solid">
                <!--<a href="nuevo/buscar.php" class="btn waves-effect darken-4 green"><i class="fa fa-plus-square-o"></i> NUEVO</a>-->
                <div class="col s12" style="background: #032049; color: white;">NUEVO CONDUCTOR</div>

                <div class="input-field col s12">
                  <div class="col s12" >Ingresa numero de carnet:</div>
                  <div id="valCarnet" class="col s12"></div>
                          <input id="idcarnet" name="idcarnet" type="text" class="validate">
                          <label for="idcarnet">Nro. CARNET</label>
                  </div>
              </div>
              </div>
            </div>
          </div>
     
          <div class="container">
            <div class="section">
              <div class="row" >
              <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                        
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Carnet</th>
                      <th>Foto</th>
                      <th>Nombre</th> 
                      <th>Celular</th> 
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Carnet</th>
                      <th>Foto</th>
                      <th>Nombre</th> 
                      <th>Celular</th> 
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($conductor->mostrarTodo("estado=1") as $f)//idtipo=142
                    {
                      
                        $deje=$vadmejecutivo->muestra($f['idadmejecutivo']);
                       $lblcodep=ecUrl($deje['idpersona']);
                       $lblcode=ecUrl($f['idadmejecutivo']);

                       $per=$persona->muestra($deje['idpersona']);
                       $idpedoc=$per['idpersona'];

                       $dfotodoc=$vfiles->mostrarUltimo("id_publicacion=".$idpedoc." and tipo_foto='foto'");

                        if (count($dfotodoc)>0) {
                          $rutaFotodoc=$ruta."persona/editar/server/php/".$idpedoc."/".$dfotodoc['name'];
                          }else{
                              $rutaFotodoc=$ruta."imagenes/user.png";
                          } 
                     
                    ?>
                    <tr >
                      <td><?php echo $deje['carnet']." ".$deje['expedido']?></td>
                       <td><img style="width: 50px;" src="<?php echo $rutaFotodoc ?>" alt="" class="circle responsive-img valign profile-image"></td>
                      <td><?php echo $deje['nombre']." ".$deje['paterno']." ".$deje['materno'] ?></td>
                      <td><?php echo $per['celular'] ?></td>
                      <td>
                        <?php 
                          if ($deje['estado']==0) echo "INACTIVO";else echo "ACTIVO";
                        ?>
                      </td>
                      <td>
                        <a class="btn-jh waves-effect waves-light teal" href="../../persona/editar/?lblcode=<?php echo $lblcodep; ?>"> <i class="fa fa-file-photo-o (alias)"></i> Foto </a>
                        <?php 
                         $trans=$transporteasig->mostrarUltimo("estado=1 and idadmejecutivo=".$f['idadmejecutivo']);
                         if (count($trans)>0) 
                         {
                          ?>
                          <a href="vehiculo/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-car"></i> Ver</a>
                          <?php
                                 
                                 $tar=$tarjeta->mostrarUltimo("estado=1 and idadmejecutivo=".$f['idadmejecutivo']);
                                 if (count($tar)>0) 
                                 {
                                  ?>
                                  <a href="rfid/asignar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 blue"><i class="mdi-action-credit-card"></i> Ver RFID</a>
                                  
                                   <?php 
                                 }else{
                                    ?>
                                    <a href="rfid/asignar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-1 green"><i class="mdi-action-credit-card"></i> Asig.RFID</a>
                                   <?php
                                 }
                            
                         }else{
                          ?>
                          <a href="vehiculo/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-car"></i> Asig. Vehiculo</a>
                          
                          <?php 
                         }
                        ?>
                        <a href="impresion/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 orange" target="_blank"><i class="fa fa-print"></i></a>
                      </td>
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
       
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
        $('#example1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
          $('#example2').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 0, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
         
    });

    $("#idcarnet").blur(function(){
        carnet=$('#idcarnet').val();
        //alert(carnet);
        if (carnet!="") {
          $.ajax({
            url: "nuevo/verificarCI.php",
            type: "POST",
            data: "carnet="+carnet,
            success: function(resp){
              //alert(resp);
              console.log(resp);
              $('#valCarnet').html(resp).slideDown(500);
            }
          });
        }
      });


    </script>
</body>

</html>