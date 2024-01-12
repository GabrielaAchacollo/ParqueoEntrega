<?php
session_start();
include_once("../../class/vgrupocredito.php");
$vgrupocredito=new vgrupocredito;
include_once("../../class/credito.php");
  $credito=new credito;
  include_once("../../class/grupo.php");
  $grupo=new grupo;
  include_once("../../class/vadmejecutivo.php");
  $vadmejecutivo=new vadmejecutivo;
include_once("../../funciones/funciones.php");
extract($_POST);
//$cli=$proveedor->muestra($idproveedor);
//$lblcode=ecUrl($idproyecto); 
$idadmejecutivo=dcUrl($idadmejecutivo);
  if ($idadmejecutivo==0) 
  { 
      $consulta2="SELECT *
                    from vgrupocredito 
                    where activo=1 and fechacierre BETWEEN '$fechaini' AND '$fechafin' and estado=1 ORDER BY fechacierre ASC";
  }else{
      $consulta2="SELECT *
                    from vgrupocredito 
                    where activo=1 and idadmejecutivo=$idadmejecutivo and fechacierre BETWEEN '$fechaini' AND '$fechafin' and estado=1 ORDER BY fechacierre ASC";
  }
  //Select * from tabla1 where campo3 = max(campo3);
  echo "
  
  <fieldset>
     <legend class='titulo'>Informe mensual de ".$fechaini." al ".$fechafin."</legend>
        <table  id='exampleMEN' style='font-size:14px;' class='display' cellspacing='0' width='100%'>
           <thead>
            <tr style='text-align:right;'>                                       
              <th>Cod.Grupo</th>
              <th>Ciclo</th>
              <th>Asesor</th>
              <th>Grupo</th>
              <th>Int.</th>
              <th style='text-align:right;'>Capital</th>
              <th style='text-align:center;'>Fecha desembolso</th>
              <th  style='text-align:right'>Fecha cierre</th>
              <th>Estado</th>
            </tr>
        </thead>
        <tbody>
      ";
        $totalcapital=0;

       foreach($vgrupocredito->sql($consulta2) as $f) 
      {
        $idgc=$f['idvgrupocredito'];
        $dgr=$grupo->muestra($f['idgrupo']);

          $eje=$vadmejecutivo->muestra($dgr['idadmejecutivo']);
          $consulta="SELECT count(montoOT)  as 'cantidad',sum(montoOT) as capital FROM credito where idgrupocredito=$idgc and tipocredito=0 and activo=1";
          $dcont=$credito->sql($consulta);
          $dcont=array_shift($dcont);
        echo "
              <tr>
                <td style='text-align:center;'>".$dgr['idgrupo']."</td>
                <td style='text-align:center;'>".$dgr['idciclo']."</td>
                <td>".$eje['nombre'].' '.$eje['paterno'].' '.$eje['materno']."</td> 
                <td>".$dgr['nombre']."</td>  
                <td>".$dcont['cantidad']."</td>  
                <td style='text-align:right'>".number_format($dcont['capital'], 2, '.', '')."</td>  
                <td  style='text-align:center'>".$f['fechadesembolso']."</td>  
                <td style='text-align:right'>".$f['fechacierre']."</td>  
                <td style='text-align:right'>".devuelveEstado($f['estadocredito'])."</td> 
              </tr>
            ";
            $totalcapital=$totalcapital+$dcont['capital'];
      }


 echo "
               <tr>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                  <td style='text-align:right'>".number_format($totalcapital, 2, '.', '')."</td>
                   <td></td>
                   <td></td>
                   <td></td> 
              </tr>  
      </tbody>
        <tfoot>
          <tr style='align=center'>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
               <th style='text-align:right'>".number_format($totalcapital, 2, '.', '')."</th>
               
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
      
       $('#exampleMEN').DataTable( {
        "lengthMenu": [[25, 100, -1], [25, 100, "Todo"]],
        dom: 'Bfrtip',
        "order": [[ 0, "DESC" ]],
        buttons: [
           'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

    });

    </script>  
     

