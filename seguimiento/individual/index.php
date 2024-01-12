<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/individual.php");
  $individual=new individual;
  include_once($ruta."class/individualcredito.php");
  $individualcredito=new individualcredito;
  include_once($ruta."class/vindividualcredito.php");
  $vindividualcredito=new vindividualcredito;
  include_once($ruta."class/tipobanca.php");
  $tipobanca=new tipobanca;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/seguimiento.php");
  $seguimiento=new seguimiento;
  include_once($ruta."class/credito.php");
  $credito=new credito;
  include_once($ruta."funciones/funciones.php");
  session_start();  
  $fechaHoy=date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Lista de Socios con crédito individual - SEGUIMIENTO";
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
          $idmenu=1084;
          include_once($ruta."aside.php");
          $datoEje=$vadmejecutivo->mostrarUltimo("idpersona=".$idper." and estado=1");
           $idadmejecutivo=$datoEje['idvadmejecutivo'];
           $vgc=$vindividualcredito->mostrarTodo("idadmejecutivo=".$idadmejecutivo." and estado=1");
           if (count($vgc)>0) 
           {
             $consulta="SELECT *
                      FROM vindividualcredito
                      WHERE activo=1 and estado=1 and idadmejecutivo=$idadmejecutivo ORDER BY fechaproximo asc";
           }else{
              
            $consulta="SELECT *
            FROM vindividualcredito
            WHERE activo=1 and estado=1 ORDER BY fechaproximo asc";
           }
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row " style="background: #7AAD4E; text-align: center; color:white; font-size: 25px; border-radius: 5px;">
                    <?php echo $hd_titulo; ?>
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
                      <th>Socio(a)</th> 
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
                      <th>Socio</th>
                      <th>Fecha</th> 
                      <th>Hora reunión</th>
                      <th>Lugar</th>
                      <th>Asesor</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($vindividualcredito->sql($consulta) as $f)
                    {
                      $dgr=$individual->muestra($f['idindividual']);
                      $per=$persona->muestra($dgr['idpersona']);
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
                      $canTCred=$credito->mostrarPrimero("idgrupocredito=".$f['idvindividualcredito']." and tipocredito=1");
                      $lblcode=ecUrl($canTCred['idcredito']);
                      $lblcode2=ecUrl($f['idvindividualcredito']);
                      $seg=$seguimiento->mostrarTodo("idcredito=".$canTCred['idcredito']);
                      $cantSeg='';
                      if (count($seg)>0) 
                      {
                       $cantSeg="<b style='color:red; background-color:white; border-radius:8px;'> ".count($seg)." </b>";
                      }
                      if ($fechaHoy>=$f['fechaproximo']) 
                      {
                        $estilo="background-color: #FF4D00;";
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['idvindividualcredito'] ?></td>
                      <td><?php echo $per['nombre'].' '.$per['paterno'].' '.$per['materno'] ?></td>
                      <td><?php echo $f['fechaproximo'] ?></td>
                      <td><?php echo $dgr['horareunion'] ?></td>
                      <td><?php echo $dgr['lugarreunion'] ?></td>
                      <td><?php echo $eje['nombre'].' '.$eje['paterno'] ?></td>
                      <td>
                        <a href="<?php echo $ruta ?>seguimiento/grupos/cuotas/registro.php?lblcode=<?php echo $lblcode ?>&lblcode2=<?php echo $lblcode2 ?>" class="btn-jh waves-effect darken-4 blue"><i class="fa fa-list-alt"></i> Registrar <?php echo $cantSeg ?></a>
                       <!-- <a href="cuotas/?lblcode=<?php //echo $lblcode ?>" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-mdi-av-web"></i> Proceder</a>
                        -->
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