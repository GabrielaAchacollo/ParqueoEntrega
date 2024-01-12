<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/rol.php");
  $rol=new rol;
   include_once($ruta."class/carrera.php");
  $carrera=new carrera;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);

$valor=dcUrl($lblcode);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Docente";
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
          $idmenu=1094;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
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
                      <div class="row">
                      
                      <div class="input-field col s12 m12 l8">
                          <input id="idcarnet" name="idcarnet" readonly type="text" value="<?php echo $valor ?>" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
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
                          <input id="idnacimiento" name="idnacimiento" type="date" class="validate">
                          <label for="idnacimiento">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idemail" name="idemail" type="email" class="validate">
                          <label for="idemail">Email</label>
                        </div>  
                        <div class="input-field col s12 m12 l4">
                          <input id="idcelular" name="idcelular" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <label>Sexo</label>
                          <select id="idsexo" name="idsexo">
                              <option value="1">MASCULINO</option>
                              <option value="2">FEMENINO</option>
                          </select>
                        </div>
                        <div class="input-field col s12 m12 l8">
                          <input id="idocupacion" name="idocupacion" type="text" value="DOCENTE" class="validate">
                          <label for="idocupacion">Ocupacion</label>
                        </div>
                                                  
                      </div>
                    DATOS DOMICILIARIOS
                <div class="divider">   </div>
                          <div class="row">
                        <div class="input-field col s12 m12 l4">
                          <input id="idzona" name="idzona"  type="text" class="validate">
                          <label for="idzona">Zona</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="iddireccion" name="iddireccion" type="text" class="validate">
                          <label for="iddireccion">Direccion</label>
                        </div>
                        <div class="input-field col s12 m12 l4">
                          <input id="idfono" name="idfono" type="text" class="validate">
                          <label for="idfono">telefono</label>
                        </div> 
                      

                      </div>
                       DATOS ACADEMICOS
                <div class="divider"></div>
                          <div class="row">
                         <div class="input-field col s12 m12 l4">
                          <label>Carrera</label>
                          <select id="idcarrera" name="idcarrera">
                            <option disabled value="">Seleccionar carrera</option>
                            <?php
                              foreach($carrera->mostrarTodo("estado=1") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['idcarrera']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                         <div class="input-field col s12 m12 l12" align="right">
                        <a href="../" class="btn-jh waves-effect waves-light darken-4 red"><i class="fa fa-mail-reply-all"></i> Volver</a>
                          <a id="btnLimpiar" onclick="limpiar();" class="btn-jh waves-effect waves-light grey"><i class="fa fa-clear"></i> Limpiar</a>
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
                    url: "guardares.php",
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
          swal("ERROR","Faltan datos","error");
        }
      });
function validar(){
        retorno=true;
        nombre=$('#idnombre').val();
        eje=$('#idadmejecutivo').val();
         tut=$('#idtutor').val();
        if(nombre=="" || eje=="0" || tut==""){
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