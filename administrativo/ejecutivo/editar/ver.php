<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/files.php");
  $files=new files;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."class/rol.php");
  $rol=new rol;
  include_once($ruta."funciones/funciones.php");
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;

  session_start();
   extract($_GET);
  $valor=dcUrl($lblcode);
  
  $dper=$persona->muestra($valor);
  $ddom=$domicilio->mostrarTodo("idpersona = $valor"); 
  $dus=$usuario->mostrarUltimo("idpersona = $valor"); 

  $ddom = array_shift($ddom);
  /******** foto ***********/
$dfoto=$files->mostrarTodo("id_publicacion=".$valor." and tipo_foto='foto'");
$dfoto=array_shift($dfoto);
if (count($dfoto)>0) {
    $rutaFoto=$ruta."persona/editar/server/php/".$valor."/".$dfoto['name'];
}
else{
    $rutaFoto=$ruta."imagenes/user.png";
}
    /******** foto ***********/
     
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Titular";
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
          $idmenu=1037;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div class="row section">
            <div class="col s12">
              <div id="" class="col s12">
                <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                  <input id="idpersona" name="idpersona" value="<?php echo $valor ?>" type="hidden" class="validate">
                  <div class="col s12 m12 l12">
                 
                    <div class="" style="background: white">  
                      <div class="col s12 m12 l12" style="background: #f4b00f; text-align: center; color:#1C2637; font-size: 18px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                           DATOS PERSONA
                        </div>                 
                      <div class="col s12 red-text" style="background: white"> 
                        <div class="col s2"> 
                          <a class="modal-trigger" style="height: 100px" href="#modal4"><img src="<?php echo $rutaFoto ?>"  width="100" > </a>
                        </div>
                        <div class="col s10"> 
                          <div id="valCarnet" class="col s12"></div>
                          <div class="input-field col s2">
                            <input id="CC" name="CC" type="text" readonly="" value="<?php echo $dper['carnet'] ?>" >
                            <label for="idcarnet">CARNET</label>
                          </div>
                          <div class="input-field col s1">
                            <label>Exp.</label>
                            <select id="idexp" name="idexp" disabled="">
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
                          <div class="input-field col s3">
                            <input id="idnombre" name="idnombre" readonly="" value="<?php echo $dper['nombre'] ?>" type="text" >
                            <label for="idnombre">Nombre(s)</label>
                          </div>
                          <div class="input-field col s3">
                           <input id="idpaterno" name="idpaterno" readonly=""  value="<?php echo $dper['paterno'] ?>" type="text" >
                            <label for="idpaterno">Paterno</label>
                          </div>
                          <div class="input-field col s3">
                            <input id="idmaterno" name="idmaterno" readonly="" value="<?php echo $dper['materno'] ?>" type="text"  >
                            <label for="idmaterno">Materno</label>
                          </div>
                      
                          <div class="input-field col s3"> 
                            <input id="idemail" name="idemail" readonly=""  value="<?php echo $dper['email'] ?>" type="email" >
                            <label for="idemail">Email</label>
                          </div>  
                          <div class="input-field col s3">
                            <input id="idcelular" name="idcelular" readonly=""  value="<?php echo $dper['celular'] ?>" type="text" >
                            <label for="idcelular">Celular(es)</label>
                          </div>
                        
                          <div class="input-field col s3">
                            <input id="idocupacion" name="idocupacion"  readonly="" value="<?php echo $dper['ocupacion'] ?>" type="text" >
                            <label for="idocupacion">Ocupacion</label>
                          </div> 
                          <div class="input-field col s3">
                            <a class="btn waves-effect waves-light darken-4 blue" href="../../../persona/editar/?lblcode=<?php echo $lblcode; ?>", target="_blank"> <i class="mdi-editor-border-color"></i>MODIFICAR </a>
                          </div> 
                        </div> 
                         
                      </div> 

                     
                      <div class="col s12 red-text" style="background: white"> 
                        
                        <div class="input-field col s6">
                          <div class="col s12 m12 l12" style="background: #f4b00f; text-align: center; color:#1C2637; font-size: 18px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                           DATOS FILIACION
                        </div> 
                          <?php
                            if (count($dus)>0) {
                              ?>
                                <fieldset class="formulario">
                                  <div class="titulo"> MODIFICAR DATOS DE USUARIO</div>
                                  <input type="hidden" name="idus" id="idus" value="<?php echo $dus['idusuario'] ?>">
                                  <div class="input-field col s12">
                                    <input id="idusmod" name="idusmod" type="text" readonly="" value="<?php echo $dus['usuario'] ?>" class="validate">
                                    <label for="idusmod">USUARIO</label>
                                  </div>                          
                                  <div class="input-field col s12">
                                    <input id="idpass1" name="idpass1" type="password" class="validate">
                                    <label for="idpass1">NUEVA CONTRASEÑA</label>
                                  </div>
                                  <div class="input-field col s12">
                                    <input id="idpass2" name="idpass2" type="password" class="validate">
                                    <label for="idpass2">REPITA CONTRASEÑA</label>
                                  </div>
                                  <div class="input-field col s12">
                                    <label>ASIGNAR ROL</label>
                                    <select id="idrol" name="idrol">
                                      <?php
                                        foreach($rol->mostrarTodo("") as $f)
                                        {
                                          $este="";
                                          if ($dus['idrol']==$f['idrol']) {
                                            $este="selected";
                                          }
                                          ?>
                                            <option <?php echo $este; ?> value="<?php echo $f['idrol']; ?>"><?php echo $f['Nombre']; ?></option>
                                          <?php
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="input-field col s12">
                                    <button style="width: 100%" id="btnEdit" class="btn darken-4 blue"><i class="fa fa-save"></i> GUARDAR CAMBIOS</button>
                                  </div> 
                                </fieldset>
                              <?php
                            }
                            else{
                              ?>
                                <fieldset class="formulario">
                                  <div class="titulo"> NUEVO USUARIO DEL SISTEMA</div>
                                  <div class="input-field col s12">
                                    <input id="idusuario" name="idusuario" type="text" class="validate">
                                    <label for="idusuario">USUARIO</label>
                                  </div>
                                  <div class="input-field col s12">
                                    <input id="idpass1" name="idpass1" type="password" class="validate">
                                    <label for="idpass1">CONTRASEÑA</label>
                                  </div>
                                  <div class="input-field col s12">
                                    <input id="idpass2" name="idpass2" type="password" class="validate">
                                    <label for="idpass2">REPITA CONTRASEÑA</label>
                                  </div>
                                  <div class="input-field col s12">
                                    <label>ASIGNAR ROL</label>
                                    <select id="idrol" name="idrol">
                                      <?php
                                        foreach($rol->mostrarTodo("") as $f)
                                        {
                                          ?>
                                            <option value="<?php echo $f['idrol']; ?>"><?php echo $f['Nombre']; ?></option>
                                          <?php
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="input-field col s12">
                                    <button style="width: 100%" id="btnSave" class="btn green"><i class="fa fa-save"></i> GUARDAR</button>
                                  </div> 
                                </fieldset>
                              <?php
                            }
                          ?>
                        </div> 
                      </div>                    
                    </div>
                  </div>
                </form> 
              </div> 
              <div id="modal4" class="modal modal-fixed-footer green lighten-2 white-text">
                <div class="modal-content"> 
                  <center>                  
                    <img src="<?php echo $rutaFoto ?>"  width="350" >
                  </center> 
                </div> 
                <div class="modal-footer"> 
                  <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cerrar</a>
                </div>
              </div> 
            </div>
          </div> 
          <?php
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      $("#idusante").blur(function(){
        nusuario=$("#idusmod").val();
        pass=$("#idusante").val();
        $.ajax({
            url: "valpass.php",
            type: "POST",
            data: 'idusmod='+nusuario+'&idusante='+pass,
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          });
      });
      $("#idusuario").blur(function(){
        nusuario=$("#idusuario").val();
        $.ajax({
            url: "validaUsuario.php",
            type: "POST",
            data: 'idusuario='+nusuario,
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          });
      });
     

$("#btnEdit").click(function(){

if (validarU()) {   
         if (validarC()) {   
                if (validar()) {   
                          $('#btnEdit').attr("disabled",true);
                        swal({
                          title: "CONFIRMACION",
                          text: "Esta seguro de modificar la contraseña?",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#2c2a6c",
                          confirmButtonText: "Registrar",
                          closeOnConfirm: false
                        }, function () {
                          var str = $( "#idform" ).serialize();
                         // alert(str);
                          $.ajax({
                            url: "modificar.php",
                            type: "POST",
                            data: str,
                            success: function(resp){
                              console.log(resp);
                              $("#idresultado").html(resp);
                            }
                          }); 
                        });
                  }
                  else{
                    Materialize.toast('<span>Las contraseñas no coinciden.</span>', 1500);
                    $("#idpass1").focus();
                  } 
          }
          else{
            Materialize.toast('<span>Inserte Una contraseña.</span>', 1500);
            $("#idpass1").focus();
          } 
       }
    else{
      Materialize.toast('<span>Inserte usuario </span>', 1500);
      $("#idusuario").focus();
    }
 });
 $("#btnSave").click(function(){

if (validarU()) {   
         if (validarC()) {   
                if (validar()) {   
                    $('#btnSave').attr("disabled",true);
                    swal({
                      title: "CONFIRMACION",
                      text: "Se registrara el usuario",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#2c2a6c",
                      confirmButtonText: "Registrar",
                      closeOnConfirm: false
                    }, function () {
                      var str = $( "#idform" ).serialize();
                      //alert(str);
                      $.ajax({
                        url: "guardar.php",
                        type: "POST",
                        data: str,
                        success: function(resp){
                          console.log(resp);
                          $("#idresultado").html(resp);
                        }
                      }); 
                    });
                  }
                  else{
                    Materialize.toast('<span>Las contraseñas no coinciden.</span>', 1500);
                    $("#idpass1").focus();
                  } 
          }
          else{
            Materialize.toast('<span>Inserte Una contraseña.</span>', 1500);
            $("#idpass1").focus();
          } 
       }
    else{
      Materialize.toast('<span>Inserte usuario </span>', 1500);
      $("#idusuario").focus();
    }
 });

    function validar(){
        retorno=false;
        pass1=$("#idpass1").val();
        pass2=$("#idpass2").val();
        passX=$("#idusante").val();
        if (pass1==pass2) { 
            if (passX!='') {
                 
                    retorno=true;
                 
              } 
        }
  
        return retorno;
      }
      function validarC(){
        retorno=false;
        pass1=$("#idpass1").val();
        pass2=$("#idpass2").val(); 
         
             if (pass1!='') {
                 if (pass2!='') {
                      retorno=true;
                  } 
            } 
                
        return retorno;
      } 
      function validarU(){
        retorno=false;
        u=$("#idusuario").val(); 
         
             if (u!='') {
                  
                      retorno=true;
                   
            } 
                
        return retorno;
      }
    </script>
</body>

</html>
