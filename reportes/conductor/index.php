<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."funciones/funciones.php");
  session_start();


  $idus=$_SESSION["codusuario"];
  $lblcode=ecUrl($idus);  
  //$mesAnteriorInicio= date("Y-m-01",strtotime($fecha_actual."- 1 month"));
  $mesInicio= date("Y-m-01");
  $mesFin= date("Y-m-d");
              
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="LISTADO GENERAL DE CONDCUTOR";
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
          $idmenu=1087;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                 <!-- <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php //echo $hd_titulo; ?></h5> -->
                  <div class="col s12 m12 l12" align="center" ><label style="color:#00BBC7; text-decoration:none; font-size:30px;"><?php echo $hd_titulo ?></label>
                       </div>
                </div>
              </div>
            </div>
          </div>
     
          <div class="container">
            <div class="section">
              <div class="row">
                     <div class="col s12 m12 l4">
                      &nbsp;
                     </div>
                    <div class="col s12 m12 l4"><!--green lighten-5-->
                      <div class="card-content">
                      <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                        <div class="input-field col s12 m12 l12"> 
                       
                        <div class="col s12 m12 l12" style="text-align: right;"> 
                         <button id="btnSave" onclick="generar2();" style="font-size: 18px; width: 100%;" class="btn-jh green"> Generar Reporte</button> 
                        </div>
                      </div>
                      </div>
                      </div> 
                      <div class="col s12 m12 l4">
                      &nbsp;
                      </div>
             
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
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });

function generar2()
{
  var lbl_us="<?php echo $lblcode ?>";
    popup=window.open('../pdf/conductor.php?lblcode='+lbl_us);
}
    </script>
</body>

</html>