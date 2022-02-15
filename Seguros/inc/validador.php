<? 	
	
	// anti inyection:
	function SanidarParametros($param){
		// ANTI-SQL INYECTION
		$param1 	= explode('/',$param);
		return $param1;
	}
	
	
	// validar vigencia
	function IfVigencia($id){
	   if($id =='3' || $id =='6' || $id =='12' ){ 
	   		return "00";
	   }else{
		   	return "15";
	   }
	}
	
	
	
	
	
	// validar montos
	function IfMontoValido($cod_p){
	
		//if($cod_p ==1){ return 10; }
		
		//if($cod_p ==2){
		// seguros de vehiculos
		 
		 $veh_tipo = VEH_TIPO;
		 
		 $query=mysql_query("
   SELECT id,veh_tipo,3meses,6meses,12meses 
   FROM seguro_tarifas 
   WHERE veh_tipo ='".$veh_tipo."'");


  while($row=mysql_fetch_array($query)){
	  
	  if(VIGENCIA ==3)  return $row['3meses'];
	  if(VIGENCIA ==6)  return $row['6meses'];
	  if(VIGENCIA ==12) return $row['12meses']; 
	  
	  }
				
		//}
	
	//return 0;
		
	}
	
	
	
	function IfSeguroActivo($id){
		   $quT=mysql_query("
		   SELECT id,activo FROM seguros 
		   WHERE id ='".$id."' LIMIT 1");
		   $rT=mysql_fetch_array($quT);
		  
		  if($rT['activo'] =='si'){  
		  	return "00"; 
		}else if($rT['activo'] =='no'){
		  	return "15";
		}
	}
?>