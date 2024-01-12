<?php
	session_start();
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
	include_once($ruta."class/miempresa.php");
	$miempresa=new miempresa;
	include_once($ruta."class/usuario.php");
	$usuario=new usuario;
	include_once($ruta."class/seguimiento.php");
	$seguimiento=new seguimiento;
	include_once($ruta."funciones/funciones.php");
	include($ruta."recursos/qr/qrlib.php");
	require_once '../../../recursos/pdf/mpdf/vendor/autoload.php';

	/******************    SEGURIDAD *************/
	extract($_GET);
	//********* SEGURIDAD GET *************/
	$valor=dcUrl($lblcode);
	$valor=dcUrl($lblcode);
	$cred=$grupocredito->muestra($valor);
	$gr=$grupo->muestra($cred['idgrupo']);
	$per=$persona->mostrarPrimero("idpersona=".$cred['idpersona']);
	$rutaImg=$ruta."imagenes/logo.png";
	$demp=$miempresa->muestra(1);
	$dus=$usuario->muestra($cred["usuariocreacion"]);
	$tba=$tipobanca->muestra($cred['idtipobanca']);
	$eje=$vadmejecutivo->muestra($gr['idadmejecutivo']);
	$ddom=$dominio->muestra($cred['frecuenciapago']);
	$cuotacobrar=$cred['cuota']+1;
	$canTCred=$credito->mostrarTodo("idgrupocredito=".$valor." and tipocredito=0");
	$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];
	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];

	$consulta="SELECT sum(cuenta)  as 'maximo' FROM admcontrato where idsede=1";
	$dcont=$credito->sql($consulta);
	$dcont=array_shift($dcont);


	$mpdf = new \Mpdf\Mpdf([
			'fontDir' => array_merge([
		        $ruta.'recursos/font/titilium',
		    ]),
		    'fontdata' => $fontData + [
		        'frutiger' => [
		            'R' => 'TitilliumWeb-Regular.ttf',
		            'I' => 'TitilliumWeb-Italic.ttf',
		        ]
		    ],
		    'default_font' => 'frutiger',
		    'mode' => 'utf-8',
		    'margin_header' => 5, 
		    'margin_top' => 30, 
		    'orientation' => 'L'
		]
	);
$header='
	<table style="width:100%; font-size:12px; text-align:center;"  align="center">
        <tr >
            <td style="width:30%;" class="letras">
              <center>
                <img style="width:240px;" src="'.$rutaImg.'" ><br>
              </center>
            </td>
            <td style="width:30%;">
	            <table class="titREP" width="100%" align="center">
	            <tr>
	            	<td>
	            		<div class="titSUB">S E G U I M I E N T O</div>
	            		<div class="titPRI"><h3> GRUPO GENERAL</h3></div>
	            	</td>
	            </tr>
	            </table>
            </td>
            <td style="width:30%;">
	            <table border="0">
	              <tr>
	                <td>
	                  <table class="letras" cellpadding="2">
	                    <tr>
	                      <td align="right">
	                        FECHA:
	                      </td>
	                      <td align="left">
	                        <b>'.$cred['fechaproximo'].'</b>
	                      </td>
	                    </tr>
	                    <tr>
	                      <td align="right">
	                        HORA:
	                      </td>
	                      <td align="left">
	                        <b>'.$cred['horacreacion'].'</b>
	                      </td>
	                    </tr>
	                    <tr>
	                      <td align="right">
	                        Usuario:
	                      </td>
	                      <td align="left">
	                        <b>'.$dus['usuario'].'</b>
	                      </td>
	                    </tr>
	                  </table>
	                </td>
	              </tr>
	            </table>                     
            </td>
	  	</tr>
	</table>
	';

	$html = '
		<table  style="width:100%; font-size:12px;">
		    <tr>
		      <td width="25%"><b>Ult. Reunión : </b>'.$cred['fechaultimo'].'</td>
		      <td width="25%"><b>Fecha: </b>'.$cred['fechaproximo'].'</td>
		      <td width="25%"><b>Fecha Apertura: </b>'.$cred['fechadesembolso'].'</td>
		      <td width="25%"><b>Fecha Cierre: </b>'.$cred['fechacierre'].'</td>
		    </tr>
		    <tr>
		      <td><b>Grupo: </b>'.$gr['nombre'].'</td>
		      <td><b>Codigo: </b>'.$cred['idgrupocredito'].'</td>
		      <td><b>Zona: </b>'.$gr['lugarreunion'].'</td>
		      <td><b>Ciclo: </b> '.$gr['idciclo'].'</td>
		    </tr>
		    <tr>
		      <td><b>Cuotas: </b>'.$cuotacobrar.'/'.$cred['nrocuotas'].'</td>
		      <td><b>Lapso : </b>'.$ddom['short'].' días</td>
		      <td><b>Tipo Banca: </b><br>'.$tba['nombre'].'</td>
		      <td><b>N° Integrantes : </b>'.count($canTCred).'</td>
		    </tr>
		  </table>
		<table class="tablaLIST">
			<thead>
				<tr>
				  <th colspan="4">DATOS PERSONALES PERSONA(A)</th>
				  <th colspan="2">CUOTAS</th>
				  <th colspan="1">PRESTAMO INTERNO</th>
				  <th colspan="1"></th>
				</tr>
				<tr>
				  <th width="4%">NRO</th>
				  <th width="8%">Carnet</th>
				  <th width="15%">Nombre</th>
				  <th width="7%">Capital</th>

				  <th width="7%">Vigente</th>
				  <th width="7%">Mora</th>

				  
				  <th width="7%">Monto Ot.</th>
				  <th>SEGUIMIENTO</th>
				</tr>
			</thead>
			<tbody>
				';
				$nro=1;
				foreach($credito->mostrarTodo("idgrupocredito=".$valor." and tipocredito=0") as $f) {
					$dper=$persona->muestra($f['idpersona']);
					$cuotaPago=$f['cuotaspagadas']+1;
					$tba=$tipobanca->muestra($f['idtipobanca']);

					$montoCAM=$f['montoOT']/$f['cuotas'];
					/***************** INTERES  **********************************************/
					//meses plazo
	                $domF=$dominio->muestra($f['idfrecuenciapago']);
	                $mesesPlazo=$f['cuotas']/$domF['codigo'];
	                $interesTotal=($f['montoOT']*($f['interes']/100)*$mesesPlazo);
	                $interesCuota=$interesTotal/$f['cuotas'];
	                $interesCuota=round($interesCuota, 2);
					/*************************************************************************/
					// CUOTA ACUMULADA
					$gaTotal=$f['montoOT']*($tba['gastosadmin']/100);
					$cuotaAcumulada=$gaTotal/$f['cuotas'];
					/****************************************************************/
					//SEGURO
					$seguro=$f['montoOT']*($f['seguro']/100);
					$seguro=$seguro/$f['cuotas'];
	                $seguro=round($seguro, 2);
					/*******************************************************/

					// CAPITAL ADEUDADO A PAGAR *******************************************************/
					// Capital pagado = MontoOT-saldo
					$capitalPagado=$f['montoOT']-$f['saldo'];
					$pagoACapital=$montoCAM*$cuotaPago;
					$CapitalAPagar=$pagoACapital-$capitalPagado;
					/*********************************************************************************/
					// INETERES ADEUDADO *************************************************************/
					$interesPago=$interesCuota*$cuotaPago;
					$interesAPagar=$interesPago-$f['interesPagado'];
					/*********************************************************************************/
					// CUOTA ACUMULADA ADEUDADA
					$cuotaAcumPago=$cuotaAcumulada*$cuotaPago;
					$cuotaAcumAPagar=$cuotaAcumPago-$f['cuotaAcumulada'];
					/*********************************************************************************/
					// SEGURO ADEUDADO ***************************************************************/
					$seguroPago=$seguro*$cuotaPago;
					$seguroAPagar=$seguroPago-$f['seguroPagado'];
					/*********************************************************************************/

					$totalAPagar=$CapitalAPagar+$interesAPagar+$cuotaAcumAPagar+$seguroAPagar;
					$totalAPagar=round($totalAPagar, 2);
					$totalPago=$totalAPagar+$totalPago;

					$totalCI=$f['montoCI']+$totalCI;
					$totalSaldoCI=$f['saldoCI']+$totalSaldoCI;
					$totalinteresCI=$f['interesCI']+$totalinteresCI;

					$mora=$totalAPagar-$f['montocuota'];

					$montoPagado=$f['montoOT']-$f['saldo'];
					$mora=($f['montocuota']*$f['cuotaspagadas'])-$montoPagado-$f['interesPagado']-$f['seguroPagado']-$f['cuotaAcumulada'];
					$mora=number_format($mora, 2, '.', '');

					$totalCuota=$montoCAM+$interesCuota+$cuotaAcumulada+$seguro;
   					$totalCuota=number_format($totalCuota, 2, '.', '');

   					$valcredito=array(
						"montocuota"=>"'$totalCuota'"
				 	);
					$credito->actualizar($valcredito,$f['idcredito']);


					/******************************************   SALDO ANTERIOR  ******************************/
					/*******************************************************************************************/
					$fgarantia=$f['montoOT']*($f['fgarantia']/100);
					$totalFG=$totalFG+$fgarantia;
					$cuotasCobradas=$cuotasCobradas+$capitalPagado+$f['interesPagado']+$f['seguroPagado']+$f['cuotaAcumulada'];
					$depositVol=$depositVol+$f['saldoahorro'];
					$multas=$multas+$f['saldoMultas'];
					$montoPagadoInt=$f['montoCI']-$f['saldoCI'];
					$devInterno=$devInterno+$montoPagadoInt;//
					$intIntCobrado=$intIntCobrado+$f['interesDevCI'];//
					$credIntOtorg=$credIntOtorg+$f['montoCI'];
					/**********************************************************************************/

					$montoCI="";
					if ($f['montoCI']>0) {
						$montoCI=number_format($f['montoCI'], 2, '.', '');
					}
					$saldoCI="";
					if ($f['saldoCI']>0) {
						$saldoCI=number_format($f['saldoCI'], 2, '.', '');
					}
					$interesCI="";
					if ($f['interesCI']>0) {
						$interesCI=number_format($f['interesCI'], 2, '.', '');
					}
					$totalk=$totalk+$f['montoOT'];

					$totalMontoCuota=$totalMontoCuota+$f['montocuota'];
					$html = $html.'
						<tr>
						  <td>'.$nro.'</td>
						  <td>'.$dper['carnet'].$dper['expedido'].'</td>
						  <td>'.$dper['nombre']." ".$dper['paterno']." ".$dper['materno'].'</td>
						  <td>'.number_format($f['montoOT'], 2, '.', '').'</td>

						  <td>'.number_format($totalCuota, 2, '.', '').'</td>
						  <td>'.number_format($mora, 2, '.', '').'/____</td>

						  <td><b>('.$f['cantidadCI'].')</b>'.$montoCI.'</td>
						  <td>
						  ';
						  	$segexist=$seguimiento->mostrarUltimo("idcredito=".$f['idcredito']);
						  	if (count($segexist)>0) 
						  	{
						  $html = $html.'
						  	   <table class="tablaLIST" width="100%">
								  	<thead>
										<tr>
										  <th width="2px;">Nro.</th>
										  <th width="4px;">Fecha</th>
										  <th width="40px;">Respueta</th>
										  <th>Descripción</th>
										</tr>
									</thead>
									<tbody>
									';	
									$nroseg=0;
								 foreach($seguimiento->mostrarTodo("idcredito=".$f['idcredito']) as $seg)
								 {	
								 	$nroseg++;
								 	switch ($seg['respuestallamada']) {
				                        case '1':
				                          $respuesta='BUENA';
				                          $estilo="color: #00AB4E;";
				                          break;
				                        
				                        case '2':
				                          $respuesta='REGULAR';
				                          $estilo="color: #FF892D;";
				                          break;
				                        case '3':
				                          $respuesta='MALA';
				                          $estilo="color: #FF1E1E;";
				                          break;  
				                      }
								 $html = $html.'	
							            <tr>
											<td>'.$nroseg.'</td>
											<td>'.$seg['fecha'].'</td>
											<td style="font-weight: bold;'.$estilo.'">'.$respuesta.'</td>
											<td>'.$seg['observacion'].'</td>
										</tr>
									';	
									}
									$html = $html.'		
									</tbody>
								</table>
							';
						  }
						  $html = $html.'	
						  </td>
						</tr>
					';
					$nro++;
				}
				$saldoAnt=$totalFG+$cuotasCobradas+$depositVol+$multas+$devInterno+$intIntCobrado-$credIntOtorg;
				//$formula="SAnt:= CuotasFonGarant:".$totalFG." + CuotasCobradas: ".$cuotasCobradas." + DepVolun: ".$depositVol." + Multas: ".$multas." + DevInterno: ".$devInterno." + intIntCobrado: ".$intIntCobrado." - CredInterno: ".$credIntOtorg;
				$formula="";
				$html = $html.'
			</tbody>
		  <tfoot>
		    <tr>
		      <td colspan="8"></td>
		    </tr>
		  </tfoot>
		</table>
		<table style="width:100%; font-size:12px; text-align:center;">
			<tr>
				<td colspan="3">ASESOR(A) '.$eje['nombre']." ".$eje['paterno'].'</td>
			</tr>
		</table>
		
	';
	//==============================================================
	//==============================================================
	//==============================================================

	//$mpdf->SetDisplayMode('fullpage');

	$stylesheet = file_get_contents($ruta.'recursos/css/elisyam-1.5.css');
	$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no
	$mpdf->SetHTMLFooter('
	<table width="100%">
	    <tr>
	        <td width="33%"></td>
	        <td width="33%" align="center"></td>
	        <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
	    </tr>
	</table>');
	$mpdf->SetHeader($header,50);
	$mpdf->WriteHTML($html);
	$mpdf->Output();

?>