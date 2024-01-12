<?php 
$ruta="../../../";
include_once($ruta."class/transporte.php");
$transporte=new transporte; 
include_once($ruta."class/transporteasig.php");
$transporteasig=new transporteasig;
include_once($ruta."funciones/funciones.php");
//extract($_POST);
extract($_GET);

$existe=$transporte->mostrarUltimo("placa='$idplaca'");

if(count($existe)>0)
{//existe la placa REGISTRADO
	$IDtransporte=$existe['idtransporte'];
	 $existe2=$transporteasig->mostrarTodo("idtransporte=".$IDtransporte." and estado=1");
	 if (count($existe2)>0)
	 {//existe placa ASIGNADO (NO PUEDE VOLVER A REGISTRARSE)
				$arrayJSON['tipo']='4';
				$arrayJSON['idtransporteImp']=$IDtransporte; 
				$arrayJSON['idcategoria']=$existe['idcategoria'];
				//$arrayJSON['placa']=$existe['placa'];
				$arrayJSON['modelo']=$existe['modelo'];
				$arrayJSON['color']=$existe['color'];
				$arrayJSON['descripcion']=$existe['descripcion'];
				echo json_encode($arrayJSON);
	 }else{//editar y asignar 
	 		    $arrayJSON['tipo']='2';
			    $arrayJSON['idtransporteImp']=$IDtransporte; 
				$arrayJSON['idcategoria']=$existe['idcategoria'];
				//$arrayJSON['placa']=$existe['placa'];
				$arrayJSON['modelo']=$existe['modelo'];
				$arrayJSON['color']=$existe['color'];
				$arrayJSON['descripcion']=$existe['descripcion'];
			echo json_encode($arrayJSON);
	 }

}else{//NO existe nuevo registro
	//REGISTRAR NUEVO echo '1';
		$arrayJSON['tipo']='1';
		$arrayJSON['idtransporteImp']='0'; //flag cero para tener cntrol de que no se encuentra plca
				$arrayJSON['idcategoria']='1';
				
				//$arrayJSON['placa']='';
				$arrayJSON['modelo']='';
				$arrayJSON['color']='';
				$arrayJSON['descripcion']='';
		echo json_encode($arrayJSON);
}


	
?>