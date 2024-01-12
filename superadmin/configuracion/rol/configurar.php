<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/rol.php");
  $rol=new rol;
  include_once($ruta."class/menu.php");
  $menu=new menu;
  include_once($ruta."class/admmodulo.php");
  $admmodulo=new admmodulo;
  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);
  $idrol=dcUrl($lblcode);
  $drol=$rol->mostrar($idrol);
  $drol=array_shift($drol);

  if (!isset($lblcode)) {
    $query="";
    $tituloSede="Contratos en todas las Sedes";
  }
  else{
    $query=" and idsede=".dcUrl($lblcode);
    $dSelSede=$admmodulo->mostrar(dcUrl($lblcode));
    $dSelSede=array_shift($dSelSede);
    $tituloSede="Contratos en Sede ".$dSelSede['nombre'];
  }


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Configurar Rol";
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
          $idmenu=2;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
              <div class="col s12 m12 l12" style="background: #f4b00f; text-align: center; color:#1C2637; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                <?php echo $hd_titulo; ?>
              </div>
            </div>   
            </div>
          </div>
          <div class="container">
              <div class="row">
                 <div class="col s12 m12 l2">&nbsp</div>
                <div class="col s12 m8 l6" style="background: #E8F8F5; text-align: center; color:#000000; border-radius: 5px; border: #CBCBCB 1px solid;">
                  <h4 class="header">Habilitar Paginas</h4>
                  
                  <div class="input-field col s12">
                    <label>Filtrar Pagina</label>
                    <select id="idarea" name="idarea">
                      <option value="0">Paginas</option>
                      <?php
                      foreach($admmodulo->mostrarTodo("estado=1") as $f)
                      {
                        ?>
                          <option value="<?php echo $f['idadmmodulo']; ?>"><?php echo $f['nombre']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <form id="idform2" action="return false" onsubmit="return false" method="POST">
                    <?php
                    foreach($menu->mostrarTodo("padre=0 and idmenu!=1000") as $dmenu)
                    {
                      $actMenu=$vrolmenu->mostrarTodo("idmenu=".$dmenu['idmenu']." and idrol=".$idrol);
                      if(count($actMenu)>0)$sw="checked"; else $sw="";
                    ?>
                      <p>
                        <input name="id-<?php echo $dmenu['idmenu']; ?>" type="checkbox" <?php echo $sw ?> id="ch-<?php echo $dmenu['idmenu']; ?>" />
                        <label for="ch-<?php echo $dmenu['idmenu']; ?>"><?php echo $dmenu['nombre']; ?></label>
                      </p>
                      <?php
                        foreach($menu->mostrarTodo("padre=".$dmenu['idmenu']) as $dmenuN2)
                        {
                          $actMenu=$vrolmenu->mostrarTodo("idmenu=".$dmenuN2['idmenu']." and idrol=".$idrol);
                          if(count($actMenu)>0)$sw="checked"; else $sw="";
                          ?>
                          <div class="col s12 m4 l1">&nbsp;</div>
                          <div class="col s12 m8 l11">
                            <p>
                              <input name="id-<?php echo $dmenuN2['idmenu']; ?>" type="checkbox" <?php echo $sw ?> id="ch-<?php echo $dmenuN2['idmenu']; ?>" />
                              <label for="ch-<?php echo $dmenuN2['idmenu']; ?>"><?php echo $dmenuN2['nombre']; ?></label>
                            </p>
                          </div>
                          <?php
                        }
                      ?>
                    <?php
                    }
                    ?>
                  </form>
                  <button id="btnSave" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> Guardar Cambios</button>
                </div>
                <div class="col s12 m4 l4" style="background: white; text-align: center; color:#1C2637; border-radius: 5px; border: #CBCBCB 1px solid; ">
                  <h4 class="header">Editar Rol</h4>
                  
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idrol" name="idrol" type="hidden" value="<?php echo $lblcode; ?>">
                    <div class="row">
                      <div class="input-field col s12">
                        <input id="idnombre" name="idnombre" type="text" value="<?php echo $drol['Nombre'] ?>" class="validate">
                        <label for="idnombre">Nombre</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12">
                        <textarea id="iddesc" name="iddesc" class="materialize-textarea"><?php echo $drol['Descripcion'] ?></textarea>
                        <label for="iddesc">Descripcion</label>
                      </div>
                    </div>
                    <a href="index.php" class="btn-jh waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
                  <a id="btnGuardar" class="btn-jh waves-effect waves-light cyan"><i class="fa fa-save"></i> Guardar Cambios</a>
                  </form>
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
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
      $("#btnGuardar").click(function(){        
        if (validar()) {        
          $('#btnGuardar').attr("disabled",true);
          var str = $( "#idform" ).serialize();
          $.ajax({
            url: "actualizar.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }
        else{
          Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
        }
      }); 
      $("#btnSave").click(function(){        
        if (validar()) {        
          var str = $( "#idform2" ).serialize();
          $('#btnSave').attr("disabled",true);
          str=str+"&lblcode="+"<?php echo $lblcode ?>";
          //alert(str);          
          $.ajax({
            url: "guardaconfigrol.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }
        else{
          Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
        }
      });
      function validar(){
        return true;
      }
    </script>
</body>

</html>