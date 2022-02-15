<?
	ini_set('display_errors',1);
	set_time_limit(0);
	include("inc/conexion_inc.php");
	Conectarse();
	
	// --------------------------------------------	
	if($_GET['fecha1']){
		$fecha1 = $_GET['fecha1'];
	}else{ 
		$fecha1 = fecha_despues(''.date('d/m/Y').'',-1);
	}
	// --------------------------------------------
	if($_GET['fecha2']){
		$fecha2 = $_GET['fecha2'];
	}else{
		$fecha2 = fecha_despues(''.date('d/m/Y').'',-1);
	}
	// -------------------------------------------
	
   	$fd1		= explode('/',$fecha1);
	$fh1		= explode('/',$fecha2);
	$fDesde 	= $fd1[2].'-'.$fd1[1].'-'.$fd1[0];
	$fHasta 	= $fh1[2].'-'.$fh1[1].'-'.$fh1[0];
	
	$wFecha2 = "AND fecha >= '$fDesde 00:00:00' AND fecha <= '$fHasta 23:59:59' ";

	
	
	function Datos($id){
	   $queryT=mysql_query("SELECT id, vigencia_poliza, id_vehiculo, id_aseg
	   FROM seguro_transacciones WHERE id ='".$id."'  LIMIT 1");
	   $rowT=mysql_fetch_array($queryT);
		  return $rowT['vigencia_poliza']."|".$rowT['id_vehiculo']."|".$rowT['id_aseg']; 
	}
	
	

	
	function CostoServicioHistory($id,$vigencia){
		$r6 = mysql_query("SELECT * FROM servicios_backup WHERE id='".$id."'LIMIT 1");
		if($id>0){
			   while($row6=mysql_fetch_array($r6)){
				  if($vigencia ==3)  return $row6['3meses_costos'];
				  if($vigencia ==6)  return $row6['6meses_costos'];
				  if($vigencia ==12) return $row6['12meses_costos']; 
			 }
	 	}
		 
	}
	
	
	
?>
<div class="row" >
    <div class="col-lg-12" style="margin-top:-35px;">
        <h3 class="page-header">Actualizar el historial por servicio opcional </h3>
    </div>
</div>

		
    
    
    
   <div class="row"> 
    <div class="col-lg-12">
        <div class="panel panel-default">
    <div class="filter-bar">
  
				<table style="padding-left:3%; padding-bottom:2%; padding-top:3%;" class="table table-striped table-bordered table-hover">
                 
                      <tr>
                    	<td>
                        
                        <label>Desde:</label>
                        <input type="text" name="fecha1" id="fecha1" class="input-mini" value="<?=$fecha1?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <label style="margin-left:5px;">Hasta:</label>
                        <input type="text" name="fecha2" id="fecha2" class="input-mini" value="<?=$fecha2?>" style="width: 95px; height:30px; padding-bottom:2px; padding-left:5px; margin-left:5px;">
                        <button name="bt_buscar" type="button" id="bt_buscar" class="btn btn-success" style="margin-left:10px; margin-left:15px; margin-left:5px;">
                        Actualizar   
                        </button>
                        
                        
                        </td>
                       
                      </tr>
                
               </table>
				
 <script type="text/javascript">
	$('#bt_buscar').click(
	function(){
	var fecha1 	= $('#fecha1').val();
	var fecha2 	= $('#fecha2').val();

	
	CargarAjax2('../ws2/Seguros/UpdateHistorialServicios.php?fecha1='+fecha1+'&fecha2='+fecha2+'&consul=1','','GET','cargaajax');
	    $(this).attr('disabled',true);
	    setTimeout("$('#bt_buscar').fadeOut(0); $('#descargar').fadeOut(0); $('#recargar2').fadeIn(0); ",0);	
}); 

	 $('#bt_buscar').fadeIn(0); 
	$(function() {
		$("#fecha1").datepicker({dateFormat:'dd/mm/yy'});
		$("#fecha2").datepicker({dateFormat:'dd/mm/yy'});
	});
	  </script>

      
   
			</div>
            <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                            <th colspan="2">Descripcion de Datos</th>
                          </tr>
                      </thead>
                      <tbody>
  <? 
  
  if($_GET['consul']=='1'){
	  	
	$query=mysql_query("SELECT * FROM seguro_trans_history WHERE tipo ='serv' $wFecha2 order by id desc");
	//echo "SELECT * FROM seguro_trans_history WHERE tipo ='serv' $wFecha2 order by id desc";
	while($row=mysql_fetch_array($query)){
	
		
		echo "<table width='400' border='1' cellspacing='1' cellpadding='3'>"; 
		
		echo "<tr>
				<td>ID REGISTRO</td>
      			<td>".$row['id']."</td>
			</tr>";
		
		echo "<tr>
				<td>ID TRANS</td>
      			<td>".$row['id_trans']."</td>
			</tr>";
		
		echo "<tr>
				<td>TIPO</td>
      			<td>".$row['tipo']."</td>
			</tr>";
		
		echo "<tr>
				<td>SERVICIO</td>
      			<td>".$row['id_serv_adc']."</td>
			</tr>";
				
		$Veh 		= explode("|", Datos($row['id_trans']));
		$vigencia 	= $Veh[0];
		$vehiculo 	= $Veh[1];
		$id_aseg 	= $Veh[2];
		$costoserv 	= CostoServicioHistory($row['id_serv_adc'],$vigencia);
		echo "<tr>
				<td>VIGENCIA</td>
      			<td>".$vigencia."</td>
			</tr>";
			
		echo "<tr>
				<td>ASEG</td>
      			<td>".$id_aseg."</td>
			</tr>";	
			
		echo "<tr>
				<td>COSTO</td>
      			<td>".$costoserv."</td>
			</tr>
		<table>";
		
		mysql_query("UPDATE seguro_trans_history SET id_aseg ='".$id_aseg."',
		costo = '".$costoserv."' WHERE id='".$row['id']."' LIMIT 1");
		
		//echo "UPDATE seguro_trans_history SET id_aseg ='".$id_aseg."',
		//costo = '".$costoserv."' WHERE id='".$row['id']."' LIMIT 1<br>";
							
	
	
	echo "===============================================<br><br>";
	
	}
  }
  ?>
  
  

    </tbody>
</table>
 </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>


