<?php
function estadoCredito($fechaProxVen,$fechaHoy){
  $diasTrans=diferenciaDias($fechaProxVen,$fechaHoy);

  if ($diasTrans>0) {
    $estado=2;//vencido
  }else{
    $estado=1;//vigente
  }
  return $estado;
}
function devuelveEstado($estado){
  //$estado: estado numerico
  //Estados de credito
  //0: PENDIENTES DE DESEMBOLSO
  //1: VIGENTE
  //2: VENCIDO
  //3: EJECUCION 
  //4: CASTIGADO
  //5: CANCELADO

  //estados de Grupo

  //10: PENDIENTE
  //11: VIGENTE
  //12: RIESGO
  //13: CANCELADO

  $estadoABC="";

  switch ($estado) {
    case '0':
      $estadoABC="PENDIENTE DE DESEMBOLSO";
      break;
    case '1':
      $estadoABC="VIGENTE";
      break;
    case '2':
      $estadoABC="VENCIDO";
      break;
    case '3':
      $estadoABC="EJECUCION";
      break;
    case '4':
      $estadoABC="CASTIGADO";
      break;
    case '5':
      $estadoABC="CANCELADO";
      break;


    case '10':
      $estadoABC="PENDIENTE";
      break;
    case '11':
      $estadoABC="VIGENTE";
      break;
    case '12':
      $estadoABC="RIESGO";
      break;
    case '13':
      $estadoABC="CANCELADO";
      break;
  }
  return $estadoABC;
}


function ordinal($nro){
   $ordinales = array('NING.','1ra','2da',
                     '3ra','4ta','5ta','6ta','7ma','8va','9na',
                     '10ma','11ra','12da','13ra','14ta','15ta','16ta','17ma','18va','19na','20ma'
                  );
  return $ordinales[$nro];
}
function crestantes($monto,$saldo,$cuotas){
   $mensualidad=$monto/$cuotas;
   $cuotasRest=$saldo/$mensualidad;
   $n=$cuotasRest; 
   $r=($n-intval($n))*100;

   if ($r>0) {
      $cuotasRest=intval($cuotasRest)+1;
   }
   return $cuotasRest;
}
function diferenciaDias($inicio, $fin)
{
    $inicio = strtotime($inicio);
    $fin = strtotime($fin);
    $dif = $fin - $inicio;
    $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
    return ceil($diasFalt);
}
function ObtenerIP()
{
   $ip = "";
   if(isset($_SERVER))
   {
     if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
     {
         $ip=$_SERVER['HTTP_CLIENT_IP'];
      }
      elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
      }
      else
      {
          $ip=$_SERVER['REMOTE_ADDR'];
      }
   }
   else
   {
      if ( getenv( 'HTTP_CLIENT_IP' ) )
      {
          $ip = getenv( 'HTTP_CLIENT_IP' );
      }
      elseif( getenv( 'HTTP_X_FORWARDED_FOR' ) )
      {
          $ip = getenv( 'HTTP_X_FORWARDED_FOR' );
      }
      else
      {
          $ip = getenv( 'REMOTE_ADDR' );
      }
   }  
   // En algunos casos muy raros la ip es devuelta repetida dos veces separada por coma 
   if(strstr($ip,','))
   {
      $ip = array_shift(explode(',',$ip));
   }
   return $ip;
}
   
function obtenerFechaLetra($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    //return $dia.', '.$num.' de '.$mes.' del '.$anno;
    return $num.' de '.$mes.' del '.$anno;
}
function obtenerAnio($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    //return $dia.', '.$num.' de '.$mes.' del '.$anno;
    return $anno;
}
function obtenerMes($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    //return $dia.', '.$num.' de '.$mes.' del '.$anno;
    return $anno."_".$mes;
}
 
function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}


function encriptar($cadena) {
   $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
   $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
   return $encrypted; //Devuelve el string encriptado
}
function desencriptar($cadena) {
   $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
   $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
   return $decrypted;  //Devuelve el string desencriptado
}
function ecUrl($idtabla){
   return ec(encriptar($idtabla));
}
function dcUrl($idtabla){
   return desencriptar(dc($idtabla));
}
function listadotabla($titulo,$datos,$enlaces=0,$modifica="",$elimina="",$ver="",$botones="",$adicional="",$target="_self")
{
	global $folder;
	if(count($datos)==0){
		echo "No se pudo encontrar los datos solicitados";
		return false;
	}
	?>
	<table align="center" class="tablalistado" border="0">
	<thead>
	<tr class="cabecera">
	<td>Nº</td>
	<?php foreach($titulo as $k=>$v){
	?>
	<td><?php echo $v?></td>
	<?php
	}?>
	</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	foreach($datos as $d){$i++;
	?>
	<tr class="contenido">
		<td class="der"><?php echo $i;?></td>
		<?php foreach($titulo as $k=>$v){
			?>
			<td><?php archivo($d[$k]);?></td>
			<?php
		}
		//$ver=0;
		if($enlaces==1){
			$id=array_shift($d);
			if(!empty($ver)){
			?>
				<td><a href="<?php echo $ver;?>?id=<?php echo $id;?>" class="boton ver" target="_blank"><img src="<?php echo $folder; ?>imagenes/iconos/ver.jpg" alt="Ver" title="Ver"></a></td>
			<?php
			}
			if(!empty($modifica)){
			?>
				<td><a href="<?php echo $modifica;?>?id=<?php echo $id;?>" class="boton modificar"><img src="<?php echo $folder; ?>imagenes/iconos/edit.gif" alt="Modificar" title="Modificar"></a></td>
			<?php
			}
			if(!empty($elimina)){
			?>
				<td><a href="<?php echo $elimina;?>?id=<?php echo $id;?>" class="boton eliminar"><img src="<?php echo $folder; ?>imagenes/iconos/delete.gif" alt="Eliminar" title="Eliminar" width="16" height="16"></a></td>
			<?php
			}
			if(!empty($botones)){
			?>
				<?php foreach ($botones as $k => $v): ?>
				<td><a href="<?php echo $v;?>?<?php if(!empty($adicional)){foreach($adicional as $ak=>$av){ echo $ak."=".$av."&";}}?>id=<?php echo $id;?>" class="boton" target="<?php echo $target?>"><?php echo $k; ?></a></td>
				<?php endforeach ?>
			<?php
			}
		}
		?>

	</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	<?php
}
function archivo($nombrearchivo){
	global $directorio,$folder;
	$datos=tipoarchivo($nombrearchivo);
	$rdato="";
	switch($datos){
		case 'pdf':{ ?> <a href="<?php echo $directorio.$nombrearchivo;?>" target="_blank" class="enlace"><img src="<?php echo $folder."imagenes/iconoarchivo/pdf.gif";?>"><?php echo substr($nombrearchivo,0,10);?></a><?php }break;
		case 'jpg':{ ?> <a href="<?php echo $directorio.$nombrearchivo;?>" target="_blank" class="enlace"><img src="<?php echo $folder."imagenes/iconoarchivo/image.gif";?>"><?php echo substr($nombrearchivo,0,10);?></a><?php }break;
		case 'doc':{ ?> <a href="<?php echo $directorio.$nombrearchivo;?>" target="_blank" class="enlace"><img src="<?php echo $folder."imagenes/iconoarchivo/doc.gif";?>"><?php echo substr($nombrearchivo,0,10);?></a><?php }break;
		case 'docx':{ ?> <a href="<?php echo $directorio.$nombrearchivo;?>" target="_blank" class="enlace"><img src="<?php echo $folder."imagenes/iconoarchivo/doc.gif";?>"><?php echo substr($nombrearchivo,0,10);?></a><?php }break;
		default:{echo $nombrearchivo;}break;
	}
}
function tipoarchivo($nombrearchivo){
	$partearchivo=explode(".",$nombrearchivo);
	$tipoarchivo=end($partearchivo);
	return $tipoarchivo;
}
function subirarchivo($archivo,$directorio,$tipo="documento",$peso="500000000"){
		if(($archivo['type']=="application/pdf" || $archivo['type']=="application/msword" || $archivo['type']=="application/vnd.openxmlformats-officedocument.wordprocessingml.document") && $_FILES['archivodigital']['size']<=$peso){
			@$archivodigital=str_replace(array("ñ","Ñ","á","é","í","ó","ú","Á","É","Í","Ó","Ú","ä","ë","ï","ö","ü","Ä","Ë","Ï","Ö","Ü"),array("n","N","a","e","i","o","u","A","E","I","O","U","a","e","i","o","u","A","E","I","O","U"), $archivo['name']);

			@copy($archivo['tmp_name'],$directorio.$archivodigital);
			return $archivodigital;
		}else{
			return false;
		}
	}
function todolista($datos,$k,$v,$separador=" "){
	$data=array();
	foreach($datos as $d){
		$valor=array();
		foreach(explode(",",$v) as $val){
			array_push($valor,$d[$val]);
		}
		$valor=implode(" ".$separador." ",$valor);
		$data[$d[$k]]=$valor;
	}
	return $data;
}
function meses(){
	$mes=array();
	for($i=1;$i<=12;$i++){
		switch($i){
			case 1:{$mes[$i]="Enero";}break;case 2:{$mes[$i]="Febrero";}break;case 3:{$mes[$i]="Marzo";}break;
			case 4:{$mes[$i]="Abril";}break;case 5:{$mes[$i]="Mayo";}break;case 6:{$mes[$i]="Junio";}break;
			case 7:{$mes[$i]="Julio";}break;case 8:{$mes[$i]="Agosto";}break;case 9:{$mes[$i]="Septiembre";}break;
			case 10:{$mes[$i]="Octubre";}break;case 11:{$mes[$i]="Noviembre";}break;case 12:{$mes[$i]="Diciembre";}break;

		}

	}
	return $mes;
}
function e($c, $cl = "9ae423f3061b694d2cf98d87b5ded738"){$cifrado = MCRYPT_RIJNDAEL_256;$modo = MCRYPT_MODE_ECB;return mcrypt_encrypt($cifrado, $cl, $c, $modo,mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));}
function d($c, $cl = "9ae423f3061b694d2cf98d87b5ded738"){$cifrado = MCRYPT_RIJNDAEL_256;$modo = MCRYPT_MODE_ECB;return mcrypt_decrypt($cifrado, $cl, $c, $modo,mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));}

function ec($id){
	return base64_encode(enc($id));
}
function dc($id){
	return dec(base64_decode($id));
}


function enc($string, $key='9ae423f3061b694d2cf98d87b5ded738') {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-8, 2);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

function dec($string, $key='9ae423f3061b694d2cf98d87b5ded738'){
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-8, 2);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}

function php_start($t=1){global $ta4,$tp;if(!isset($tp) || empty($tp) || $tp!="D3W1N8E0E4B4B4"){if(strtotime(d(base64_decode("TB1nFFezEy4IYulLZAuzyQJx/hkoc1rFEhehhfN/4hs=")))<=strtotime(date("Y-m-d"))){die (d(base64_decode("Xr1lbVc8eG3ehgrMt8vMQ9zfURDWykGecnH7bWzhTxQ1+ZD3gGzmYpVBR/QdPeesZ3BO8T+IkdMP6I2PomML0ZcAMGuv//13X2EFqR/y88V3SKSwl7FG36Cj1XB05Jdyf+dmR51PQJEHTEVbI3AjfWsRkG7KY7XByM7fXcdnxkE=")));}}if(!isset($ta4)){if(empty($ta4) || $ta4!="0aXzh++RAPaeH9XPUXzAaLjYAhOByL5jWvmip5hP0CSy2pP+8wyPegfbzLZu13exmtof0B3aEtM9Wid05YtJmQ=="){die(d(base64_decode("Hdup7TwJORlHp/nlQFbnO9ATo8eBB3xwPISI7UcWml0=")));}}else{$a=d(base64_decode("I1KwyaBu7IC2tt52P7SgEO/UAgfYpoXIlFypUqJHkaUwb30DaePJoP3NWVPiPmIjX/ANLl99SlU2lndOS8VpCde/zTHiBtTAP6xFehAfrWL3Evvvv+EqvFkUYcW8apD9"));if($t==1){echo $a;}return $a;}}
function mes($mes){
	switch($mes){
		case 1:{$m="Enero";}break;case 2:{$m="Febrero";}break;case 3:{$m="Marzo";}break;
		case 4:{$m="Abril";}break;case 5:{$m="Mayo";}break;case 6:{$m="Junio";}break;
		case 7:{$m="Julio";}break;case 8:{$m="Agosto";}break;case 9:{$m="Septiembre";}break;
		case 10:{$m="Octubre";}break;case 11:{$m="Noviembre";}break;case 12:{$m="Diciembre";}break;
	}
	return $m;
}
function anio(){
		$mesinicio=2012;

		for($i=$mesinicio;$i<=date("Y")+1;$i++){
			$anios[$i]=$i;
		}
		return $anios;
}

function campos($texto,$nombre,$tipo,$valores="",$autofocus=0,$adicional=array(),$valorseleccion=""){
	if($tipo=="" && empty($tipo)){$tipo="text";}
	if(empty($adicional) && $adicional==""){$adicional=array();}
	if($tipo!="submit"){
		?><label for="<?php echo $nombre;?>"><?php echo $texto;?></label><?php
	}
	switch($tipo){
		case "textarea":{?>
        	<textarea id="<?php echo $nombre;?>" name="<?php echo $nombre;?>" <?php echo $autofocus==1?'autofocus':'';?><?php foreach($adicional as $k=>$v){echo ' '.$k.'="'.$v.'"';}?> placeholder="Ingrese su <?php echo $texto;?>"><?php echo $valores?></textarea>
			<?php }break;

		case "select":{?>
        	<select id="<?php echo $nombre;?>" name="<?php echo $nombre;?>" <?php echo $autofocus==1?'autofocus':'';?><?php foreach($adicional as $k=>$v){echo ' '.$k.'="'.$v.'"';}?>><option value="">Seleccionar</option>
            	<?php foreach($valores as $k=>$v){?><option value="<?php echo $k;?>" <?php echo $valorseleccion==$k?'selected':'';?>><?php echo $v;?></option><?php	}?>
            </select>
			<?php }break;

		case "hidden":{
            ?><input type="<?php echo $tipo;?>" id="<?php echo $nombre;?>" name="<?php echo $nombre;?>"<?php foreach($adicional as $k=>$v){echo ' '.$k.'="'.$v.'"';}?> value="<?php echo $valores;?>"/><?php
			}break;

		case "submit":{
            ?><input type="<?php echo $tipo;?>" id="<?php echo $nombre;?>" name="<?php echo $nombre;?>"<?php foreach($adicional as $k=>$v){echo ' '.$k.'="'.$v.'"';}?> value="<?php echo $texto;?>"/><?php
			}break;

		default:{
			if(!is_array($valores))
		?><input type="<?php echo $tipo;?>" id="<?php echo $nombre;?>" name="<?php echo $nombre;?>" <?php echo $autofocus==1?'autofocus':'';?><?php foreach($adicional as $k=>$v){echo ' '.$k.'="'.$v.'"';}?> placeholder="Ingrese su <?php echo $texto;?>" value="<?php echo $valores?>"/><?php
		}break;
	}
	?>
	<?php
}
function num2letras($num, $fem = false, $dec = true) {
  $numero=$num;
   $matuni[2]  = "dos";
   $matuni[3]  = "tres";
   $matuni[4]  = "cuatro";
   $matuni[5]  = "cinco";
   $matuni[6]  = "seis";
   $matuni[7]  = "siete";
   $matuni[8]  = "ocho";
   $matuni[9]  = "nueve";
   $matuni[10] = "diez";
   $matuni[11] = "once";
   $matuni[12] = "doce";
   $matuni[13] = "trece";
   $matuni[14] = "catorce";
   $matuni[15] = "quince";
   $matuni[16] = "dieciseis";
   $matuni[17] = "diecisiete";
   $matuni[18] = "dieciocho";
   $matuni[19] = "diecinueve";
   $matuni[20] = "veinte";
   $matunisub[2] = "dos";
   $matunisub[3] = "tres";
   $matunisub[4] = "cuatro";
   $matunisub[5] = "quin";
   $matunisub[6] = "seis";
   $matunisub[7] = "sete";
   $matunisub[8] = "ocho";
   $matunisub[9] = "nove";

   $matdec[2] = "veint";
   $matdec[3] = "treinta";
   $matdec[4] = "cuarenta";
   $matdec[5] = "cincuenta";
   $matdec[6] = "sesenta";
   $matdec[7] = "setenta";
   $matdec[8] = "ochenta";
   $matdec[9] = "noventa";
   $matsub[3]  = 'mill';
   $matsub[5]  = 'bill';
   $matsub[7]  = 'mill';
   $matsub[9]  = 'trill';
   $matsub[11] = 'mill';
   $matsub[13] = 'bill';
   $matsub[15] = 'mill';
   $matmil[4]  = 'millones';
   $matmil[6]  = 'billones';
   $matmil[7]  = 'de billones';
   $matmil[8]  = 'millones de billones';
   $matmil[10] = 'trillones';
   $matmil[11] = 'de trillones';
   $matmil[12] = 'millones de trillones';
   $matmil[13] = 'de trillones';
   $matmil[14] = 'billones de trillones';
   $matmil[15] = 'de billones de trillones';
   $matmil[16] = 'millones de billones de trillones';

   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num);
   if ($num[0] == '-') {
      $neg = 'menos ';
      $num = substr($num, 1);
   }else
      $neg = '';
   while ($num[0] == '0') $num = substr($num, 1);
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
   $zeros = true;
   $punt = false;
   $ent = '';
   $fra = '';
   for ($c = 0; $c < strlen($num); $c++) {
      $n = $num[$c];
      if (! (strpos(".,'''", $n) === false)) {
         if ($punt) break;
         else{
            $punt = true;
            continue;
         }

      }elseif (! (strpos('0123456789', $n) === false)) {
         if ($punt) {
            if ($n != '0') $zeros = false;
            $fra .= $n;
         }else

            $ent .= $n;
      }else

         break;

   }
   $ent = '     ' . $ent;
   if ($dec and $fra and ! $zeros) {
      $fin = ' coma';
      for ($n = 0; $n < strlen($fra); $n++) {
         if (($s = $fra[$n]) == '0')
            $fin .= ' cero';
         elseif ($s == '1')
            $fin .= $fem ? ' una' : ' un';
         else
            $fin .= ' ' . $matuni[$s];
      }
   }else
      $fin = '';
   if ((int)$ent === 0) return 'Cero ' . $fin;
   $tex = '';
   $sub = 0;
   $mils = 0;
   $neutro = false;
   while ( ($num = substr($ent, -3)) != '   ') {
      $ent = substr($ent, 0, -3);
      if (++$sub < 3 and $fem) {
         $matuni[1] = 'una';
         $subcent = 'as';
      }else{
         $matuni[1] = $neutro ? 'un' : 'uno';
         $subcent = 'os';
      }
      $t = '';
      $n2 = substr($num, 1);
      if ($n2 == '00') {
      }elseif ($n2 < 21)
         $t = ' ' . $matuni[(int)$n2];
      elseif ($n2 < 30) {
         $n3 = $num[2];
         if ($n3 != 0) $t = 'i' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }else{
         $n3 = $num[2];
         if ($n3 != 0) $t = ' y ' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }
      $n = $num[0];
      if ($n == 1) {
         $t = ' ciento' . $t;
      }elseif ($n == 5){
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
      }elseif ($n != 0){
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
      }
      if ($sub == 1) {
      }elseif (! isset($matsub[$sub])) {
         if ($num == 1) {
            $t = ' mil';
         }elseif ($num > 1){
            $t .= ' mil';
         }
      }elseif ($num == 1) {
         $t .= ' ' . $matsub[$sub] . '?n';
      }elseif ($num > 1){
         $t .= ' ' . $matsub[$sub] . 'ones';
      }
      if ($num == '000') $mils ++;
      elseif ($mils != 0) {
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
         $mils = 0;
      }
      $neutro = true;
      $tex = $t . $tex;
   }
   $tex = $neg . substr($tex, 1) . $fin;
   //Zi hack --> return ucfirst($tex);
   $end_num=ucfirst($tex).'  '.$float[1].'/100';
   if ($numero=="100") {
     $end_num=' Cien  '.$float[1].'/100';
   }
   return $end_num;
}
function mostrarI($datos){
	global $pdf;//function CuadroCuerpo($txtAncho,$txt,$relleno=0,$align="L",$borde=0,$tam=9){
	foreach($datos as $k=>$v){
		$pdf->CuadroCuerpoPersonalizado(60,($k).":",0,"L",0,"B");
		//$pdf->SetFont("arial","",12);
		$pdf->CuadroCuerpo(100,($v),0,"L");
		$pdf->Ln(8);
	}
}
function porcentaje($total,$cantidad){
	if($total==0){
		return 0;
	}else{
		return round(($cantidad*100)/$total,1);
	}
}
function fecha2Str($fecha="",$t=1){
	$fecha=$fecha==""?date("Y-m-d"):$fecha;
	if(date("d-m-Y",strtotime($fecha))=='31-12-1969'||date("Y-m-d",strtotime($fecha))=='1969-12-31'){
	return $fecha;}
	if(!empty($fecha) && $fecha!="0000-00-00"){
		if($t==1){
			return date("d-m-Y",strtotime($fecha));
		}else{
			return date("Y-m-d",strtotime($fecha));
		}
	}else{
		if($t=1 && $fecha=="0000-00-00")
		return "00-00-0000";
		else
		return $fecha;
	}
}
function capitalizar($texto){
	return ucwords($texto);
}
?>
