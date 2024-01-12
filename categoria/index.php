<?php
  $ruta="../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/categoria.php");
  $categoria=new categoria;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
   $fechaHoy=date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="LISTA DE CATEGORIA";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
      include_once($ruta."includes/head_tablax.php");
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
            <div class="row">
              <div class="col s12 m8 l8" style="background: #f4b00f; text-align: center; color:#1C2637; font-size: 25px; border-radius: 5px; border: #CBCBCB 1px solid; font-weight: bold;">
                <?php echo $hd_titulo; ?>
              </div>
              <div class="col s12 m4 l4" style="background: white; text-align: center; color:#1C2637; border-radius: 5px; border: #CBCBCB 1px solid">
                <a href="nuevo/" class="btn waves-effect darken-4 blue"><i class="fa fa-plus-square-o"></i> NUEVO</a>
              </div>
            </div>
              
            </div>
          </div>
     
          <div class="container">
            <div class="section">
              <div class="row" >
              <div class="col s12 m12 l12" style="border-radius: 5px; border: 1px solid #E8E8E8; background: white;">
                        
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Cod</th>
                      <th>Nombre</th> 
                      <th>descripción</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Cod</th>
                      <th>Nombre</th> 
                      <th>Descripción</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $contar=0;
                    foreach($categoria->mostrarTodo("estado=1") as $f)
                    {
                                        
                      $lblcode=ecUrl($f['idcategoria']);
                      $contar++;
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $contar ?></td>
                      <td><?php echo $f['nombre'] ?></td>
                      <td><?php echo $f['descripcion'] ?></td>
                      <td>
                        <a href="editar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 orange"><i class="fa fa-pencil-square"></i> editar</a>
                      <!--  <button class="btn-jh waves-effect darken-4 red" onclick="elim('<?php //echo $f['idcategoria'] ?>');"><i class="fa fa-remov"></i> Eliminar</button>-->
                        
                       
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              </div>
            </div>     
            </div>
            <!-- CREDITOS  -->
          
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
        $('#example1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
          $('#example2').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 0, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
         
    });
    //0=fecha actual dia
    //1=fecha cambiado
  function elim(id)
  {
     swal({
                  title: "¿Esta seguro?",
                  text: "ALIMINAR",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#2c2a6c",
                  confirmButtonText: "Si, estoy seguro",
                   closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                 // var str = $( "#idform" ).serialize();
                  $.ajax({
                    url: "eliminar.php",
                    type: "POST",
                    data: "idcategoria="+id,
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
  }
</body>

</html>