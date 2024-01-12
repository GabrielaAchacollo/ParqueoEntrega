<?php
session_start();
$ruta="../";
include_once($ruta."class/solicitud.php");
$solicitud=new solicitud;
extract($_POST);

$valores=array(
	    "estado"=>"'3'"
		//"activo"=>"'0'"
	 );	
	if($solicitud->actualizar($valores,$idsolicitud))
	{
		?>
		<script type="text/javascript">
		swal({
			title: "Exito !!!",
			text: "Cancelado correctamente",
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