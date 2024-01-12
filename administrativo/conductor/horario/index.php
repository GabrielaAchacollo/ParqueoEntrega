<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/categoria.php");
  $categoria=new categoria;
  include_once($ruta."class/transporte.php");
  $transporte=new transporte;
  include_once($ruta."class/carrera.php");
  $carrera=new carrera;
  include_once($ruta."class/docente.php");
  $docente=new docente;
  include_once($ruta."class/diasconfig.php");
  $diasconfig=new diasconfig;
  include_once($ruta."class/horario.php");
  $horario=new horario;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
  extract($_GET);
   $fechaHoy=date('Y-m-d');
   $idadmejecutivo=dcUrl($lblcode);
   $vdeje=$vadmejecutivo->muestra($idadmejecutivo);
   $doc=$docente->mostrarUltimo("idadmejecutivo=".$idadmejecutivo);
   $car=$carrera->muestra($doc['idcarrera']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ASIGNACIÓN DE HORARIOS";
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
              <div class="row">
                <div class="col s12 m12 l12" style="background: #f4b00f; text-align: center; color:#032049; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                
                         
                        <a href="../" class="btn-jh waves-effect waves-light darken-4 red"><i class="fa fa-mail-reply-all"></i> </a><?php echo $hd_titulo; ?>
              </div>
              </div>
              
            </div>
          </div>
  <div class="container">
    <div class="section">
      <div class="row" >
        <div class="col s12 m12 l12">
          <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                  <div class="col s12 m12 l12" style="text-align: center; font-size: 18px;">
                    Tipo:<b><?php echo $vdeje['tiponombre'] ?></b>
                    Conductor:<b><?php echo $vdeje['nombre'].' '.$vdeje['paterno'].' '.$vdeje['materno'] ?></b>
                    Carnet:<b><?php echo $vdeje['carnet'].' '.$vdeje['expedido'] ?></b>
                    Carrera:<b><?php echo $car['nombre'] ?></b>
                  </div>
           </div>
        </div> 
        <div class="col s12 m12 l12">
          <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                  <div class="col s12 m12 l12" style="text-align: center;">
                    <div id="card-stats" class="seaction">
              <p style="color: #048061;"> Horarios que puede ingresar un docente de acuerdo a su horario.</p>
              <div class="row">
                <?php
                foreach($diasconfig->mostrarTodo("estado=1") as $dc)
                {
                  ?>
                  <div class="col s12 m6 l3">
                      <div class="card">
                          <div class="card-content  blue white-text">
                              <p class="card-stats-title"><i class="fa fa-calendar-o"></i> 
                                <?php echo strtoupper($dc['nombre']); ?> 
                                 <a href="#modal1" class="btn-jh waves-effect waves-light darken-4 orange indigo modal-trigger " onclick="cargadia('<?php echo $dc['iddiasconfig'] ?>','<?php echo $dc['nombre'] ?>');"> <i class="fa fa-plus-square-o"></i></a>
                               </p>
                              
                          </div>
                          <div class="card-action  blue darken-2" style="color: white;">
                            <div class="row">                            
                             <div class="col s12 m6 l4" style="background: #125599; color: #C4E1FF;">INICIO
                            </div>
                            <div class="col s12 m6 l4" style="background: #125599; color: #C4E1FF;">FIN
                            </div>
                            <div class="col s12 m6 l4" style="background: #125599; color: #C4E1FF;">Opción
                            </div>
                            <?php
                              foreach($horario->mostrarTodo("estado=1 and idadmejecutivo=".$idadmejecutivo." and iddiasconfig=".$dc['iddiasconfig']) as $f)
                              {
                                ?>
                                <div class="col s12 m6 l4"><?php echo $f['horainicio'] ?>
                                </div>
                                <div class="col s12 m6 l4"><?php echo $f['horafin'] ?>
                                </div>
                                <div class="col s12 m6 l4"><i class="fa fa-times" onclick="borrar('<?php echo $f['idhorario'] ?>');" style="cursor: pointer; color: orange;"> Eliminar</i>
                                </div>
                              <?php
                              }
                             ?>
                            
                            </div>
                          </div>
                      </div>
                  </div>
                <?php
                }
                 ?>
            </div>
                
            </div>
          </div>
          </div>
       </div> 
 
      </div>
    </div>
  </div>      
     
           <div class="container">
            <div class="section">           
                <div id="modal1" class="modal">
                  <div class="modal-content">
                   <div class="row " id="textodia" style="background: white; text-align: center; color:#1C2637; font-size: 25px; border-radius: 5px;">
                    Horario
                   </div>
                        <div class="col s12 m12 l12"  style="background-color: white;">
                          <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                            <input id="idadmejecutivo" name="idadmejecutivo" value="<?php echo $idadmejecutivo ?>"  type="hidden">
                         <input id="iddiasconfig" name="iddiasconfig"  type="hidden">
                       <div class="row">
                        <div class="input-field col s12 m6 l6">
                          <input id="idhorainicio" name="idhorainicio" type="time" class="validate">
                          <label for="idhorainicio">Hora Inicio:</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                          <input id="idhorafin" name="idhorafin" type="time" class="validate">
                          <label for="idhorafin">Hora Fin:</label>
                        </div>
                       </div>  
                      </form>
                        </div> 
                  </div>
                  <div class="modal-footer">

                    <a id="btnLimpiar" onclick="limpiar();" class="btn-flat modal-action modal-close darken-4 red" style="color: white;"><i class="fa fa-times"></i></a>
                    <a id="btnSave" class="btn waves-effect waves-light darken-4 blue"><i class="fa fa-save"></i> Asignar</a>
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
      $('#example3').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 2, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });   
    });
    function cargadia(id,dia)
    {
      $('#iddiasconfig').val(id);
      $('#textodia').text('Horario para el dia '+dia);
    }
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
        if (validar()) 
        {          
                swal({
                  title: "¿Esta seguro?",
                  text: "Se registrara nuevo",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "Registrar",
                   closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                  var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "guardar.php",
                    type: "POST",
                    data: str,
                    success: function(resp){
                      setTimeout(function(){     
                          console.log(resp);
                          $('#idresultado').html(resp);   
                        }, 1000);
                    }
                  }); 
                });
        }else{
          swal("ERROR","Ingrese los horarios","error");
        }
      });
function validar(){
        retorno=true;
        horin=$('#idhorafin').val();
        hofi=$('#idhorafin').val();
        if(horin=="" || hofi=="0"){
          retorno=false;
        }
        return retorno;
      }
    function limpiar()
      {
          document.getElementById("idform").reset();
      }
  function borrar(id)
  {
     swal({
                  title: "¿Esta seguro?",
                  text: "ALIMINAR",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "Si, estoy seguro",
                   closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                 // var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "borrar.php",
                    type: "POST",
                    data: "idhorario="+id,
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
</body>

</html>