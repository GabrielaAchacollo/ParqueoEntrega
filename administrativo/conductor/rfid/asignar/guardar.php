<?php
session_start();
$ruta="../../../../";
include_once($ruta."class/tarjeta.php");
$tarjeta=new tarjeta;
extract($_POST);
$fecha=date('Y-m-d');
	$valores=array(
		    "idadmejecutivo"=>"'$idadmejecutivo'",
			"codigo"=>"'$idcodigorfid'",
			"fecha"=>"'$fecha'",
			"descripcion"=>"'NUEVO REGISTRO'",
			"estado"=>"'1'"
	 );	
	if($tarjeta->actualizar($valores,$idtarjeta))
	{
		?>
		<script type="text/javascript">
		swal({
			title: "Exito !!!",
			text: "Tarjeta asignado corectamente",
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