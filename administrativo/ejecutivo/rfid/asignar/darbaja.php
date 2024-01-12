<?php
session_start();
$ruta="../../../../";
include_once($ruta."class/tarjeta.php");
$tarjeta=new tarjeta;
extract($_POST);
$fecha=date('Y-m-d');
	$valores=array(
			"estado"=>"'2'"
	 );	
	if($tarjeta->actualizar($valores,$idtarjeta))
	{
		?>
		<script type="text/javascript">
		swal({
			title: "Exito !!!",
			text: "Tarjeta dado de baja corectamente",
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