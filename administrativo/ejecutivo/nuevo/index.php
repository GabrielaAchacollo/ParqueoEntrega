<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/files.php");
  $files=new files;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."funciones/funciones.php");
  include_once($ruta."class/persona.php");
  $persona=new persona;

  session_start();
   extract($_GET);
  $valor=dcUrl($lblcode);
  
  $dper=$persona->muestra($valor);
  $ddom = $domicilio->mostrarTodo("idpersona = $valor"); 
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
                   <div class="col s12 m12 l1">
                      <p></p>
                    </div>
                  <div id="primera" class="col s10  green lighten-5">
         <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <input id="idpersona" name="idpersona" value="<?php echo $valor ?>" type="hidden" class="validate">
                <div class="col s12 m12 l12">
                     
                    <div class="" style="background: white">
                       


 

   

 <ul class="tabs   z-depth-0 green lighten-2">
        <li class="tab col s3">
           <a class="label white-text     offset-s4 l2 offset-l1" data-position="button" data-delay="50" data-tooltip="Editar Datos Persona" href="../../../persona/editar/?lblcode=<?php echo $lblcode; ?>", target="_blank"> DATOS PERSONA <i class="mdi-editor-border-color"></i></a>
        </li>
      </ul>

<div class="col s12 red-text" style="background: #F5F9FB"> 
    <div class="col s10"> 
          <div id="valCarnet" class="col s12"></div>
          <div class="input-field col s12 m8 l2 ">
            <input id="CC" name="CC" type="text" readonly="" value="<?php echo $dper['carnet'] ?>" >
            <label for="idcarnet">CARNET</label>
          </div>
          <div class="input-field col s12 m4 l1 ">
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
          <div class="input-field col s12 m12 l3 ">
            <input id="idnombre" name="idnombre" readonly="" value="<?php echo $dper['nombre'] ?>" type="text" >
            <label for="idnombre">Nombre(s)</label>
          </div>
          <div class="input-field col s12 m12 l3">
           <input id="idpaterno" name="idpaterno" readonly=""  value="<?php echo $dper['paterno'] ?>" type="text" >
            <label for="idpaterno">Paterno</label>
          </div>
          <div class="input-field col s12 m12 l3">
            <input id="idmaterno" name="idmaterno" readonly="" value="<?php echo $dper['materno'] ?>" type="text"  >
            <label for="idmaterno">Materno</label>
          </div>
      
          <div class="input-field col s12 m12 l3"> 
            <input id="idemail" name="idemail" readonly=""  value="<?php echo $dper['email'] ?>" type="email" >
            <label for="idemail">Email</label>
          </div>  
          <div class="input-field col s12 m12 l3">
            <input id="idcelular" name="idcelular" readonly=""  value="<?php echo $dper['celular'] ?>" type="text" >
            <label for="idcelular">Celular(es)</label>
          </div>
        
          <div class="input-field col s12 m12 l3">
            <input id="idocupacion" name="idocupacion"  readonly="" value="<?php echo $dper['ocupacion'] ?>" type="text" >
            <label for="idocupacion">Ocupacion</label>
          </div> 
          <div class="input-field col s3">
            <a class="btn btn-info" href="../../../persona/editar/?lblcode=<?php echo $lblcode; ?>", target="_blank"> <i class="mdi-editor-border-color"></i>MODIFICAR </a>
          </div> 
      </div> 

       <div class="col s2"> 
           <a class="modal-trigger" style="height: 100px" href="#modal4"><img src="<?php echo $rutaFoto ?>"  width="100" > </a>
      </div> 
  </div> 

<ul class="tabs tab-demo-active  green lighten-2">
        <li class="tab col s3">
           <a class="label white-text     offset-s4 l2 offset-l1" data-position="top" data-delay="50" data-tooltip="Editar Datos Persona" href="#" > DATOS FILIACION <i class="mdi-action-assignment-ind"></i></a>
        </li>
      </ul>

                      <div class="row">
                         
       
                      <!--   
                        <div class="input-field col s12 m12 l6 ">
                          <label></label>
                          <select id="idarea" name="idarea">
                            <option value="0">Seleccionar...</option>
                            <?php
                          //  foreach($dominio->mostrarTodo("tipo='AREJ' ") as $f)
                            {
                              ?>
                                <option value="<?php //echo $f['iddominio']; ?>"><?php //echo $f['nombre']; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s6">
                          <label>Organización/Dpto</label>
                          <select id="idorg" name="idorg"></select>
                        </div>
                        <div class="input-field col s6">
                          <label>Cargo</label>
                          <select id="idcargo" name="idcargo"></select>
                        </div>-->
                       <div class="input-field col s6">
                          <label>Tipo Ejecutivo</label>
                          <select id="tipoeje"   name="tipoeje">
                            <?php
                              foreach($dominio->mostrarTodo("tipo='CAAS' and iddominio!=166") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['iddominio']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div> 
                        <div class="input-field col s12 m12 l6 ">
                          <input id="idfechaingreso" name="idfechaingreso"  value="<?php echo date('Y-m-d');?>" type="date" class="validate">
                          <label for="idfechaingreso">Fecha Ingreso</label>
                        </div>
                     
                         <div class="input-field col s12 m6 l2 ">
                              <label>Referncia personal</label>
                        </div> 
                        <div class="input-field col s12 m6 l10 ">
                              <textarea id="idrefper" name="idrefper" type="text" class="validate" style="height:100px;"></textarea>
                        </div> 
                        <div class="row">
                          <div class="input-field col s6"></div>
                          <div class="input-field col s6"> 
                             <a class="btn waves-effect waves-light green" href="../../ejecutivo"  > SALIR </a>
                            <button id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-save"> </i> Registrar Filiacion</button>
                          </div>
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
                ` </div> 

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
      
  $("#btnSave").click(function(){
       
        if (validar()) {    
         $('#btnSave').attr("disabled",true);      
          swal({
            title: "CONFIRMACION",
            text: "Se registrara filiacion",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Registrar",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            // alert(str);
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
          swal("DATOS FALTANTES");
        } 
      });

 function validar(){
        retorno=true;
        carnet=$('#idarea').val();
        if(carnet==0){
          retorno=false;
        }
        return retorno;
      }
     
       $("#idarea").change(function() {
        var idarea=$("#idarea").val();
        $("#idorg").empty().html(' ');
        /*************************   ORGANIZACION  *********************************************************/
        $.post("cargaOrganizacion.php",{"idarea":idarea},function(ejecutivos){  
          console.log(ejecutivos);   
          var cmdejec=$("#idorg");
            cmdejec.empty();
            $.each(ejecutivos,function(idejecutivo,ejec){
              $("#idorg").append( $("<option></option>").attr("value",ejec.idejecutivo).text(ejec.nombre));
          //$("#idsedex").val(ejec.sede);
            });
            $("#idorg").material_select('update');
            $("#idorg").closest('.input-field').children('span.caret').remove();
        },'json');
        /*********   CARGO JERARQUIA  **********************************************************************/
        $("#idcargo").empty().html(' ');
        $.post("cargaJerarquia.php",{"idarea":idarea},function(ejecutivos){  
          console.log(ejecutivos);
          var cmdejec=$("#idcargo");
            cmdejec.empty();
            $.each(ejecutivos,function(id,ejec){
              $("#idcargo").append( $("<option></option>").attr("value",ejec.id).text(ejec.nombre));
            });
            $("#idcargo").material_select('update');
            $("#idcargo").closest('.input-field').children('span.caret').remove();
        },'json');
      });
    </script>
</body>

</html>
