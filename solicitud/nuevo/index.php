<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/categoria.php");
  $categoria=new categoria;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."funciones/funciones.php");
  session_start();  

   extract($_GET);

 // $valor=dcUrl($lblcode);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="NUEVA SOLICITUD";
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
                        <input type="hidden" name="idpersonaImp" id="idpersonaImp" value="">
                        <input type="hidden" name="idflag" id="idflag" value="">
                      <div id="smstext" style="font-size:18px;" align="center"></div>
                      <div class="input-field col s12 m12 l12"> DATOS DE CONDUCTOR</div>
                     
                       <div class="input-field col s12 m8 l8">
                          <input id="idcarnet" name="idcarnet" onchange="cargarCI();" type="text" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
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
                        <div class="input-field col s12 m4 l4">
                          <input id="idnombre" name="idnombre" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idpaterno" name="idpaterno" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idmaterno" name="idmaterno" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idcelular" name="idcelular" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s12 m12 l12"> DATOS DE SOLICITUD</div>
                        <div class="input-field col s12 m4 l4">
                          <label>Tipo</label>
                          <select id="idtipo" name="idtipo">
                            <option value="1">PROGRAMADO</option>
                            <option value="0">NO PROGRAMADO</option>
                          </select>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idfecha" name="idfecha" type="date" class="validate">
                          <label for="idfecha">Date</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idhora" name="idhora" type="time" class="validate">
                          <label for="idhora">Hora</label>
                        </div>
                         
                        <div class="input-field col s12 m4 l4">
                          <input id="idplaca" name="idplaca" type="text" class="validate">
                          <label for="idplaca">Placa</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idmodelo" name="idmodelo" type="text" class="validate">
                          <label for="idmodelo">Modelo</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <input id="idcolor" name="idcolor" type="text" class="validate">
                          <label for="idcolor">Color</label>
                        </div>
                        <div class="input-field col s12 m12 l12">
                          <input id="iddescripcion" name="iddescripcion" type="text" class="validate">
                          <label for="iddescripcion">Descripción</label>
                        </div>
                         <div class="input-field col s12 m12 l12" align="right">
                        <a href="../" class="btn-jh waves-effect waves-light darken-4 red"><i class="fa fa-mail-reply-all"></i> Volver</a>
                          <a id="btnLimpiar" onclick="limpiar();" class="btn-jh waves-effect waves-light grey"><i class="fa fa-file-o"></i> Limpiar</a>
                          <a id="btnSave" class="btn-jh waves-effect waves-light darken-4 blue"><i class="fa fa-save"></i> Guardar</a>
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