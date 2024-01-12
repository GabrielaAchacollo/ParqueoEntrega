<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/grupo.php");
  $grupo=new grupo;
  include_once($ruta."class/ciclo.php");
  $ciclo=new ciclo;
   include_once($ruta."class/grupocredito.php");
  $grupocredito=new grupocredito;
  include_once($ruta."class/credito.php");
  $credito=new credito;
  include_once($ruta."class/creditodetalle.php");
  $creditodetalle=new creditodetalle;
  include_once($ruta."class/personagrupo.php");
  $personagrupo=new personagrupo;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/tipobanca.php");
  $tipobanca=new tipobanca;
  include_once($ruta."class/creditomov.php");
  $creditomov=new creditomov;
  include_once($ruta."class/miempresa.php");
  $miempresa=new miempresa;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/seguimiento.php");
  $seguimiento=new seguimiento;
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."class/tiposeguimiento.php");
  $tiposeguimiento=new tiposeguimiento;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);

  //echo devuelveEstado(estadoCredito('2018-05-26','2018-05-25'));


  //********* SEGURIDAD GET *************/
  $valor=dcUrl($lblcode);
  $cred=$credito->muestra($valor);
  $grucre=$grupocredito->muestra($cred['idgrupocredito']);
  $idgrupo=$grucre['idgrupo'];
  $gr=$grupo->muestra($grucre['idgrupo']);
  $rutaImg=$ruta."imagenes/logo.png";
  $demp=$miempresa->muestra(1);
  $dus=$usuario->muestra($cred["usuariocreacion"]);

  $per=$persona->muestra($cred["idpersona"]);
  $dom=$domicilio->mostrarUltimo("idpersona=".$cred["idpersona"]);
  $fecha=date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Seguimiento";
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
          $idmenu=1073;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <?php 
                switch ($cred['tipocredito']) 
                {
                  case '0':
                  $hd_titulo="Seguimiento de Socios en grupo con credito";
                  ?>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                    </div>
                  </div>
                    <?php
                    break;
                  
                  case '1':
                  $hd_titulo="Seguimiento de Socios de creditos individuales";
                  ?>
                    <div class="row " style="background: #7AAD4E; text-align: center; color:white; font-size: 25px; border-radius: 5px;">
                    <?php echo $hd_titulo; ?>
                    </div>
                    <?php
                    break;
                }
               ?>
              
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="row">
                <div class='col s12 m12 l12'>
                  <div class='col s12 m12 l4'>
                    <fieldset class="informacion">
                    <legend><div class="titulo"><strong>Persona</strong> </div></legend>
                      <div class="col s12 m12 l12">Nombre: <b><?php echo $per['nombre'].' '.$per['paterno'].' '.$per['materno'] ?></b></div>
                      <div class="col s12 m12 l12">Carnet: <b><?php echo $per['carnet'].' '.$per['expedido'] ?></b></div>
                      <div class="col s12 m12 l12">Celular: <b><?php echo $per['celular'] ?></b>
                      </div>
                      <div class="col s12 m12 l12">Referencia: <b><?php echo $dom['telefono'] ?></b>
                      </div>
                      <div class="col s12 m12 l12">Ocupación: <b><?php echo $per['ocupacion'] ?></b>
                      </div>
                  </fieldset>
                  <fieldset class="informacion">
                    <legend><div class="titulo"><strong>Domicilio</strong> </div></legend>
                      <div class="col s12 m12 l12">Zona: <b><?php echo $dom['idbarrio'] ?></b></div>
                      <div class="col s12 m12 l12">Dirección: <b><?php echo $dom['nombre'] ?></b></div>
                      <div class="col s12 m12 l12">Coordenadas: <b><?php echo $dom['coordenadas'] ?></b>
                      </div>
                  </fieldset>
                    </div>
                  <div class='col s12 m12 l8'>
                    <fieldset class="informacion">
                    <legend><div class="titulo"><strong>Registro de seguimiento</strong> </div></legend>
                    <div class='col s12 m12 l12' style="text-align: right;">
                    <a href="#modal1" class="btn waves-effect waves-light green modal-trigger"><i class="fa fa-plus-square"></i> Nuevo</a>
                    </div>
                    <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Nro</th>
                      <th>Respuesta de cliente</th> 
                      <th width="100">Fecha Registro</th> 
                      <th width="100">Fecha Compromiso</th>
                      <th width="100">Hr. Compromiso</th>
                      <th>Observación</th>
                      <th>Usuario</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $contar=0;
                    foreach($seguimiento->mostrarTodo("idcredito=".$valor) as $seg)
                    {
                        //$totalCuotaResto=number_format($totalCuotaResto, 2, '.', '');
                      $regus=$vusuario2->muestra($seg["usuariocreacion"]);
                      $contar++;
                      switch ($seg['respuestallamada']) {
                        case '1':
                          $respuesta='BUENA';
                          $estilo="color: #00AB4E;";
                          break;
                        
                        case '2':
                          $respuesta='REGULAR';
                          $estilo="color: #FF892D;";
                          break;
                        case '3':
                          $respuesta='MALA';
                          $estilo="color: #FF1E1E;";
                          break;  
                      }
                    ?>
                    <tr>
                      <td><?php echo $contar ?></td>
                      <td style="font-weight: bold;<?php echo $estilo ?>"><?php echo $respuesta ?></td>
                      <td><?php echo $seg['fecha'] ?></td>
                      <td><?php echo $seg['fechacompromiso'] ?></td>
                      <td><?php echo $seg['horacompromiso'] ?></td>
                      <td><?php echo $seg['observacion'] ?></td>
                      <td><?php echo $regus['nombre'] ?></td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
                  </fieldset>
                      </div>
                  
                  </div>
                  
                </div> 
              </div>
            </div> 
          </div> 
          <div class="container">
            <div class="section">
              <div class="row">
                <div id="modal1" class="modal">
                  <div class="modal-content">
                     <fieldset class="informacion">
                    <legend><div class="titulo"><strong>Registrar</strong> </div></legend>
                     <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <input id="idcredito" name="idcredito" type="hidden" value="<?php echo $valor ?>">
                        <div class="input-field col s12 m12 l12"   style="font-weight:bold;">
                          <p>Respuesta del cliente:</p>
                              <input class="with-gap" name="respuestallamada" value="1"  type="radio" id="respuestallamada1" />
                              <label for="respuestallamada1">BUENO</label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                              <input class="with-gap" name="respuestallamada" value="2" type="radio" id="respuestallamada2" />
                              <label for="respuestallamada2">REGULAR</label>
                               &nbsp;&nbsp;&nbsp;&nbsp;
                              <input class="with-gap" name="respuestallamada" value="3"  type="radio" id="respuestallamada3" />
                              <label for="respuestallamada3">MALA</label>
                                                   
                        </div>
                        
                         &nbsp;&nbsp;&nbsp;&nbsp;
                         <br>
                         <div class="input-field col s12 m3 l3">
                         <label>TIPO DE SEGUIMIENTO</label>
                          <select id="idtiposeguimiento" name="idtiposeguimiento">
                            <option value="0">Seleccionar</option>
                            <?php
                              foreach($tiposeguimiento->mostrarTodo("idtiposeguimiento!=4") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['idtiposeguimiento']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m3 l3">
                          <input id="idfecha" name="idfecha" type="date" value="<?php echo $fecha ?>" class="validate">
                          <label for="idfecha">Fecha Registro</label>
                        </div>
                        <div class="input-field col s12 m3 l3">
                          <input id="idfechacompromiso" name="idfechacompromiso" type="date"  class="validate">
                          <label for="idfechacompromiso">Fecha Compromiso</label>
                        </div>
                        <div class="input-field col s12 m3 l3">
                          <input id="idhoracompromiso" name="idhoracompromiso" type="time" value="00:00"  class="validate">
                          <label for="idhoracompromiso">Hora Compromiso</label>
                        </div>
                        <div class="input-field col s12 m12 l12">
                          <textarea id="iddetalle" name="iddetalle" class="materialize-textarea" length="500" class="validate"></textarea>
                          <label for="iddetalle">Descripción</label>
                        </div>
                         
                        
                       </form>
                       </fieldset>
                  </div>
                  <div class="modal-footer">
                    <div class="col s12 m12 l12" align="right">
                    <a href="#" class="btn waves-effect waves-light red modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                    
                          <button id="btnguardar" class="btn waves-effect waves-light green" onclick="guardar();"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                  </div>
                </div>
                 </div>
            </div> 
          </div>
          

          </div>
        </section>
      </div>
    </div>
    <?php
    /*
      foreach($credito->mostrarTodo("idgrupocredito=".$valor." and estadocobro=1") as $f)
      {
        echo " ".$f['idcredito'];
      }
      */
    ?>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
    function guardar()
    {
      if ($("#respuestallamada1").is(':checked') || $("#respuestallamada2").is(':checked') || $("#respuestallamada3").is(':checked'))
      {
            if (validar())
          { 
            var respuestallamada=$("input[name='respuestallamada']:checked").val();
               swal({
                title: "Estas Seguro?",
                text: "Guardar nuevo registro",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28e29e",
                confirmButtonText: "Estoy Seguro",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
              }, function () {
                var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "guardar.php",
                    type: "POST",
                    data: str+"&respuestallamada="+respuestallamada,
                    success: function(resp){
                      console.log(resp);
                      $("#idresultado").html(resp);
                    }
                  });
              });
          }else{
             swal("ALERTA !", "Verifique las fechas", "error");
          }
      }else{
                 swal("ALERTA !", "Respuesta del cliente", "error");
            }
       
    }
     function validar(){
        retorno=true;
        fecha=$('#idfecha').val();
        tiposeg=$('#idtiposeguimiento').val();
        fechacom=$('#idfechacompromiso').val();
        if(fecha=="" || fechacom=="" || tiposeg=="0"){
          retorno=false;
        }
        return retorno;
      }
    $("#idbtniniciar").click(function(){
      
    });
    $("#idbtncerrar").click(function(){
      swal({
        title: "Cerrar Cobro?",
        text: "Asegurate que todos hayan pagado, Esto generará registros de la cuota del grupo, tambien se actualizara la cuota",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      }, function () {
        var idgrupoc=$("#idgrupocredito").val();
        $.ajax({
          url: "cerrarCobro.php",
          type: "POST",
          data: "idgrupoc="+idgrupoc,
          success: function(resp){
            setTimeout(function(){     
              console.log(resp);
              $('#idresultado').html(resp);   
            }, 3000);
          }   
        });
      }); 
    });
    $("#idbtncerrarCiclo").click(function(){
      swal({
        title: "Cerrar Ciclo?",
        text: "Asegurate que todos hayan pagado, Esto generará registros de la cuota del grupo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      }, function () {
        var idgrupoc=$("#idgrupocredito").val();
        $.ajax({
          url: "cerrarCiclo.php",
          type: "POST",
          data: "idgrupoc="+idgrupoc,
          success: function(resp){
            setTimeout(function(){     
              console.log(resp);
              $('#idresultado').html(resp);   
            }, 5000);
          }   
        });
      }); 
    });
    </script>
</body>

</html>