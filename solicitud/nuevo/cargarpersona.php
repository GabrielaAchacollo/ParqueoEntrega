<?php 
$ruta="../../";
include_once($ruta."class/persona.php");
$persona=new persona; 
include_once($ruta."class/personagrupo.php");
$personagrupo=new personagrupo; 
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio; 
include_once($ruta."funciones/funciones.php");
//extract($_POST);
extract($_GET);

$existe=$persona->mostrarTodo("carnet='$carnet'");
    if(count($existe)>0)
    {
	   $per=$persona->mostrarUltimo("carnet='$carnet'");
	   $IDpersona=$per['idpersona'];
	   $dom=$domicilio->mostrarUltimo("idpersona=".$IDpersona);

	   //echo '2'; //Ya existe la persona solo actualizar
		$arrayJSON['tipo']='2';
		$arrayJSON['idpersonaImp']=$IDpersona; 
		$arrayJSON['expedido']=$per['expedido'];
		$arrayJSON['nombre']=$per['nombre'];
		$arrayJSON['paterno']=$per['paterno'];
		$arrayJSON['materno']=$per['materno'];
		$arrayJSON['celular']=$per['celular'];

		//domicilio
		echo json_encode($arrayJSON);
 
	}else{
		 //REGISTRAR NUEVO echo '1';
		$arrayJSON['tipo']='1';
		$arrayJSON['idpersonaImp']='0'; //flag cero para tener cntrol de que no se encuentra persona
		$arrayJSON['expedido']='LP';
		$arrayJSON['nombre']='';
		$arrayJSON['paterno']='';
		$arrayJSON['materno']='';
		$arrayJSON['celular']='';
		//domicilio
		echo json_encode($arrayJSON);
	}
	
?>