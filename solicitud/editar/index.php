<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/categoria.php");
  $categoria=new categoria;
  include_once($ruta."class/solicitud.php");
  $solicitud=new solicitud;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."funciones/funciones.php");
  session_start();  

   extract($_GET);

  $valor=dcUrl($lblcode);
   $sol=$solicitud->muestra($valor);
   $dper=$persona->muestra($sol['idpersona']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ACTUALIZAR DATOS DE SOLICITUD";
      include_once($ruta."includes/head_basico.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1041;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row " >
                <div class="col s12 m12 l2">&nbsp;</div>
              <div class="col s12 m12 l8" style="background: white; text-align: center; color:#1C2637; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                <?php echo $hd_titulo; ?>
              </div>
              <div class="col s12 m12 l2">&nbsp;</div>
              
                    
              </div>
              
            </div>
          </div>
           
           <div class="row section">
        <div class="col s12 m12 l2">&nbsp;</div>
        <div class="col s12 m12 l8">               
           <div class="col s12 m12 l12">
            <div id="persona" class="col s12 m12 l12  "><!-- blue lighten-4 -->
                 <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <div class="col s12 m12 l12">
                    <div class="formcontent">  
                      <div class="row" style="font-size: 18px; border-radius: 5px; border:#CBCBCB 1px solid;">
                        <input type="hidden" name="idpersonaImp" id="idpersonaImp" value="<?php echo $sol['idpersona'] ?>">
                        <input type="hidden" name="idsolicitud" id="idsolicitud" value="<?php echo $valor ?>">
                      <div id="smstext" style="font-size:18px;" align="center"></div>
                      <div class="input-field col s12 m12 l12"> DATOS DE CONDUCTOR</div>
                     
                       <div class="input-field col s12 m8 l8">
                          <input id="idcarnet" readonly name="idcarnet" value="<?php echo $dper['carnet'] ?>" onchange="cargarCI();" type="text" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <label>Expedido</label>
                          <select id="idexp" name="idexp">
                            <option disabled value="">Seleccionar Departamento</option>
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                $sw="";
                                if ($dper['expedido']==$f['short']) {
                                   $sw="selected";
                                }
                                ?>
                                  <option <?php echo $sw ?> value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idnombre" name="idnombre" value="<?php echo $dper['nombre'] ?>" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idpaterno" name="idpaterno" value="<?php echo $dper['paterno'] ?>" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idmaterno" name="idmaterno" value="<?php echo $dper['materno'] ?>" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idcelular" name="idcelular" value="<?php echo $dper['celular'] ?>" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s12 m12 l12"> DATOS DE SOLICITUD</div>
                        <div class="input-field col s12 m4 l4">

                          <label>Tipo</label>
                          <select id="idtipo" name="idtipo">
                            <option <?php if($sol['tipo']==1) echo "selected"; ?> value="1">PROGRAMADO</option>
                            <option <?php if($sol['tipo']==0) echo "selected"; ?> value="0">NO PROGRAMADO</option>
                          </select>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idfecha" name="idfecha" value="<?php echo $sol['fecha'] ?>" type="date" class="validate">
                          <label for="idfecha">Date</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idhora" name="idhora" value="<?php echo $sol['hora'] ?>" type="time" class="validate">
                          <label for="idhora">Hora</label>
                        </div>
                         
                        <div class="input-field col s12 m4 l4">
                          <input id="idplaca" name="idplaca" value="<?php echo $sol['placa'] ?>" type="text" class="validate">
                          <label for="idplaca">Placa</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idmodelo" name="idmodelo" value="<?php echo $sol['modelo'] ?>" type="text" class="validate">
                          <label for="idmodelo">Modelo</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idcolor" name="idcolor" value="<?php echo $sol['color'] ?>" type="text" class="validate">
                          <label for="idcolor">Color</label>
                        </div>
                        <div class="input-field col s12 m12 l12">
                          <input id="iddescripcion" name="iddescripcion" value="<?php echo $sol['descripcion'] ?>" type="text" class="validate">
                          <label for="iddescripcion">Descripción</label>
                        </div>
                         <div class="input-field col s12 m12 l12" align="right">
                        <a href="../" class="btn-jh waves-effect waves-light darken-4 red"><i class="fa fa-mail-reply-all"></i> Volver</a>
                          <a id="btnLimpiar" onclick="limpiar();" class="btn-jh waves-effect waves-light grey"><i class="fa fa-file-o"></i> Limpiar</a>
                          <a id="btnSave" class="btn-jh waves-effect waves-light darken-4 blue"><i class="fa fa-save"></i> Actualizar</a>
                        </div>                      
                      </div>
                </div>
              </form>
            </div>           
          </div>

        </div>
        <div class="col s12 m12 l2">&nbsp;</div>


            </div> 
          <?php
           // include_once("../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      function cargarCI()
{ 
  var carnet = $("#idcarnet").val();
  if (carnet!='') 
  {
    $.ajax({
            async: true,
            url: "cargarpersona.php?carnet="+carnet,
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
               $("#idcelular").val(json.celular);
            }
          });
 
  }else{
    $("#idflag").val('');
  }
}
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
        if (validar()) 
        {          
                swal({
                  title: "¿Esta seguro?",
                  text: "Actualizar datos",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "Registrar",
                   closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                  var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "actualizar.php",
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
      });
function validar(){
        retorno=true;
        carnet=$('#idcarnet').val();
        nombre=$('#idnombre').val();
        placa=$('#idplaca').val();
        fech=$('#idfecha').val();
        hor=$('#idhora').val();
        if(nombre=="" || carnet=="" || placa=="" || fech=="" || hor==""){
          retorno=false;
        }
        return retorno;
      }
    function limpiar()
      {
          document.getElementById("idform").reset();
      }
    </script>
</body>

</html>