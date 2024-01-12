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
	if ($esta['idestacionamiento']==$idestacionamiento) 
	{
			$valores=array(
			"idcategoria"=>"'$idcategoria'",
			"nombre"=>"'$idnombre'",
			"descripcion"=>"'$iddescripcion'"
		 );	
		if($estacionamiento->actualizar($valores,$idestacionamiento))
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
	}else{
		?>
		<script type="text/javascript">
			swal("ERROR","Ya existe el nombre ingresado, intente con otro numero","error");
		</script>
	   <?php
	}
                                                             
}else{
	$valores=array(
		"idcategoria"=>"'$idcategoria'",
		"nombre"=>"'$idnombre'",
		"descripcion"=>"'$iddescripcion'"
	 );	
	if($estacionamiento->actualizar($valores,$idestacionamiento))
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
}
	

?>