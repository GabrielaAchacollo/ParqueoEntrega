<?php
session_start();
$ruta="../../";
include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
  include_once($ruta."class/grupo.php");
  $grupo=new grupo;
  include_once($ruta."class/ciclo.php");
  $ciclo=new ciclo;
  include_once($ruta."class/grupocredito.php");
  $grupocredito=new grupocredito;
  include_once($ruta."class/vgrupocredito.php");
  $vgrupocredito=new vgrupocredito;
  include_once($ruta."class/credito.php");
  $credito=new credito;
  include_once($ruta."class/creditodetalle.php");
  $creditodetalle=new creditodetalle;
  include_once($ruta."class/personagrupo.php");
  $personagrupo=new personagrupo;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/tipobanca.php");
  $tipobanca=new tipobanca;
  include_once($ruta."class/miempresa.php");
  $miempresa=new miempresa;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/seguimiento.php");
  $seguimiento=new seguimiento;
include_once("../../funciones/funciones.php");
extract($_POST);
   if ($idadmejecutivo==0) 
  { 
      $consulta2="SELECT *
                    from vgrupocredito 
                    where activo=1 and estado=1 ORDER BY fechacierre ASC";
       $titulo='GENERAL';             
  }else{
      $consulta2="SELECT *
                    from vgrupocredito 
                    where activo=1 and idadmejecutivo=$idadmejecutivo and estado=1 ORDER BY fechacierre ASC";
    $eje1=$vadmejecutivo->muestra($idadmejecutivo);
    $titulo=$eje1['nombre'].' '.$eje1['paterno'];              
  }
//$lblcode=ecUrl($idproyecto); 
  echo "
  <fieldset>
     <legend class='titulo'>".$titulo."</legend>
        <table  id='exampleSEGUIM' style='font-size:14px;' class='display' cellspacing='0' width='100%'>
           <thead>
          <tr style='text-align:right;'>
              <th>Cod.Grupo</th>
              <th>Ciclo</th>
              <th>Asesor</th>
              <th>Grupo</th>
              <th>Banca</th>
              <th>Integrantes</th>
              <th style='text-align:right;'>Capital</th>
              <th style='text-align:center;'>Fecha desembolso</th>
              <th style='text-align:center;'>Fecha cierre</th>
              <th>ültima cuota</th>
              <th>Prósima Cuota</th>
              <th>Cuotas</th>
              <th>Estado</th>
              <th>seg</th>
              <th>Contacto Socio(a)</th>
              <th>Socio(a)</th>
              <th>fecha</th>
              <th>Detalles</th>
          </tr>
        </thead>
        <tbody>
      ";

      foreach($vgrupocredito->sql($consulta2) as $f)
      {
          $idgc=$f['idvgrupocredito'];
          $dgr=$grupo->muestra($f['idgrupo']);
          $tba=$tipobanca->muestra($f['idtipobanca']);
          switch ($f['estado']) {
            case '0':
              $estilo="background-color: #FDEDEC;";
            break;
            case '1':
              $estilo="";
            break;
          }
          $eje=$vadmejecutivo->muestra($dgr['idadmejecutivo']);
          $consulta="SELECT count(montoOT)  as 'cantidad',sum(montoOT) as capital FROM credito where idgrupocredito=$idgc and tipocredito=0 and activo=1";
          $dcont=$credito->sql($consulta);
          $dcont=array_shift($dcont);

          $consultaSeg="SELECT c.*, s.idseguimiento, s.fecha, s.respuestallamada, s.observacion   
                        FROM credito c 
                        INNER JOIN seguimiento as s on s.idcredito=c.idcredito
                        WHERE c.activo=1 and c.idgrupocredito=$idgc and s.fecha BETWEEN '$fechaini' AND '$fechafin' GROUP BY c.idpersona";
          foreach($seguimiento->sql($consultaSeg) as $seg)   
          {           
            //$segUlt=$seguimiento->mostrarUltimo("idcredito=".$seg['idcredito']);
            $idcred=$seg['idcredito'];
            //Buscar el ultimo registro
            $consultaSeg2="SELECT *   
                          FROM seguimiento s 
                          WHERE activo=1 and fecha BETWEEN '$fechaini' AND '$fechafin' and idcredito=$idcred ORDER BY idseguimiento ASC";
               foreach($seguimiento->sql($consultaSeg2) as $seg2) 
               {
                      switch ($seg2['respuestallamada']) {
                      case '1':
                        $respuesta='BUENA';
                        $estilo="color: #00AB4E;";
                        break;
                      
                      case '2':
                        $respuesta='REGULAR';
                        $estilo="color: #FF892D;";
                        break;
                      case '3':
                        $respuesta='MALA';
                        $estilo="color: #FF1E1E;";
                        break;  
                    }
                    $fechaUlt=$seg2['fecha'];
                    $obsUlt=$seg2['observacion'];


               }           
               $per=$persona->muestra($seg['idpersona']); 
                    
        echo "
              <tr>
                <td style='text-align:center;'>".$dgr['idgrupo']."</td>
                <td style='text-align:center;'>".$dgr['idciclo']."</td>
                <td >".$eje['nombre'].' '.$eje['paterno'].' '.$eje['materno']."</td> 
                <td>".$dgr['nombre']."</td>
                <td>".$tba['nombre']."</td>  
                <td style='text-align:center'>".$dcont['cantidad']."</td>  
                <td style='text-align:right'>".$dcont['capital']."</td>    
                <td style='text-align:center'>".$f['fechadesembolso']."</td>  
                <td style='text-align:center'>".$f['fechacierre']."</td> 
                <td style='text-align:center'>".$f['fechaultimo']."</td> 
                <td style='text-align:center'>".$f['fechaproximo']."</td> 
                <td style='text-align:right'>".$f['cuota'].'/'.$f['nrocuotas']."</td> 
                <td style='text-align:right'>".devuelveEstado($f['estadocredito'])."</td>                
                <td style=''>".$segUlt['idseguimiento']."</td>
                <td style='text-align:center; font-weight: bold; $estilo'>".$respuesta."</td>
                <td style=''>".$per['nombre'].' '.$per['paterno']."</td>
                <td style='text-align:center'>".$fechaUlt."</td> 

               <td>";
                $consultaSeg3="SELECT *   
                          FROM seguimiento 
                          WHERE activo=1 and fecha BETWEEN '$fechaini' AND '$fechafin' and idcredito=$idcred";
                        $cuenta=0;
                  foreach($seguimiento->sql($consultaSeg3) as $seg3)   
                  { 
                       switch ($seg3['respuestallamada']) {
                        case '1':
                          $respuestaG='BUENA';
                          $estilo="color: #00AB4E;";
                          break;
                        
                        case '2':
                          $respuestaG='REGULAR';
                          $estilo="color: #FF892D;";
                          break;
                        case '3':
                          $respuestaG='MALA';
                          $estilo="color: #FF1E1E;";
                          break;  
                      }
                      $cuenta++;
                      echo "
                           ".$cuenta.".- <b style='font-weight: bold; $estilo'>".$respuestaG." </b>".$seg3['fecha']." ".$seg3['observacion']."<br>
                      ";
                  } 
                echo "</td>
              </tr>
            ";
          }  
      }

 echo "  </tbody>
        <tfoot>
          <tr style='align=center'>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
           </tr>
        </tfoot>
        </table>      
       </fieldset>                         
        "; 
?> 

 <script type="text/javascript">
    $(document).ready(function() {
      
       $('#exampleSEGUIM').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 8, "ASC" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

    });

    </script>  
     

