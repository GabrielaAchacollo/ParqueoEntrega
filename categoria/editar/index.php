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

 $valor=dcUrl($lblcode);
 $cat=$categoria->muestra($valor);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ACTUALIZAR CATEGORIA";
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
          $idmenu=1042;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row " >
                <div class="col s12 m12 l2">&nbsp;</div>
              <div class="col s12 m12 l8" style="background: #f4b00f; text-align: center; color:#1C2637; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
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
                  <input id="idcategoria" name="idcategoria" type="hidden" value="<?php echo $valor ?>">
                <div class="col s12 m12 l12">
                    <div class="formcontent">  
                      <div class="row" style="font-size: 18px; border-radius: 5px; border:#CBCBCB 1px solid;">
                       
                        <div class="input-field col s12 m12 l12">
                          <input id="idnombre" name="idnombre" type="text" value="<?php echo $cat['nombre'] ?>" class="validate">
                          <label for="idnombre">Nombre Categoria</label>
                        </div>
                        <div class="input-field col s12 m12 l12">
                          <input id="iddescripcion" name="iddescripcion" type="text" value="<?php echo $cat['descripcion'] ?>" class="validate">
                          <label for="iddescripcion">Descripción</label>
                        </div>
                         <div class="input-field col s12 m12 l12" align="right">
                        <a href="../" class="btn-jh waves-effect waves-light darken-4 red"><i class="fa fa-mail-reply-all"></i> Volver</a>
                          <a id="btnSave" class="btn-jh waves-effect waves-light darken-4 blue"><i class="fa fa-save"></i> Modificar</a>
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
                  text: "Actualizar los datos",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "Si, estoy seguro",
                   closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                  var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "actualizar.php",
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
          swal("ERROR","Complete con datos","error");
        }
      });
function validar(){
        retorno=true;
        nombre=$('#idnombre').val();
        if(nombre==""){
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