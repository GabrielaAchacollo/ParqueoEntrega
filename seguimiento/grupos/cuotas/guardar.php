<?php
session_start();
$ruta="../../../";
include_once($ruta."class/seguimiento.php");
$seguimiento=new seguimiento;
include_once($ruta."funciones/funciones.php");
extract($_POST);

	$valores=array(
		"idcredito"=>"'$idcredito'",
		"tiposeguimiento"=>"'$idtiposeguimiento'",
		"fecha"=>"'$idfecha'",
		"fechacompromiso"=>"'$idfechacompromiso'",
		"horacompromiso"=>"'$idhoracompromiso'",
		"respuestallamada"=>"'$respuestallamada'",
		"estado"=>"'1'",
		"observacion"=>"'$iddetalle'"
	 );	
	if($seguimiento->insertar($valores))
	{
		  	?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Registrado Correctamente",
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
	}
	else{
		?>
		<script type="text/javascript">
			sweetAlert("ERROR..", "Intente de nuevo, Consultar con de sistemas", "error");
		</script>
	<?php
	 }

?>