<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/admejecutivo.php");
  $admejecutivo=new admejecutivo;
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Administrativo";
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
          $idmenu=1037;
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
                <div class="col s12" style="background: #032049; color: white;">NUEVO PERSONAL</div>

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


 <div class="row">
      <div class="col s12">       
        <div id="vestibulum" class="col s12  ">
          <div class="container">
            <div class="section">
              <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>CI</th>
                      <th>Foto</th>
                      <th>Nombre</th> 
                      <th>Cargo</th> 
                      <th>Fecha Ingreso</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>CI</th>
                      <th>Foto</th>
                      <th>Nombre</th> 
                      <th>Cargo</th> 
                      <th>Fecha Ingreso</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($vadmejecutivo->mostrarTodo("idtipo!=166 and idtipo!=142") as $f)//idtipo=142
                    {
                      $lblcode=ecUrl($f['idvadmejecutivo']);
                      $lblcodep=ecUrl($f['idpersona']);
                      $deje=$admejecutivo->muestra($f['idvadmejecutivo']);
                      switch ($deje['estado']) {
                        case '0':
                          $estilo="background-color: #f4a742;";
                        break;
                        case '1':
                          $estilo="background-color: #6cd17f;";
                        break;
                      }
                      $per=$persona->muestra($deje['idpersona']);
                      $idpedoc=$per['idpersona'];

                       $dfotodoc=$vfiles->mostrarUltimo("id_publicacion=".$idpedoc." and tipo_foto='foto'");

                        if (count($dfotodoc)>0) {
                          $rutaFotodoc=$ruta."persona/editar/server/php/".$idpedoc."/".$dfotodoc['name'];
                          }else{
                              $rutaFotodoc=$ruta."imagenes/user.png";
                          }
                    ?>
                    <tr>
                      <td><?php echo $f['carnet']." ".$f['expedido']?></td>
                      <td><img style="width: 50px;" src="<?php echo $rutaFotodoc ?>" alt="" class="circle responsive-img valign profile-image"></td>
                      <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                      <td><?php echo $f['tiponombre'] ?></td>
                     <!-- <td><?php //echo $f['njerarquia'] ?></td> -->
                      <td><?php echo $f['fechaingreso'] ?></td>
                      <!-- <td><?php //echo $f['nsede'] ?></td>
                      <td><?php //echo $f['norganizacion'] ?></td> -->
                      <td>
                        <?php 
                          if ($deje['estado']==0) echo "INACTIVO";else echo "ACTIVO";
                        ?>
                      </td>
                      <td>
                        <?php 
                          if ($deje['estado']==0) {
                            ?>
                              <button onclick="cambiaestado('<?php echo $lblcode ?>','1');" class="btn-jh darken-4 green">HABILITAR</button>
                            <?php
                          }else {
                            ?>
                              <button onclick="cambiaestado('<?php echo $lblcode ?>','0');" class="btn-jh red">DESHABILITAR</button>
                            <?php
                          }
                        ?>
                        <a href="editar/ver.php?lblcode=<?php echo $lblcodep ?>" class="btn-jh waves-effect darken-4 cyan"><i class="fa fa-file-photo-o (alias)"></i> DATOS</a>
                         <?php
                         $trans=$transporteasig->mostrarUltimo("estado=1 and idadmejecutivo=".$f['idvadmejecutivo']);
                          if (count($trans)>0) {
                            ?>
                              <a href="vehiculo/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-car"></i> Ver</a>
                              <?php
                            
                                 ?>

                                 <?php
                                 $tar=$tarjeta->mostrarUltimo("estado=1 and idadmejecutivo=".$f['idvadmejecutivo']);
                                 if (count($tar)>0) 
                                 {
                                  ?>
                                  <a href="rfid/asignar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-1 green"><i class="fa fa-credit-card"></i> Ver RFID</a>
                                  <!-- despues de asignar tarjeta rfid puede ver y asignar -->
                                 
                                   <?php 
                                 }else{
                                    ?>
                                    <a href="rfid/asignar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-1 green"><i class="fa fa-credit-card"></i> Asig. RFID</a>
                                   <?php
                                 }
                            
                             
                          }else{
                            ?>
                              <a href="vehiculo/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-car"></i> Asig. Vehículo</a>
                            <?php
                          }

                         ?>
                        
                      <!--  <a href="impresion/?lblcode=<?php //echo $lblcode ?>" class="btn-jh waves-effect darken-4 orange" target="_blank"><i class="fa fa-print"></i></a> -->
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
      </div>
    </div>
          </div>
          <?php
            include_once("../footer.php");
          ?>
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
    function cambiaestado(id,estado){
      swal({
        title: "Estas Seguro?",
        text: "Cambiaras el estado al ejecutivo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cambiaestado.php",
          type: "POST",
          data: "id="+id+"&estado="+estado,
          success: function(resp){
            console.log(resp);
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
    </script>
</body>

</html>