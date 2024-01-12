<?php
error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
    //extract($_GET);
    extract($_POST);
$ruta="../";
include_once($ruta."class/tarjeta.php");
$tarjeta=new tarjeta;
include_once($ruta."class/transporteasig.php");
$transporteasig=new transporteasig;
include_once($ruta."class/transporte.php");
$transporte=new transporte;
include_once($ruta."class/estacionamiento.php");
$estacionamiento=new estacionamiento;
include_once($ruta."class/movimiento.php");
$movimiento=new movimiento;
$_SESSION['codusuario']=1;
$codRfid=$_REQUEST['lblcode'];//Request para android
//$codRfid=$_POST['lblcode'];
$existe=$tarjeta->mostrarUltimo("codigo='$codRfid' and estado=1");
$fecha=date('Y-m-d');
$hora=date('H:i:s');
//http://sitemcode.online/parqueo/webservice/ingreso.php?lblcode=mpsb125
if (count($existe)>0) 
{
	$idtarjeta=$existe['idtarjeta'];
	$traasig=$transporteasig->mostrarUltimo("idadmejecutivo=".$existe['idadmejecutivo']." and estado=1");
	if (count($traasig)>0)
	{
		  $idadmejecutivo=$existe['idadmejecutivo'];
		  $trans=$transporte->mostrarPrimero($traasig['idtransporte']);
		  $esta=$estacionamiento->mostrarPrimero('idcategoria='.$trans['idcategoria']." and estadolugar=0");
		  $idestacionamiento=$esta['idestacionamiento'];
		  if (count($esta)>0)
		  	{
		  		$moviexist=$movimiento->mostrarUltimo("idtarjeta=".$idtarjeta." and control=1 and estado=1"); //control=si es solamente salida
		  		if (count($moviexist)>0) 
		  		{
		  			echo 'YA SE HABILITO EL INGRESO';
		  		}else{
		  			    $tar=$tarjeta->mostrarPrimero($existe['idtarjeta']);
						$valores=array(
								"idadmejecutivo"=>"'$idadmejecutivo'",
								"idestacionamiento"=>"'$idestacionamiento'",
								"idtarjeta"=>"'$idtarjeta'",
								"tarjeta"=>"'1'", //0=sin tarjeta 1=con tarjeta
								"fechaingreso"=>"'$fecha'",
								"horaingreso"=>"'$hora'",
								"estado"=>'1', //0=Anulado 1=valido
								"control"=>'1'  //1=Iniciado(solo ingreso) 2=Completado(entrada y salida)
				        );
						if($movimiento->insertar($valores))
						{		
									$valoresta=array(
									"estadolugar"=>'2' //2=ocupado
								);
							       $estacionamiento->actualizar($valoresta,$idestacionamiento);								      
							echo 'INGRESO REGISTRADO...';
						}else{
							echo 'NO REGISTRADO...';
						}
		  		}
		  		    
		  	}else{
		  		echo 'NO EXISTE ESPACIO PARA LA CATEGORIA';
		  	}

	}else{
		echo 'NO ASIGNADO MOVILIDAD';
	}
	
}else{
    echo 'TARJETA NO ASIGNADO';
}




            


?>
