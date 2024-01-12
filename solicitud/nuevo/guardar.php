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

if ($idflag==1) 
{
	$existe=$persona->mostrarTodo("carnet='".$idcarnet."'");	
	if (count($existe)==0){
		$valores=array(
			"carnet"=>"'$idcarnet'",
			"expedido"=>"'$idexp'",
			"nombre"=>"'$idnombre'",
			"paterno"=>"'$idpaterno'",
			"materno"=>"'$idmaterno'",
			"celular"=>"'$idcelular'",
			"tipopersona"=>"'EXTERNO'"
		 );	
		if($persona->insertar($valores))
		{
			$dpersona=$persona->mostrarUltimo("carnet='".$idcarnet."'");
			$idp=$dpersona['idpersona'];

			$valoresD=array(
			    "idpersona"=>"'$idp'"
			    //"idbarrio"=>"'$idzona'",
			    //"nombre"=>"'$iddireccion'",
			    //"telefono"=>"'$idfono'"
			  ); 
				$domicilio->insertar($valoresD);

			$valoresSOL=array(
			"idpersona"=>"'$idp'",
			"fecha"=>"'$idfecha'",
			"hora"=>"'$idhora'",
			"tipo"=>"'$idtipo'",
			"placa"=>"'$idplaca'",
			"modelo"=>"'$idmodelo'",
			"color"=>"'$idcolor'",
			"descripcion"=>"'$iddescripcion'",
			"estado"=>"'0'"
		    );	
			if($solicitud->insertar($valoresSOL))
			{
				?>
					<script type="text/javascript">
					swal({
						title: "Exito !!!",
						text: "Registrado correctamente",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#28e29e",
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
					sweetAlert("Error", "No se pudo realizar la operacion", "error");
				</script>
			   <?php
			}				
		}else{
			?>
				<script type="text/javascript">
					sweetAlert("Error", "No se pudo realizar la operacion", "error");
				</script>
			<?php
		 }
	 }else{
		?>
			<script type="text/javascript">
				sweetAlert("Error", "La persona ya se encuentra registrada!, intente nuevamente", "error");
			</script>
		<?php
	}
}

if ($idflag==2) 
{

	$valores=array(
			"carnet"=>"'$idcarnet'",
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
		$solexis=$solicitud->mostrarUltimo("idpersona=".$idpersonaImp." and fecha=".$idfecha." and tipo=".$idtipo." and hora=".$idhora." and estado=0");
		if (count($solexis)>0) 
		{
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
			if($solicitud->insertar($valoresSOL))
			{
				?>
					<script type="text/javascript">
					swal({
						title: "Exito !!!",
						text: "Registrado correctamente",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#28e29e",
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
					sweetAlert("Error", "No se pudo realizar la operacion", "error");
				</script>
			   <?php
			}
		}else{
			?>
				<script type="text/javascript">
					sweetAlert("Error", "Ya se encuentra registrado el horario y la fecha del conductor", "error");
				</script>
			   <?php
		}
		
	}else{
		sweetAlert("Error", "NO SE REGISTRO", "error");
	}


}
?>