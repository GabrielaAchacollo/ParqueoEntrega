<?php
session_start();
$ruta="../../";
include_once($ruta."class/estacionamiento.php");
$estacionamiento=new estacionamiento;
extract($_POST);

$idnombre=strtoupper($idnombre);
$esta=$estacionamiento->mostrarUltimo("idcategoria=".$idcategoria." and nombre='".$idnombre."'");
if (count($esta)>0) 
{
   ?>
	<script type="text/javascript">
		swal("ERROR","Ya existe el nombre ingresado, intente con otro numero","error");
	</script>
   <?php                                                          
}else{
	$valores=array(
		"idcategoria"=>"'$idcategoria'",
		"nombre"=>"'$idnombre'",
		"descripcion"=>"'$iddescripcion'",
		"estado"=>"'1'"
	 );	
	if($estacionamiento->insertar($valores))
	{
		?>
		<script type="text/javascript">
		swal({
			title: "Exito !!!",
			text: "Registrado correctamente",
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
				swal("ERROR","No se registro, consulte con sistemas","error");
			</script>
		<?php
	 }
}
	

?>