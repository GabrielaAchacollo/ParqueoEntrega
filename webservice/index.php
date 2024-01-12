<?php
error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
    //extract($_GET);
    extract($_POST);
$ruta="../";
include_once($ruta."class/tarjeta.php");
$tarjeta=new tarjeta;
$_SESSION['codusuario']=1;
$codRfid=$_REQUEST['lblcode'];//Request para android
//$codRfid=$_POST['lblcode'];
$existe=$tarjeta->mostrarUltimo("codigo='$codRfid'");
$fecha=date('Y-m-d');
//http://sitemcode.online/parqueo/webservice/?lblcode=mpsb125
if (count($existe)>0) 
{
	switch ($existe['estado']) 
	{
		case '0':
			echo '0';//pendiente no se registra nuevamente
			foreach($tarjeta->mostrarTodo("estado=0") as $noval)
			{
				$novalidos=array(
					"estado"=>'3',
					"activo"=>'0'
				);
			   $tarjeta->actualizar($novalidos,$noval['idtarjeta']);
			}
			$valores=array(
					//"idadmejecutivo"=>"'0'",
					"codigo"=>"'$codRfid'",
					"fecha"=>"'$fecha'",
					//"descripcion"=>'NUEVO REGISTRO',
					"estado"=>'0'
				);
						if($tarjeta->insertar($valores))
						{			 
							echo 'REGISTRADO...';
						}else{
							echo 'NO REGISTRADO...';
						}
			break;
		case '1':
			echo '1'; //ya se encuentra habilitado la tarjeta
			break;
		case '2':
			 echo '2'; //se registra nuevamente para la solicitud
			 foreach($tarjeta->mostrarTodo("estado=0") as $noval)
			{
				$novalidos=array(
					"estado"=>'3',
					"activo"=>'0'
				);
			$tarjeta->actualizar($novalidos,$noval['idtarjeta']);
			}
			 $valores=array(
					//"idadmejecutivo"=>"'0'",
					"codigo"=>"'$codRfid'",
					//"fecha"=>"'$fecha'",
					//"descripcion"=>'NUEVO REGISTRO',
					"estado"=>'0'
				);
						if($tarjeta->insertar($valores))
						{			 
							echo 'REGISTRADO...';
						}else{
							echo 'NO REGISTRADO...';
						}
			break;
	}
	
}else{
	foreach($tarjeta->mostrarTodo("estado=0") as $noval)
			{
				$novalidos=array(
					"estado"=>'3',
					"activo"=>'0'
				);
			$tarjeta->actualizar($novalidos,$noval['idtarjeta']);
			}
	$valores=array(
	//"idadmejecutivo"=>"'0'",
	"codigo"=>"'$codRfid'",
	//"fecha"=>"'$fecha'",
	//"descripcion"=>'NUEVO REGISTRO',
	"estado"=>'0'
);
		if($tarjeta->insertar($valores))
		{			 
			echo 'REGISTRADO';
		}else{
			echo 'NO REGISTRADO';
		}
}


?>
