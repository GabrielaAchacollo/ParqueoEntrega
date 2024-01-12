<?php
session_start();
$ruta="../../";
include_once($ruta."class/transporte.php");
$transporte=new transporte;
extract($_POST);

$idnombre=strtoupper($idnombre);

	$valores=array(
		"idcategoria"=>"'$idcategoria'",
			"placa"=>"'$idplaca'",
			"modelo"=>"'$idmodelo'",
			"color"=>"'$idcolor'",
			"descripcion"=>"'$iddescripcion'"
	 );	
	if($transporte->actualizar($valores,$idtransporte))
	{
		?>
		<script type="text/javascript">
		swal({
			title: "Exito !!!",
			text: "Actualizado correctamente",
			type: "success",
			showCancelButton: false,
			confirmButtonColor: "#3ABD8D",
			confirmButtonText: "OK",
			closeOnConfirm: false
          }, function () {
			location.href="../";
          });
		</script>
	<?php
		
	}else{
		?>
			<script type="text/javascript">
				swal("ERROR","No se actualizo, consulte con sistemas","error");
			</script>
		<?php
	 }

?>