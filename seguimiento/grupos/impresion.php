<?php 
	$ruta="../../";
	include_once($ruta."class/grupocredito.php");
	$grupocredito=new grupocredito;
	extract($_POST);
	session_start();

	$valores=array(
	     "impresion"=>"'$impres'"
	);	
	if($grupocredito->actualizar($valores,$idgrupocredito))
	{
		echo '1';
	}
?>