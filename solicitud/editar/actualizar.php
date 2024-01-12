<?php
session_start();
$ruta="../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
include_once($ruta."class/solicitud.php");
$solicitud=new solicitud;
include_once($ruta."funciones/funciones.php");
extract($_POST);

$idnombre=strtoupper($idnombre);
$idpaterno=strtoupper($idpaterno);
$idmaterno=strtoupper($idmaterno);

$valores=array(
			//"carnet"=>"'$idcarnet'",
			"expedido"=>"'$idexp'",
			"nombre"=>"'$idnombre'",
			"paterno"=>"'$idpaterno'",
			"materno"=>"'$idmaterno'",
			"celular"=>"'$idcelular'",
			"tipopersona"=>"'EXTERNO'"
		 );	
    if($persona->actualizar($valores,$idpersonaImp))
	{
		$dom=$domicilio->mostrarUltimo("idpersona=".$idpersonaImp);
		if (count($dom)>0) 
		{
			$valoresD=array(
			    "idpersona"=>"'$idpersonaImp'"
			    //"idbarrio"=>"'$idzona'",
			    //"nombre"=>"'$iddireccion'",
			    //"telefono"=>"'$idfono'"
			  ); 
			$domicilio->actualizar($valoresD,$dom['iddomicilio']);			
		}else{
			$valoresD=array(
			    "idpersona"=>"'$idpersonaImp'"
			   // "idbarrio"=>"'$idzona'",
			    //"nombre"=>"'$iddireccion'",
			    //"telefono"=>"'$idfono'"
			  ); 
			$domicilio->insertar($valoresD);			
		}
		  	$valoresSOL=array(
			"idpersona"=>"'$idpersonaImp'",
			"fecha"=>"'$idfecha'",
			"hora"=>"'$idhora'",
			"tipo"=>"'$idtipo'",
			"placa"=>"'$idplaca'",
			"modelo"=>"'$idmodelo'",
			"color"=>"'$idcolor'",
			"descripcion"=>"'$iddescripcion'",
			"estado"=>"'0'"
		    );	
			if($solicitud->actualizar($valoresSOL,$idsolicitud))
			{
				?>
					<script type="text/javascript">
					swal({
						title: "Exito !!!",
						text: "Atualizo correctamente",
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
					sweetAlert("Error", "No se pudo realizar la operacion", "error");
				</script>
			   <?php
			}
	}else{
		sweetAlert("Error", "NO SE REGISTRO", "error");
	}
?>