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
      $hd_titulo="NUEVO ESPACIO DE PARQUEO";
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
          $idmenu=1096;
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
                <div class="col s12 m12 l12">
                    <div class="formcontent">  
                      <div class="row" style="font-size: 18px; border-radius: 5px; border:#CBCBCB 1px solid;">
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
                          <input id="idnombre" name="idnombre" type="text" class="validate">
                          <label for="idnombre">Nombre o Nro. del espacio:</label>
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
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
        if (validar()) 
        {
            cat=$('#idcategoria').val();
            ties=$('#idtipoespacio').val(); 
           if (cat==2 && ties==1) 
           {
              swal("ERROR","Moto no puede tener espacio FIJO, seleccione otra opción","error");
           }else{
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
           }          
                
        }else{
          swal("ERROR","Complete con datos","error");
        }
      });
function validar(){
        retorno=true;
        cat=$('#idcategoria').val();
        nombre=$('#idnombre').val();
        if(nombre=="" || cat=="0"){
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