<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/grupo.php");
  $grupo=new grupo;
  include_once($ruta."class/ciclo.php");
  $ciclo=new ciclo;
   include_once($ruta."class/grupocredito.php");
  $grupocredito=new grupocredito;
  include_once($ruta."class/credito.php");
  $credito=new credito;
  include_once($ruta."class/creditodetalle.php");
  $creditodetalle=new creditodetalle;
  include_once($ruta."class/personagrupo.php");
  $personagrupo=new personagrupo;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/tipobanca.php");
  $tipobanca=new tipobanca;
  include_once($ruta."class/creditomov.php");
  $creditomov=new creditomov;
  include_once($ruta."class/miempresa.php");
  $miempresa=new miempresa;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/seguimiento.php");
  $seguimiento=new seguimiento;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);

  //echo devuelveEstado(estadoCredito('2018-05-26','2018-05-25'));


  //********* SEGURIDAD GET *************/
  $valor=dcUrl($lblcode);
  $cred=$grupocredito->muestra($valor);
  $idgrupo=$cred['idgrupo'];
  $gr=$grupo->muestra($cred['idgrupo']);
  $rutaImg=$ruta."imagenes/logo.png";
  $demp=$miempresa->muestra(1);
  $dus=$usuario->muestra($cred["usuariocreacion"]);
  $tba=$tipobanca->muestra($cred['idtipobanca']);
  $ddom=$dominio->muestra($cred['frecuenciapago']);

  $pagado=0;
  if ($cred['cuota']==$cred['nrocuotas']) {
    $cuotacobrar=$cred['cuota'];
    $pagado=1;
  }else{
    $cuotacobrar=$cred['cuota']+1;
  }

  
  $canTCred=$credito->mostrarTodo("idgrupocredito=".$valor." and tipocredito=0");
  $fecha=date('Y-m-d');


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Lista de grupos con crédito";
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
          $idmenu=1074;
          include_once($ruta."aside.php");

        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?> <?php echo "[CODIGO: GC-$valor, GR-$idgrupo"; ?>]</h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="row">
                <div class='col s12 m12 l12'>
                  <fieldset class="informacion">
                    <legend><div class="titulo"><strong>OPCIONES</strong> </div></legend>
                    <input type="hidden" name="idgrupocredito" id="idgrupocredito" value="<?php echo $valor ?>">
                    <a href="../" class="btn blue"><i class="fa fa-reply"></i> VOLVER</a>
                 <!--   <a target="_blank" href="cierre/?lblcode=<?php echo $lblcode ?>" class="btn cyan darken-4 animated infinite rubberBand"><i class="fa fa-print"></i> PLANILLA DE CIERRE</a> -->
                 
                        <a target="_blank" href="informe.php?lblcode=<?php echo $lblcode ?>" class="btn waves-effect darken-4 blue"><i class="fa fa-print"></i> Reporte Seguimiento</a>
                    
                  </fieldset>
                  <fieldset class="informacion">
                    <legend><div class="titulo"><strong>Información del Grupo</strong> </div></legend>
                      <div class="col s6 m4 l3">Fecha Apertura: <b><?php echo $cred['fechadesembolso'] ?></b></div>
                      <div class="col s6 m4 l3">Fecha Ultima Reunión: <b><?php echo $cred['fechaultimo'] ?></b></div>
                      <div class="col s6 m4 l3 cyan">Fecha: <b><?php echo $cred['fechaproximo'] ?></b>
                      </div>
                      <div class="col s6 m4 l3">Fecha Apertura: <b><?php echo $cred['fechadesembolso'] ?></b></div>
                      <div class="col s6 m4 l3">Fecha Cierre: <b><?php echo $cred['fechacierre'] ?></b></div>

                      <div class="col s6 m4 l3">Grupo: <b><?php echo $gr['nombre'] ?></b></div>
                      <div class="col s6 m4 l3">Codigo: <b><?php echo $cred['idgrupocredito'] ?></b></div>
                      <div class="col s6 m4 l3">Zona: <b><?php echo $gr['lugarreunion'] ?></b></div>
                      <div class="col s6 m4 l3">Ciclo: <b><?php echo $gr['idciclo'] ?></b></div> 

                      <div class="col s6 m4 l3">Cuotas: <b><?php echo $cuotacobrar.'/'.$cred['nrocuotas'] ?></b></div>
                      <?php
                        if ($cred['nrocuotas']==$cred['cuota']+1) {
                          ?>
                            <div class="col s6 m4 l3 cyan animated infinite pulse">Cuotas: <b><?php echo $cuotacobrar.'/'.$cred['nrocuotas'] ?></b></div>
                          <?php
                        }else{
                          ?>
                            <div class="col s6 m4 l3">Cuotas: <b><?php echo $cuotacobrar.'/'.$cred['nrocuotas'] ?></b></div>
                          <?php
                        }
                      ?>
                      <div class="col s6 m4 l3">Lapso: <b><?php echo $ddom['short'] ?></b></div>
                      <div class="col s6 m4 l3">Tipo Banca: <b><?php echo $tba['nombre'] ?></b></div>
                      <div class="col s6 m4 l3">N° Integrantes: <b><?php echo count($canTCred) ?></b></div> 
                      <div class="col s6 m4 l3">ESTADO GRUPO: <b><?php echo devuelveEstado($cred['estadocredito']) ?></b></div> 
                  </fieldset>
                </div> 
              </div>
            </div> 
          </div> 

          <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Cod</th>
                      <th>CARNET</th> 
                      <th>NOMBRE</th>
                      <th>MONTO OT.</th>
                      <th>SALDO CAP.</th>
                      <th>SALDO C.I.</th>
                      <th>CUOTA</th>
                      <th>Acciones</th>
                      <th>ESTADO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    
                    foreach($credito->mostrarTodo("idgrupocredito=".$valor." and tipocredito=0") as $dcred)
                    {

                      /******************************* CALCULA TOTAL A PAGAR  ************************************/
                        $tba=$tipobanca->muestra($dcred['idtipobanca']);
                        $montoCAM=$dcred['montoOT']/$dcred['cuotas'];
                        $montoCAM=number_format($montoCAM, 2, '.', '');
                        /***************** INTERES  **********************************************/
                        //meses plazo
                        $ddom=$dominio->muestra($dcred['idfrecuenciapago']);
                        $mesesPlazo=$dcred['cuotas']/$ddom['codigo'];
                        $interesTotal=($dcred['montoOT']*($dcred['interes']/100)*$mesesPlazo);
                        $interesCuota=$interesTotal/$dcred['cuotas'];
                        $interesCuota=number_format($interesCuota, 2, '.', '');

                        /*************************************************************************/
                        // CUOTA ACUMULADA
                        $gaTotal=$dcred['montoOT']*($tba['gastosadmin']/100);
                        $gastoadmin=$gaTotal/$dcred['cuotas'];
                        $gastoadmin=number_format($gastoadmin, 2, '.', '');
                        /****************************************************************/
                        //SEGURO
                        $seguro=$dcred['montoOT']*($dcred['seguro']/100);
                        $seguro=$seguro/$dcred['cuotas'];
                        $seguro=number_format($seguro, 2, '.', '');
                        /*******************************************************/

                        $totalCuota=$montoCAM+$interesCuota+$gastoadmin+$seguro;
                        $totalCuota=number_format($totalCuota, 2, '.', '');
                        $totalCuotaResto=$interesCuota+$gastoadmin+$seguro;
                        $totalCuotaResto=number_format($totalCuotaResto, 2, '.', '');


                        if ($dcred['estadocobro']>0) {
                          $cuotaPago=$dcred['cuotaspagadas']+1;
                        }else{
                          $cuotaPago=$dcred['cuotaspagadas'];
                        }

                        // CAPITAL ADEUDADO A PAGAR *******************************************************/
                        // Capital pagado = MontoOT-saldo
                        $capitalPagado=$dcred['montoOT']-$dcred['saldo'];
                        $pagoACapital=$montoCAM*$cuotaPago;
                        $CapitalAPagar=$pagoACapital-$capitalPagado;
                        $CapitalAPagar=number_format($CapitalAPagar, 2, '.', '');
                        /*********************************************************************************/
                        // INETERES ADEUDADO *************************************************************/
                        $interesPago=$interesCuota*$cuotaPago;
                        $interesAPagar=$interesPago-$dcred['interesPagado'];
                        $interesAPagar=number_format($interesAPagar, 2, '.', '');
                        /*********************************************************************************/
                        // CUOTA ACUMULADA ADEUDADA
                        $cuotaAcumPago=$gastoadmin*$cuotaPago;
                        $cuotaAcumAPagar=$cuotaAcumPago-$dcred['cuotaAcumulada'];
                        $cuotaAcumAPagar=number_format($cuotaAcumAPagar, 2, '.', '');
                        /*********************************************************************************/
                        // SEGURO ADEUDADO ***************************************************************/
                        $seguroPago=$seguro*$cuotaPago;
                        $seguroAPagar=$seguroPago-$dcred['seguroPagado'];
                        $seguroAPagar=number_format($seguroAPagar, 2, '.', '');
                      /*********************************************************************************/


                      $totalAPagar=$CapitalAPagar+$interesAPagar+$cuotaAcumAPagar+$seguroAPagar;
                      $totalAPagar=number_format($totalAPagar, 2, '.', '');
                      //echo "TOTAL: ".$totalAPagar;
                      /*******************************************************************************************/
                     /*
                        $valcredito=array(
                          "montocuota"=>"'$totalAPagar'",
                        );
                        $credito->actualizar($valcredito,$dcred['idcredito']);
                      */
                      

                      $dper=$persona->muestra($dcred['idpersona']);
                      $dgr=$grupo->muestra($dcred['idcredito']);
                      switch ($dcred['estadocobro']) { 
                        case '0':
                          $estilo="background-color: #EAFAF1;";
                        break;
                        case '1':
                          $estilo="background-color: #ffc6c6;";
                        break;
                      }
                      $eje=$vadmejecutivo->muestra($dgr['idadmejecutivo']);
                      $lblcod=ecUrl($dcred['idcredito']);

                      $seg=$seguimiento->mostrarTodo("idcredito=".$dcred['idcredito']);
                      $cantSeg='';
                      if (count($seg)>0) 
                      {
                       $cantSeg="<b style='color:red; background-color:white; border-radius:8px;'> ".count($seg)." </b>";
                      }

                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $dcred['idcredito'] ?></td>
                      <td><?php echo $dper['carnet'].$dper['expedido'] ?></td>
                      <td><?php echo $dper['nombre']." ".$dper['paterno']." ".$dper['materno'] ?></td>
                      <td><?php echo $dcred['montoOT'] ?></td>
                      <td><?php echo $dcred['saldo'] ?></td>
                      <td><?php echo $dcred['saldoCI'] ?></td>
                      <td><?php echo $totalAPagar ?></td>
                      <td>
                        
                        <?php
                        if (count($dmov)>0) {
                          switch ($dcred['estadocobro']) { 
                            case '1':
                              ?>
                                <a href="cobrar/?lblcode=<?php echo $lblcod ?>" class="btn-jh waves-effect darken-4 blue"><i class="fa fa-money"></i> COBRAR CUOTAS</a>
                              <?php
                            break;
                          }
                        }
                        ?>
                        <a href="<?php echo $ruta ?>seguimiento/grupos/cuotas/registro.php?lblcode=<?php echo $lblcod ?>&lblcode2=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 blue"><i class="fa fa-list-alt"></i> Registrar <?php echo $cantSeg ?></a><!-- target="_blank"-->
                       <!-- <a target="_blank" href="<?php echo $ruta ?>grupo/credito/otorgar/planpagos/?lblcode=<?php echo $lblcod ?>" class="btn-jh waves-effect darken-4 orange"><i class="fa fa-print"></i> PLAN DE PAGOS</a> -->
                      </td>
                      <?php
                        if ($dcred['estadocredito']>1) {
                          $estiloEst="background-color:#f93469;";
                        }else{
                          $estiloEst="background-color:#EAFAF1";
                        }
                      ?>
                      <td style="<?php echo $estiloEst ?>">..:: <?php echo devuelveEstado($dcred['estadocredito']); ?> ::..</td>
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
        </section>
      </div>
    </div>
    <?php
    /*
      foreach($credito->mostrarTodo("idgrupocredito=".$valor." and estadocobro=1") as $f)
      {
        echo " ".$f['idcredito'];
      }
      */
    ?>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
    $("#idbtniniciar").click(function(){
      swal({
        title: "Estas Seguro?",
        text: "Iniciaras el cobro al grupo correspondiente",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      }, function () {
        var idgrupoc=$("#idgrupocredito").val();
        $.ajax({
          url: "iniciarcobro.php",
          type: "POST",
          data: "idgrupoc="+idgrupoc,
          success: function(resp){
            setTimeout(function(){     
              console.log(resp);
              $('#idresultado').html(resp);   
            }, 2000);
          }   
        });
      }); 
    });
    $("#idbtncerrar").click(function(){
      swal({
        title: "Cerrar Cobro?",
        text: "Asegurate que todos hayan pagado, Esto generará registros de la cuota del grupo, tambien se actualizara la cuota",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      }, function () {
        var idgrupoc=$("#idgrupocredito").val();
        $.ajax({
          url: "cerrarCobro.php",
          type: "POST",
          data: "idgrupoc="+idgrupoc,
          success: function(resp){
            setTimeout(function(){     
              console.log(resp);
              $('#idresultado').html(resp);   
            }, 3000);
          }   
        });
      }); 
    });
    $("#idbtncerrarCiclo").click(function(){
      swal({
        title: "Cerrar Ciclo?",
        text: "Asegurate que todos hayan pagado, Esto generará registros de la cuota del grupo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      }, function () {
        var idgrupoc=$("#idgrupocredito").val();
        $.ajax({
          url: "cerrarCiclo.php",
          type: "POST",
          data: "idgrupoc="+idgrupoc,
          success: function(resp){
            setTimeout(function(){     
              console.log(resp);
              $('#idresultado').html(resp);   
            }, 5000);
          }   
        });
      }); 
    });
    </script>
</body>

</html>