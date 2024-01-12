<?php
session_start();
$ruta="../../";
include_once($ruta."class/categoria.php");
$categoria=new categoria;
extract($_POST);

$idnombre=strtoupper($idnombre);

	$valores=array(
		"nombre"=>"'$idnombre'",
		"descripcion"=>"'$iddescripcion'"
	 );	
	if($categoria->actualizar($valores,$idcategoria))
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