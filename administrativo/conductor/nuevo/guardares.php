<?php
session_start();
$ruta="../../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
include_once($ruta."class/docente.php");
$docente=new docente;
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$personaB=$persona->mostrarTodo("carnet=".$idcarnet);
$idnombre=strtoupper($idnombre);
$idpaterno=strtoupper($idpaterno);
$idmaterno=strtoupper($idmaterno);
$idocupacion=strtoupper($idocupacion);
$tipoeje=142;
if (count($personaB)==0){
	$valores=array(
		"carnet"=>"'$idcarnet'",
		"expedido"=>"'$idexp'",
		"nombre"=>"'$idnombre'",
		"paterno"=>"'$idpaterno'",
		"materno"=>"'$idmaterno'",
		"nacimiento"=>"'$idnacimiento'",
		"email"=>"'$idemail'",
		"celular"=>"'$idcelular'",
		"idsexo"=>"'$idsexo'",
		"ocupacion"=>"'$idocupacion'",
		"tipopersona"=>"'ESTUDIANTE'"
	 );	
 
	if($persona->insertar($valores))
	{
		$dpersona=$persona->mostrarUltimo("carnet=".$idcarnet);
		$idp=$dpersona['idpersona'];
		$lblcode=ecUrl($dpersona['idpersona']); //aumentado
		$valoresD=array(
		    "idpersona"=>"'$idp'",
		    "idbarrio"=>"'$idzona'",
		    "nombre"=>"'$iddireccion'",
		    "telefono"=>"'$idfono'",
		  ); 
		$domicilio->insertar($valoresD);
		//registrar EJECUTIVO
			
			$idfechaingreso=date('Y-m-d');
			$valores=array(
				"idpersona"=>"'$idp'",
				"idtipo"=>"'$tipoeje'",
				"fechaingreso"=>"'$idfechaingreso'",
				"estado"=>'1',
				"idsede"=>"'1'"
				//"referenciaper"=>"'$idrefper'"
			);	
			$admejecutivo->insertar($valores);
			$dejecutivo=$admejecutivo->mostrarUltimo("idpersona=".$idp." and idtipo=".$tipoeje);
			$idadmejecutivo=$dejecutivo['idadmejecutivo'];

		//REGISTRAR DOCENTE	
			$valoresDOC=array(
				"idadmejecutivo"=>"'$idadmejecutivo'",
				"idcarrera"=>"'$idcarrera'",
				"estado"=>"'1'"
			);	
			$docente->insertar($valoresDOC);

		//REGISTRAR USUARIO
		   $idpass1=$idcarnet;
		   $idusuario=$idcarnet;
		   $idpass1=md5(e($idpass1));
		   $idrol=33; //ROL DE DOCENTE
			//
			$valoresUS=array(
				"idpersona"=>"'$idp'",
				"idadmejecutivo"=>"'0'",
				"usuario"=>"'$idusuario'",
				"pass"=>"'$idpass1'",
				"idrol"=>"'$idrol'"
			);	
			$usuario->insertar($valoresUS);	
		  	?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Docente Registrado Correctamente",
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
				setTimeout(function() {
		            Materialize.toast('<span>2 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
		        }, 1500);
			</script>
		<?php
	 }
 }
 else{
	?>
		<script type="text/javascript">
			sweetAlert("ERROR", "El docente ya se encuentra registrado!", "error");
		</script>
	<?php
}
?>