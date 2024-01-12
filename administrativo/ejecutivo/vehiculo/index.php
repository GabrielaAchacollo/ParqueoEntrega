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
  include_once($ruta."class/transporteasig.php");
  $transporteasig=new transporteasig;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
  extract($_GET);
   $fechaHoy=date('Y-m-d');
   $idadmejecutivo=dcUrl($lblcode);
   $vdeje=$vadmejecutivo->muestra($idadmejecutivo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ASIGNACIÓN DE VEHICULO";
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
                <?php echo $hd_titulo; ?>
              </div>
              </div>
              
            </div>
          </div>
  <div class="container">
    <div class="section">
      <div class="row" >
        <div class="col s12 m4 l4">
          <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: #f4b00f;">
                  <div class="col s12 m12 l12" style="text-align: center;">
                    Tipo:<b><?php echo $vdeje['tiponombre'] ?></b><br>
                    Conductor:<b><?php echo $vdeje['nombre'].' '.$vdeje['paterno'].' '.$vdeje['materno'] ?></b><br>
                    Carnet:<b><?php echo $vdeje['carnet'].' '.$vdeje['expedido'] ?></b><br>
                  </div>
           </div>
        </div> 
        <div class="col s12 m8 l8">
              <div class="row" style="font-size: 18px; border-radius: 5px; border:#CBCBCB 1px solid;">
                <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idadmejecutivo" name="idadmejecutivo" value="<?php echo $idadmejecutivo ?>" type="hidden">
                   <input type="hidden" name="idtransporteImp" id="idtransporteImp" value="">
                   <input type="hidden" name="idflag" id="idflag" value="">
                        <div class="input-field col s12 m6 l6">
                          <input id="idplaca" name="idplaca" type="text" onchange="cargarPL();" class="validate">
                          <label for="idplaca">Placa:</label>
                        </div>
                         <div class="input-field col s12 m6 l6">
                          <label>Categoria</label>
                          <select id="idcategoria" name="idcategoria">
                            <option value="0">Seleccionar</option>
                            <?php
                              foreach($categoria->mostrarTodo("estado=1") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['idcategoria']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m6 l6">
                          <input id="idmodelo" name="idmodelo" type="text" class="validate">
                          <label for="idmodelo">Modelo:</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                          <input id="idcolor" name="idcolor" type="text" class="validate">
                          <label for="idcolor">Color:</label>
                        </div>
                        <div class="input-field col s12 m12 l12">
                          <input id="iddescripcion" name="iddescripcion" type="text" class="validate">
                          <label for="iddescripcion">Descripción</label>
                        </div>
                         <div class="input-field col s12 m12 l12" align="right">
                        <a href="../" class="btn-jh waves-effect waves-light darken-4 red"><i class="fa fa-mail-reply-all"></i> Volver</a>
                          <a id="btnSave" class="btn-jh waves-effect waves-light darken-4 blue" onclick="guardarvehi();"><i class="fa fa-save"></i> Asignar</a>
                        </div> 
                      </form>                     
               </div>

        </div> 
      </div>
    </div>
  </div>      
     
          <div class="container">
            <div class="section">
              <div class="row" >               
              <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                
                <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: #032049; color: white; text-align: center; font-size: 15px; font-weight: bold;">VEHICULO ASIGNADO
                  </div> 
                  <p style="color: green">Por persona solo un vehiculo puede ser activado</p>      
              <table id="" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Categoria</th>
                      <th>Placa</th> 
                      <th>Modelo</th> 
                      <th>Color</th>  
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th></th> 
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th> 
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $contar=0;
                     foreach($transporteasig->mostrarTodo("idadmejecutivo=".$idadmejecutivo) as $f)
                    {
                      $tra=$transporte->muestra($f['idtransporte']);
                      $cat=$categoria->muestra($tra['idcategoria']);                  
                      $lblcode=ecUrl($f['idtransporteasig']);
                      $contar++;
                      switch ($f['estado']) {
                        case '1':
                          $estad='ACTIVO';
                          $estilo='background:#E0FBE2;';
                          break;
                        
                        case '0':
                          $estad='DESCACTIVADO';
                          $estilo='';
                          break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $cat['nombre'] ?></td>
                       <td><?php echo $tra['placa'] ?></td>
                       <td><?php echo $tra['modelo'] ?></td>
                       <td><?php echo $tra['color'] ?></td>
                      <td><?php echo $estad ?></td>
                      <td>
                        <?php
                              if ($f['estado']==0) 
                              {
                                ?>
                                <button class="btn-jh waves-effect darken-4 blue" onclick="activar('<?php echo $f['idtransporte'] ?>');"><i class="fa fa-square-o"></i> Activar</button>
                                <?php
                              }else{
                                 ?>
                                <i class="fa fa-check-square-o" style="font-size: 20px;"></i>
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

    function limpiar()
      {
          document.getElementById("idform").reset();
      }
function activar(id){
  idamdeje='<?php echo $idadmejecutivo ?>';
  //alert(id);
      swal({
        title: "Estas Seguro?",
        text: "Activar como vehiculo de uso",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false,
        showLoaderOnConfirm: true
      }, function () {      
        $.ajax({
          url: "activar.php",
          type: "POST",
          data: "idtransporte="+id+"&idadmejecutivo="+idamdeje,
          success: function(resp){
            setTimeout(function(){     
              console.log(resp);
              $('#idresultado').html(resp);   
            }, 1000);
          }   
        });
      }); 
    }
function reactivar(id){
      swal({
        title: "Estas Seguro?",
        text: "Reasignar",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "reactivar.php",
          type: "POST",
          data: "idasignar="+id,
          success: function(resp){
            console.log(resp);
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
function cargarPL()
{ 
  var pla = $("#idplaca").val();
   //alert(pla);
  if (pla!='') 
  {
    $.ajax({
            async: true,
            url: "cargarplaca.php?idplaca="+pla,
            type: "get",
            dataType: "html",
            success: function(data){
              var json = eval("("+data+")");

               $("#idflag").val(json.tipo);
               $("#idtransporteImp").val(json.idtransporteImp);
               $("#idcategoria").val(json.idcategoria);
               $("#idcategoria").material_select();

              // $("#idplaca").val(json.placa);
               $("#idmodelo").val(json.modelo);
               $("#idcolor").val(json.color);
               $("#iddescripcion").val(json.descripcion);
            }
          });
 
  }else{
    $("#idflag").val('');
  }
}

  function guardarvehi()
  {
    var flag = $("#idflag").val();
    if (flag==4) 
          {
               swal("Error","El nro de placa ya se encuentra asignado","error");
          }else{ 
                if (validar()) 
                {          
                        swal({
                          title: "¿Esta seguro?",
                          text: "Se asignara el vehículo",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#2c2a6c",
                          confirmButtonText: "SI",
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
                  swal("ERROR","Complete con datos","error");
                }
          }
  }  
     
function validar(){
        retorno=true;
        cat=$('#idcategoria').val();
        pla=$('#idplaca').val();
        if(pla=="" || cat=="0"){
          retorno=false;
        }
        return retorno;
      }
    </script>
</body>

</html>