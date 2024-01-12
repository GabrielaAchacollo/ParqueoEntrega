<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/admejecutivo.php");
  $admejecutivo=new admejecutivo;
  include_once($ruta."class/estacionamiento.php");
  $estacionamiento=new estacionamiento;
  include_once($ruta."class/movimiento.php");
  $movimiento=new movimiento;
  include_once($ruta."class/persona.php");
  $persona=new persona;
   include_once($ruta."class/categoria.php");
  $categoria=new categoria;
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
      $hd_titulo="LISTA GENERAL DE ESTACIONAMIENTO";
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
          $idmenu=1096;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row " >
              <div class="col s12 m12 l12" style="background: white; text-align: center; color:#0087AF; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
              <!-- <div class="col s12 m2 l2" >
                <a href="nuevo/" class="btn waves-effect darken-4 blue"><i class="fa fa-plus"></i> NUEVO</a>
                
              </div>-->
               <div class="col s12 m12 l12"><?php echo $hd_titulo; ?></div>
              </div>
              
              </div>
            </div>
          </div>
     
          <div class="container">
            <div class="section">
              <div class="row" >
              <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">

                <?php
                $contar=0;
                foreach($estacionamiento->mostrarTodo("estado=1") as $f)
                {
                  //DEFINIR CLINETE EN RESERVA
                   $esta=$estacionamiento->mostrarUltimo("idestacionamiento=".$f['idestacionamiento']." and estadolugar=2");
                      
                      $idmovimiento=0;
                      if (count($esta)>0) 
                      {
                        $movi=$movimiento->mostrarUltimo("idestacionamiento=".$f['idestacionamiento']." and estado=1");
                        $idmovimiento=$movi['idmovimiento'];
                        $tar=$tarjeta->muestra($movi['idtarjeta']);
                        $vadm=$vadmejecutivo->muestra($tar['idadmejecutivo']);
                        //$perres=$persona->muestra($vadm['idpersona']);
                        $clienteRes=$vadm['nombre'].' '.$vadm['paterno'].' CI:'.$vadm['carnet'].$vadm['expedido'];
                       
                      }else{
                        $clienteRes='';
                      }
                       $cat=$categoria->muestra($f['idcategoria']);
                      switch ($f['estadolugar']) {
                        case '0':
                          $reserva="LIBRE";
                          $estilores="background-color: #AFDDB8;";
                          $colorcaja="waves-light green";
                        break;
                        case '1':
                          $reserva="RESERVADO";//
                          $estilores="background-color: #AAEDFC;";
                        break;
                        case '2':
                          $reserva="OCUPADO";
                          $estilores="background-color: #FCCFAA;";
                          $colorcaja="waves-light blue";
                        break;
                      }
                  ?>
                    <div class="col s3 m3 l2">
                        <div class="card">
                            <div class="card-content <?php echo $colorcaja ?> white-text" style="text-align: center;">
                                <p class="card-stats-title" style="font-size: 15px;"><i class="mdi-social-group-add"></i> <?php echo $cat['nombre'] ?></p>
                                <h4 class="card-stats-number">Nro.<?php echo $f['nombre'] ?></h4>
                                <p class="card-stats-compare"><span class="blue-grey-text text-lighten-5"><?php echo $f['descripcion'] ?></span>
                                </p>
                            </div>
                            <div class="card-action  blue-grey darken-2" style="text-align: center;">
                                <div class="center-align" style="<?php echo $estilores ?>"><?php echo $reserva ?></div>
                                <div class="center-align" style="<?php echo $estilores ?>"><?php echo $clienteRes ?></div>
                                 <?php
                        switch ($f['estadolugar']) {
                            case '0':
                            ?>
                             <a href="#modal2" class="btn waves-effect waves-light green modal-trigger " style="color:white;" onclick="cargarDatos('<?php echo $f['idestacionamiento'] ?>','<?php echo $f['nombre'] ?>','<?php echo $cat['nombre'] ?>','<?php echo $f['descripcion'] ?>');"><i class="fa fa-plus-square"></i> Ingreso Sin tarjeta</a>
                              <?php
                            break;
                            case '2':
                              ?>
                              <button class="btn waves-effect waves-light blue" style="color:white;" onclick="finalizarreserva('<?php echo $idmovimiento ?>','<?php echo $f['idestacionamiento'] ?>');"><i class="fa fa-edit (alias)"></i> Salidad Sin tarjeta</button>
                              <?php
                            break;
                            case '1':
                              ?>
                               <button class="btn waves-effect waves-light orange" style="color:white;"><i class="fa fa-edit (alias)"></i> Habilitar libre</button>
                              <?php
                            break;
                          }
                         ?>
                            </div>
                        </div>
                    </div>    
                  <?php
                  $contar++;
                  if ($contar==6)
                  {
                    $contar=0;
                    ?>
                    <div class="col s12 m12 l12">&nbsp;</div>
                    <?php
                  }
                }
                ?>
               
              </div>
              </div>
            </div>     
            </div>
            <div class="container">
            <div class="section">           
                <div id="modal2" class="modal">
                  <div class="modal-content">
                    <form class="col s12" id="idformp" action="return false" onsubmit="return false" method="POST">
                        <input type="hidden" name="idpersonaImp" id="idpersonaImp" value="">
                        <input type="hidden" name="idflag" id="idflag" value="">
                        <input type="hidden" name="idmesasel" id="idmesasel">
                      <div id="smstext" style="font-size:18px;" align="center"></div>
                       <div class="row">                
                              <div class="col s12 m12 l12">
                              <fieldset class="informacion">
                                    <legend><div class="titulo"><strong>DATOS DE ESTACIONAMIENTO</strong> </div></legend>
                                    <div class="row">
                                      <div class="input-field col s12 m6 l6">
                                        <input id="idnumeromesa" name="idnumeromesa" style="font-size:25px; color:#411C8A" type="text" readonly class="validate">
                                        <label for="idnumeromesa">Nro Lugar</label>
                                      </div>
                                      <div class="input-field col s12 m6 l6">
                                        <input id="idcantidadsilla" name="idcantidadsilla" style="font-size:25px; color:#411C8A" type="text" readonly class="validate">
                                        <label for="idcantidadsilla">Categoria</label>
                                      </div>
                                      <div class="input-field col s12 m12 l12">
                                        <input id="iddescripcion" name="iddescripcion"  style="font-size:25px; color:#411C8A" type="text" readonly class="validate">
                                        <label for="iddescripcion">Descripción</label>
                                      </div>
                                    </div>
                              </fieldset> 
                              </div>
                        </div>
                        <div class="row">                
                              <div class="col s12 m12 l12">
                              <fieldset class="informacion">
                                    <legend><div class="titulo"><strong>Datos de Cliente</strong> </div></legend>
                                    <div class="row purple-text" style="font-size:18px; color:#566573">
                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s6">
                          <input id="idcarnet" name="idcarnet" onchange="cargarCI();" type="text" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s2">
                            <button class="btn-jh waves-effect waves-light darken-4 blue" onclick="cargarCI2();"><i class="fa fa-search"></i></button>
                          </div>
                        
                        <div class="input-field col s4">
                          <label>Expedido</label>
                          <select id="idexp" name="idexp">
                            <option disabled value="">Seleccionar Departamento</option>
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idnombre" name="idnombre" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idpaterno" name="idpaterno" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idmaterno" name="idmaterno" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div> 
                        <div class="input-field col s12 m12 l4">
                          <input id="idcelular" name="idcelular" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                                    </div>
                              </fieldset> 
                              </div>
                        </div>
                       
                    </form>
                  </div>
                  <div class="modal-footer">
                   <!-- <a id="btnLimpiar" onclick="limpiar();" class="btn waves-effect waves-light red"><i class="fa fa-clear"></i> Limpiar</a> 
                          <a id="btnSavep" class="btn waves-effect waves-light orange"><i class="fa fa-save"></i> Guardar</a>-->
                           <button class="btn waves-effect waves-light orange" onclick="guardarSocio();">Guardar</button>
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
            //'copy', 'csv', 'excel', 'pdf', 'print'
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
    //0=fecha actual dia
    //1=fecha cambiado

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
function cargarDatos(idmesa,nromesa,cantidadsilla,descripcion)
{
  $('#idmesasel').val(idmesa);
  $('#idnumeromesa').val(nromesa);
  $('#idcantidadsilla').val(cantidadsilla);
  $('#iddescripcion').val(descripcion);
}
function cargarCI()
{ 
  var carnet = $("#idcarnet").val();

   var idmesa = $('#idmesasel').val();
  if (carnet!='') 
  {
    $.ajax({
            async: true,
            url: "cargarpersona.php?carnet="+carnet+"&idmesa="+idmesa,
            type: "get",
            dataType: "html",
            success: function(data){
              var json = eval("("+data+")");

               $("#idflag").val(json.tipo);
               $("#idpersonaImp").val(json.idpersonaImp);
               $("#idexp").val(json.expedido);
               $("#idnombre").val(json.nombre);
               $("#idpaterno").val(json.paterno);
               $("#idmaterno").val(json.materno);
               //$("#idnacimiento").val(json.fechanac);
              // $("#idemail").val(json.email);
               $("#idcelular").val(json.celular);
              // $("#idsexo").val(json.sexo);
             //  $("#idocupacion").val(json.ocupacion);

            //   $("#idzona").val(json.zona);
            //   $("#iddireccion").val(json.direccion);
            //   $("#idfono").val(json.telefono);
            }
          });
 
  }else{
    $("#idflag").val('');
  }
}
function cargarCI2()
{ 
  var carnet = $("#idcarnet").val();

   var idmesa = $('#idmesasel').val();
  if (carnet!='') 
  {
    $.ajax({
            async: true,
            url: "cargarpersona.php?carnet="+carnet+"&idmesa="+idmesa,
            type: "get",
            dataType: "html",
            success: function(data){
              var json = eval("("+data+")");

               $("#idflag").val(json.tipo);
               $("#idpersonaImp").val(json.idpersonaImp);
               $("#idexp").val(json.expedido);
               $("#idnombre").val(json.nombre);
               $("#idpaterno").val(json.paterno);
               $("#idmaterno").val(json.materno);
               //$("#idnacimiento").val(json.fechanac);
              // $("#idemail").val(json.email);
               $("#idcelular").val(json.celular);
              // $("#idsexo").val(json.sexo);
             //  $("#idocupacion").val(json.ocupacion);

            //   $("#idzona").val(json.zona);
            //   $("#iddireccion").val(json.direccion);
            //   $("#idfono").val(json.telefono);
            }
          });
 
  }else{
    $("#idflag").val('');
  }
}
function guardarSocio()
{
 
         var flag = $("#idflag").val();

         if (flag==3) 
          {
               swal("Error","La persona ya tiene una reserva","error");
          }else if(flag==4){
              swal("Error","La persona Ya tiene una reserva en proceso","error");
          }else{
            // alert(flag);
              var nombreVal1 = $("#idnombre").val();
                var carnetVal1 = $("#idcarnet").val();
                if (nombreVal1 == '' || carnetVal1 == '') 
                {
                   swal("Error","DATOS FALTANTES","error");
                }else {
                  swal({
                    title: "CONFIRMACION",
                    text: "Realizar reserva ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#FF7E02",
                    confirmButtonText: "RESERVAR",
                    closeOnConfirm: false
                  }, function () {
                    var str = $( "#idformp" ).serialize();
                   //alert(str);
                    $.ajax({
                      url: "guardarp.php",
                      type: "POST",
                      data: str,
                      success: function(resp){
                        console.log(resp);
                         $("#idresultado").html(resp);
                      }
                    }); 
                  });
                }
          }
}
function finalizarreserva(idmesareserva,idmesa)
{
              swal({
                    title: "CONFIRMACION",
                    text: "Finalizar reserva ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#FF7E02",
                    confirmButtonText: "FINALIZAR",
                    closeOnConfirm: false
                  }, function () {
                    //var str = $( "#idformp" ).serialize();
                   //alert(str);
                    $.ajax({
                      url: "finalizarres.php",
                      type: "POST",
                      data: "idmesareserva="+idmesareserva+"&idmesa="+idmesa,
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
      data: "idindividualcredito="+id+"&impres="+impresion,
      success: function(resp){
        console.log(resp);
        $('#idresultado').html(resp);
      }
    });  
   
}
    </script>
</body>

</html>