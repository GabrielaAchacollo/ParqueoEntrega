<?php
session_start();
$ruta="../../../";
include_once($ruta."class/transporte.php");
$transporte=new transporte;
extract($_POST);

   foreach($transporte->mostrarTodo("estado=1 and idadmejecutivo=".$idadmejecutivo) as $f)
	{
		$valoresCAM=array(
		"estado"=>"'0'"
	   );	
	   $transporte->actualizar($valoresCAM,$f['idtransporte']);

	}
$valores=array(
		"estado"=>"'1'"
	 );	
	if($transporte->actualizar($valores,$idtransporte))
	{

		?>
		<script type="text/javascript">
		swal({
			title: "Exito !!!",
			text: "Activado correctamente",
			type: "success",
			showCancelButton: false,
			confirmButtonColor: "#28e29e",
			confirmButtonText: "OK",
			closeOnConfirm: false
          }, function () {
			location.reload();
          });
		</script>
	<?php
		
	}else{
		?>
			<script type="text/javascript">
				swal("ERROR","No se registro, consulte con sistemas","error");
			</script>
		<?php
	 }
	

?>