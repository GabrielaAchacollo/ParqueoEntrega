<?php
session_start();
$ruta="../../../";
include_once($ruta."class/horario.php");
$horario=new horario;
extract($_POST);

$valores=array(
	    "estado"=>"'0'",
		"activo"=>"'0'"
	 );	
	if($horario->actualizar($valores,$idhorario))
	{
		?>
		<script type="text/javascript">
		swal({
			title: "Exito !!!",
			text: "Eliminado correctamente",
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