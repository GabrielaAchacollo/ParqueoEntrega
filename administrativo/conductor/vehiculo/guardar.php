<?php
session_start();
$ruta="../../../";
include_once($ruta."class/transporte.php");
$transporte=new transporte;
include_once($ruta."class/transporteasig.php");
$transporteasig=new transporteasig;
extract($_POST);

$idplaca=strtoupper($idplaca);
//desabilitar para volver activo el nuevo
	foreach($transporteasig->mostrarTodo("estado=1 and idadmejecutivo=".$idadmejecutivo) as $f)
	{
		$valoresCAM=array(
		"estado"=>"'0'"
	   );	
	   $transporteasig->actualizar($valoresCAM,$f['idtransporteasig']);
	}

if ($idflag==1)//nuevo y asignar 
{
	//desabilitar para volver activo el nuevo
	
	$valores=array(
		"idcategoria"=>"'$idcategoria'",
		"placa"=>"'$idplaca'",
		"modelo"=>"'$idmodelo'",
		"color"=>"'$idcolor'",
		"descripcion"=>"'$iddescripcion'",
		"estado"=>"'1'"
	 );	
	if($transporte->insertar($valores))
	{
		$tran=$transporte->mostrarUltimo("placa='".$idplaca."'");
		$idtransporte=$tran['idtransporte'];
		$valores=array(
			"idtransporte"=>"'$idtransporte'",
			"idadmejecutivo"=>"'$idadmejecutivo'",
			"descripcion"=>"'$iddescripcion'",
			"estado"=>"'1'"
		 );	
		if($transporteasig->insertar($valores))
		{
			?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Asignado correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#3ABD8D",
					confirmButtonText: "OK",
					closeOnConfirm: false
		          }, function () {
		          	location.reload();
					//location.href="../";
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
				
	}else{
		?>
			<script type="text/javascript">
				swal("ERROR","No se registro, consulte con sistemas","error");
			</script>
		<?php
	 }
}
if ($idflag==2) //editar y asignar
{
	$valores=array(
		"idcategoria"=>"'$idcategoria'",
		"placa"=>"'$idplaca'",
		"modelo"=>"'$idmodelo'",
		"color"=>"'$idcolor'",
		"descripcion"=>"'$iddescripcion'",
		"estado"=>"'1'"
	 );	
	if($transporte->actualizar($valores,$idtransporteImp))
	{

		$tran=$transporte->mostrarUltimo("placa='".$idplaca."'");
		$idtransporte=$tran['idtransporte'];
		$valores=array(
			"idtransporte"=>"'$idtransporte'",
			"idadmejecutivo"=>"'$idadmejecutivo'",
			"descripcion"=>"'$iddescripcion'",
			"estado"=>"'1'"
		 );	
		if($transporteasig->insertar($valores))
		{
			?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Asignado correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#3ABD8D",
					confirmButtonText: "OK",
					closeOnConfirm: false
		          }, function () {
		          	location.reload();
					//location.href="../";
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
				
	}else{
		?>
			<script type="text/javascript">
				swal("ERROR","No se registro, consulte con sistemas","error");
			</script>
		<?php
	 }
}

?>
