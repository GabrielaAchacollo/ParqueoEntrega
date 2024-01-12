<?php
  $ruta="../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/solicitud.php");
  $solicitud=new solicitud;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
   $fechaHoy=date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="LISTA DE SOLICITUDES";
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
          $idmenu=1042;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
            <div class="row">
              <div class="col s12 m8 l8" style="background: white; text-align: center; color:#1C2637; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                <?php echo $hd_titulo; ?>
              </div>
              <div class="col s12 m4 l4" style="background: white; text-align: center; color:#1C2637; border-radius: 5px; border: #CBCBCB 1px solid">
                <a href="nuevo/" class="btn waves-effect darken-4 blue"><i class="fa fa-plus-square-o"></i> NUEVO</a>
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
                      <th>Cod</th>
                      <th>Conductor</th>
                      <th>Carnet</th> 
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Tipo</th>
                      <th>Placa</th> 
                      <th>Modelo</th>
                      <th>Color</th>
                      <th>Estado</th>
                      <th>Descripción</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Cod</th>
                      <th>Conductor</th> 
                      <th>Carnet</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Tipo</th>
                      <th>Placa</th> 
                      <th>Modelo</th>
                      <th>Color</th>
                      <th>Estado</th>
                      <th>Descripción</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $contar=0;
                    foreach($solicitud->mostrarTodo("") as $f)
                    {
                                        
                      $lblcode=ecUrl($f['idsolicitud']);
                      $persol=$persona->muestra($f['idpersona']);
                      $contar++;

                      switch ($f['tipo']) {
                        case '0':
                          $tipo='NO PROGRAMADO';
                          break;
                        
                        case '1':
                          $tipo='PROGRAMADO';
                          break;
                      }
                      switch ($f['estado']) {
                        case '0':
                          $estado='PENDIENTE';
                          $estilo='background:#BDE6D5';
                          break;
                        
                        case '1':
                          $estado='INGRESO';
                          $estilo='';
                          break;

                          case '2':
                          $estado='FINALIZADO';
                          $estilo='';
                          break;

                          case '3':
                          $estado='CANCELADO';
                          $estilo='background:#E3BABA';
                          break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['idsolicitud'] ?></td>
                      <td><?php echo $persol['nombre'].' '.$persol['paterno'].' '.$persol['materno'] ?></td>
                      <td><?php echo $persol['carnet'].' '.$persol['expedido'] ?></td>
                      <td><?php echo $f['fecha'] ?></td>
                      <td><?php echo $f['hora'] ?></td>
                      <td><?php echo $tipo ?></td>
                      <td><?php echo $f['placa'] ?></td>
                      <td><?php echo $f['modelo'] ?></td>
                      <td><?php echo $f['color'] ?></td>
                      <td><?php echo $estado ?></td>
                      <td><?php echo $f['descripcion'] ?></td>
                      <td>
                        <?php
                          if ($f['estado']==0) 
                          {
                            ?>
                            <button class="btn-jh waves-effect darken-4 cyan" onclick="abrir('<?php echo $f['idsolicitud'] ?>');"><i class="fa fa-remov"></i> Aceptar</button> 
                           
                        <button class="btn-jh waves-effect darken-4 red" onclick="cancelar('<?php echo $f['idsolicitud'] ?>');"><i class="fa fa-remov"></i> Cancelar</button>
                         <a href="editar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 orange"><i class="fa fa-pencil-square"></i> editar</a>
                        <?php
                          }
                         ?> 
                        
                        
                       
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
            <!-- CREDITOS  -->
          
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
        "order": [[ 0, "desc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
         
    });
    //0=fecha actual dia
    //1=fecha cambiado
  function cancelar(id)
  {
     swal({
                  title: "¿Esta seguro?",
                  text: "Cancelar la colicitud",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "Si, estoy seguro",
                   closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                 // var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "eliminar.php",
                    type: "POST",
                    data: "idsolicitud="+id,
                    success: function(resp){
                      //alert(resp);
                      setTimeout(function(){     
                          console.log(resp);
                          $('#idresultado').html(resp);   
                        }, 1000);
                    }
                  }); 
                });
  }
    </script>
  }
</body>

</html>