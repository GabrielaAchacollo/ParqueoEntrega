<?php
session_start();
$ruta="../../../";
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;
extract($_POST);

include_once($ruta."funciones/funciones.php");

$valores=array(
	"idpersona"=>"'$idpersona'",
	//"idarea"=>"'$idarea'",
	//"idorganizacion"=>"'$idorg'",
	//"idcargo"=>"'$idcargo'",
	"idtipo"=>"'$tipoeje'",
	"fechaingreso"=>"'$idfechaingreso'",
	//"idhorario"=>'1',
	"estado"=>'1',
	"idsede"=>"'1'",
	"referenciaper"=>"'$idrefper'"
);	
$lblcode=ecUrl($idpersona);

$dato=$admejecutivo->mostrarUltimo("idpersona=".$idpersona);
 
$ideje= $dato['idadmejecutivo'];

 $admejecutivo->eliminar($ideje);

if($admejecutivo->insertar($valores))
{
	$dejecutivo=$admejecutivo->mostrarUltimo("idpersona=".$idpersona);
	$idejecutivo=ecUrl($dejecutivo['idadmejecutivo']);
	 
	?>
		<script  type="text/javascript">
	         	swal({
				  title: "Exito !!!",
				  text: "Ejecutivo Registrado",
				  type: "warning",
				  showCancelButton: false,
				  confirmButtonColor: "#16c103",
				  confirmButtonText: "OK",
				  cancelButtonText: "No. Adm. Ejecutivo",
				  closeOnConfirm: false,
				  closeOnCancel: false
				},
				function(isConfirm){ 
				    location.href=".."; 
				});		
		</script>

	<?php
}
else
{
	?>
	<script type="text/javascript">
		Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
	</script>
	<?php
}
?>