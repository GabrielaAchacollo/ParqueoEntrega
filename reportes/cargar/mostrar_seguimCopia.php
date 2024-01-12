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
              <th>Rep.Llamada</th>
              <th>Cliente</th>
              <th>fecha</th>
              <th>Obs</th>
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
                        WHERE c.activo=1 and c.idgrupocredito=$idgc and s.fecha BETWEEN '$fechaini' AND '$fechafin'";
          foreach($seguimiento->sql($consultaSeg) as $seg)   
          { 
          $per=$persona->muestra($seg['idpersona']); 
               switch ($seg['respuestallamada']) {
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
                
                <td style=''>".$seg['idseguimiento']."</td>
                <td style='text-align:center; font-weight: bold; $estilo'>".$respuesta."</td>
                <td style=''>".$per['nombre']."</td>
                <td style='text-align:center'>".$seg['fecha']."</td> 
                <td >".$seg['observacion']."</td> 
               
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
     

