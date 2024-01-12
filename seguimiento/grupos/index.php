<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/grupo.php");
  $grupo=new grupo;
  include_once($ruta."class/grupocredito.php");
  $grupocredito=new grupocredito;
  include_once($ruta."class/vgrupocredito.php");
  $vgrupocredito=new vgrupocredito;
  include_once($ruta."class/tipobanca.php");
  $tipobanca=new tipobanca;
  include_once($ruta."funciones/funciones.php");
  session_start();  
  $fechaHoy=date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Lista de grupos con crédito - SEGUIMIENTO";
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
          $idmenu=1074;
          include_once($ruta."aside.php");
          $datoEje=$vadmejecutivo->mostrarUltimo("idpersona=".$idper." and estado=1");
           $idadmejecutivo=$datoEje['idvadmejecutivo'];
           $vgc=$vgrupocredito->mostrarTodo("idadmejecutivo=".$idadmejecutivo." and estado=1");
           if (count($vgc)>0) 
           {
             $consulta="SELECT *
                      FROM vgrupocredito
                      WHERE activo=1 and estado=1 and idadmejecutivo=$idadmejecutivo ORDER BY fechaproximo ASC";
           }else{
              
            $consulta="SELECT *
            FROM vgrupocredito
            WHERE activo=1 and estado=1 ORDER BY fechaproximo ASC";
           }
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
     
          <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Cod</th>
                      <th>Grupo</th> 
                       <th>Fecha</th> 
                      <th>Hora reunión</th>
                      <th>Lugar</th>
                      <th>Asesor</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Cod</th>
                      <th>Grupo</th>
                      <th>Fecha</th> 
                      <th>Hora reunión</th>
                      <th>Lugar</th>
                      <th>Asesor</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($vgrupocredito->sql($consulta) as $f)
                    {
                      $dgr=$grupo->muestra($f['idgrupo']);
                      $tba=$tipobanca->muestra($f['idtipobanca']);
                      switch ($f['estado']) {
                        case '0':
                          $estilo="background-color: #FDEDEC;";
                        break;
                        case '1':
                          $estilo="background-color: #EAFAF1;";
                        break;
                      }
                      $eje=$vadmejecutivo->muestra($f['idadmejecutivo']);
                      $lblcode=ecUrl($f['idvgrupocredito']);
                      if ($fechaHoy>=$f['fechaproximo']) 
                      {
                        $estilo="background-color: #FF4D00;";
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['idvgrupocredito'] ?></td>
                      <td><?php echo $dgr['nombre'] ?></td>
                      <td><?php echo $f['fechaproximo'] ?></td>
                      <td><?php echo $dgr['horareunion'] ?></td>
                      <td><?php echo $dgr['lugarreunion'] ?></td>
                      <td><?php echo $eje['nombre'].' '.$eje['paterno'] ?></td>
                      <td>
                        <a href="cuotas/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-mdi-av-web"></i> Proceder</a>
                        
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
        "order": [[ 2, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
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
function guardarimpresion(id)
{
//alert(id); 
  if($("#"+id).is(':checked')) 
  {  
      //alert("Está activado");
      var impresion= 1;  
  }else{  
      var impresion= 0;   
  }
  $.ajax({
      url: "impresion.php",
      type: "POST",
      data: "idgrupocredito="+id+"&impres="+impresion,
      success: function(resp){
        console.log(resp);
        $('#idresultado').html(resp);
      }
    });  
   
}
    </script>
</body>

</html>