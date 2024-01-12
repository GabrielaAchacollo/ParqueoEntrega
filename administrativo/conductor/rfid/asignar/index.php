<?php
  $ruta="../../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/nivel.php");
  $nivel=new nivel;
  include_once($ruta."class/rol.php");
  $rol=new rol;
   include_once($ruta."class/curso.php");
  $curso=new curso;
    include_once($ruta."class/habilitado.php");
  $habilitado=new habilitado;
  include_once($ruta."class/habilitadodet.php");
  $habilitadodet=new habilitadodet;
  include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/tarjeta.php");
  $tarjeta=new tarjeta;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
  extract($_GET);

 $idadmejecutivo=dcUrl($lblcode);
 $deje=$vadmejecutivo->muestra($idadmejecutivo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ASIGNAR CREDENCIAL";
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
           <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
          <!--    <div class="row"> -->
                <div class="row " style="background: #f4b00f; text-align: center; color:#032049; font-size: 25px; border-radius: 5px; font-weight: bold;">
                    <?php echo $hd_titulo; ?>
            </div>
               <div class="col s12 m12 l12" style="text-align: right;">
                  
                </div>             
           <!-- </div>--> 
         </div>
          </div>
<div class="container">
  <div class="section">
    <div class="row">
      <div class='col s12 m12 l6'> 
              <fieldset class="informacion" style="background: #f4b00f;">
                    <legend><div class="titulo">
                      <a href="../../" class="btn-jh waves-effect waves-light blue lighten-1"><i class="fa fa-mail-reply-all"></i></a>
                      <strong>PERSONAL</strong> </div></legend>
                   
                    <div class="col s12 m12 l12">
                      <div class="col s12 m12 l12">Nombre: <b><?php echo $deje['nombre'].' '.$deje['paterno'].' '.$deje['materno'] ?></b></div>
                      <div class="col s12 m12 l12">Cernet: <b><?php echo $deje['carnet'].' '.$deje['expedido'] ?></b></div>
                      <div class="col s12 m12 l12">Cargo: <b><?php echo $deje['tiponombre'] ?></b></div>
                    </div>
                      
                  </fieldset>
                  <?php
                    $contar=0;
                    foreach($tarjeta->mostrarTodo("idadmejecutivo=".$idadmejecutivo) as $f)
                    {
                      $contar++;
                      switch ($f['estado']) 
                      {
                        case '1':
                        ?>
                        <fieldset class="informacion" style="background: #B2F1D4;">
                          <legend><div class="titulo">
                            <strong>TARJETA RFID ASIGNADO</strong> </div></legend>
                         
                          <div class="col s12 m12 l12">
                            <div class="col s12 m12 l12" style="font-size: 20px;">Codigo: <b><?php echo $f['codigo'] ?></b></div>
                            <div class="col s12 m12 l12" align="right">
                             <button class="btn-jh waves-effect waves-light darken-4 red" onclick="darbaja('<?php echo $f['idtarjeta'] ?>');"><i class="fa fa-arrow-circle-down"></i> Dar de baja</button>
                                </div>
                          </div>
                            
                        </fieldset>
                        <?php
                          break;
                        
                        case '2':
                           ?>
                            <fieldset class="informacion" style="background: #E8E8E8;">
                              <legend><div class="titulo">
                                <strong>TARJETA RFID DADO DE BAJA</strong> </div></legend>
                             
                              <div class="col s12 m12 l12">
                                <div class="col s12 m12 l12" style="font-size: 20px;">Codigo: <b><b><?php echo $f['codigo'] ?></b></div>
                                
                              </div>
                                
                            </fieldset>
                            <?php 
                          break;
                      }

                    }
                    if ($contar==0) 
                    {
                      ?>
                        <fieldset class="informacion" style="background: #D8FAFF;  color: #BB0C0C">
                          <legend><div class="titulo">  
                            <strong>TARJETA RFID</strong> </div></legend>
                         
                          <div class="col s12 m12 l12">
                            <div class="col s12 m12 l12">TARJETA RFID SIN ASIGNAR</div>
                          </div>
                            
                        </fieldset>
                        <?php
                    }
                   ?>
                  
      </div>
      <?php
      $codigo=0;
        $tar=$tarjeta->mostrarUltimo("estado=0");
        if (count($tar)>0) 
        {
         $codigo=$tar['codigo'];
        }

      ?>
      <div class='col s12 m12 l6'> 
        <fieldset class="informacion">
                      <legend><div class="titulo"><strong><i class="fa fa-credit-card"></i></strong> </div></legend>
                      <div class="col s12 m12 l12">
                         <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                  <fieldset class="informacion" style="background: #032049;">
                    <legend><div class="titulo">
                      <strong>ASIGNAR CREDENCIAL a <?php echo $deje['tiponombre'] ?></strong> </div></legend>
                   <input id="idadmejecutivo" name="idadmejecutivo" type="hidden" value="<?php echo $idadmejecutivo ?>" class="validate">
                    <input id="idtarjeta" name="idtarjeta" type="hidden" value="<?php echo $tar['idtarjeta'] ?>" class="validate">
                    <div class="col s12 m12 l12"  style="background: white; ">
                        <div class="input-field col s12 m12 l10" >
                          <input id="idcodigorfid" name="idcodigorfid" readonly type="text" style="font-size: 30px; text-align: center; color: #37995F;" value="<?php echo $codigo ?>" class="validate">
                          <label for="idcodigorfid">Codigo RFID</label>
                        </div>
                        <div class="input-field col s12 m12 l2" >
                          <button class="btn waves-effect waves-light darken-4 orange" onclick="buscar();"><i class="fa fa-search"></i></button>
                        </div>
                         <div class="input-field col s12 m12 l12" align="right">
                          <a id="btnSave" class="btn waves-effect waves-light darken-4 blue"><i class="fa fa-save"></i> Asignar RFID</a>
                        </div>
                      
                  </fieldset>
                </form>
                      </div> 
                    </fieldset>
      </div>
    </div>
  </div>
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
                  text: "Se asiganar la tarjeta",
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
                      //alert(resp);
                      setTimeout(function(){     
                        console.log(resp);
                        $('#idresultado').html(resp);   
                      }, 1000);
                    }
                  }); 
                });
        }else{
          swal("ERROR","Pasar tarjeta RFID, realize la busqueda nuevamente","error");
        }
      });
function validar(){
        retorno=true;
        cod=$('#idcodigorfid').val();
        if(cod=="0"){
          retorno=false;
        }
        return retorno;
      }
    function limpiar()
      {
          document.getElementById("idform").reset();
      }
function buscar()
{
    location.reload();
}
function darbaja(id)
{
   swal({
                  title: "¿Esta seguro?",
                  text: "Dar baja a la tarjeta",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "SI",
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true
                }, function () {
                  //var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "darbaja.php",
                    type: "POST",
                    data: "idtarjeta="+id,
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