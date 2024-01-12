<?php
session_start();
$ruta="../../../";
include_once($ruta."class/horario.php");
$horario=new horario;
extract($_POST);

//$idplaca=strtoupper($idplaca);
$tran=$horario->mostrarUltimo("estado= 1 and idadmejecutivo=".$idadmejecutivo." and iddiasconfig=".$iddiasconfig." and horainicio='".$idhorainicio."'"." and horafin='".$idhorafin."'");
if (count($tran)>0) 
{
   ?>
	<script type="text/javascript">
		swal("ERROR","Ya existe hora registrado en el dia correspondiente, intente con nuevo horario","error");
	</script>
   <?php                                                          
}else{
	
	$valores=array(
		"idadmejecutivo"=>"'$idadmejecutivo'",
		"horainicio"=>"'$idhorainicio'",
		"horafin"=>"'$idhorafin'",
		"iddiasconfig"=>"'$iddiasconfig'",
		//"descripcion"=>"''",
		"estado"=>"'1'"
	 );	
	if($horario->insertar($valores))
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
}
	

?>