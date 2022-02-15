<? 	
	// CARGAR TIME ZONE LOCAL
	date_default_timezone_set('America/Santo_Domingo');
	
	// CARGA DE UTILIDAD MEMCACHED
	//include($_SERVER['DOCUMENT_ROOT']."/ws2/inc/class/Memcached_utils.php");
	
	function Conectarse(){ 

		$db_host= "multiseg-prod.cyyrfieqmu0s.us-east-1.rds.amazonaws.com";
		$db_nombre	="multiseg_2"; // Nombre de la Base de Datos que se desea utilizar
		$db_user	="multiseguroscom"; // Nombre del usuario con permisos para acceder
		$db_pass	="Hayunpaisenelmundo"; // Contraseña de dicho usu
		$link=mysql_connect($db_host, $db_user, $db_pass);
		mysql_select_db($db_nombre ,$link); 
}


	// -----------------------------------
	// REGISTRO DE TRANSACCIONES.
	function RegTransaccion($conf){ 
	
		$hora 			= date("H:i:s");	
		$conf['x_id'] 	= str_replace('%','',$conf['x_id']);
	
	mysql_query("
	INSERT INTO seguro_transacciones 
	(user_id,monto,fecha,fecharep,totalpagar,descuento,dist_id,ganancia,producto,x_id,ganancia2,ganancia1,ganancia5,fecha_inicio,fecha_fin,vigencia_poliza,id_vehiculo,id_cliente,serv_adc,id_aseg,id_poliza,id_plan)
 
	VALUES 

	('".$conf['user_id']."','".$conf['monto']."',											
	'".date('Y-m-d H:i:s')."','".date('Y-m-d')."','".$conf['totalpagar']."','".$conf['descuento2']."','".$conf['dist_id']."','".$conf['ganancia']."','".PRODUCTO."','".$_GET['xID']."','".$conf['ganancia2']."','".$conf['ganancia1']."','".$conf['ganancia5']."','".FECHA_INICIO." $hora','".FECHA_FIN." $hora','".VIG_POLIZA."','".ID_VEHICULO."','".ID_CLIENTE."','".SERV_ADC."','".$conf['id_aseg']."','".$conf['id_poliza']."','".$conf['id_plan']."')");
	
	return mysql_insert_id();
}


 
	function FormatDinero($precio){ 
	return number_format($precio, 2, '.', ',');
}


	


	// MANEJO DE LOGS
	function SaveLogs2($params){
		
		$Narch	= $_SERVER['DOCUMENT_ROOT']."/".
		WS_DIR."/Seguros/Logs/".$params['user_id']."_".date("Y-m-d").".log";
			
		$hora 	= date("H:i:s");
		$tiemp 	= getTiempo() - TIM_INIC;
		
	
	if($params['tipo']){
		
		function NomSeg($id){
			$n2s = mysql_query("SELECT id,nombre FROM seguros 
			WHERE id='".$id."' LIMIT 1");
			$ress 	= mysql_fetch_array($n2s);
			return $ress['nombre']; 
		}	
		
	//print_r($params);
	/*$logAdd .= "
		- Params	: ".$params['datos']['x_id']."|
		- Errors	: ".@implode(",",$params['errors'])."
		- RespProv	: ".$params['datos']['provresp']."";*/
		
	//PARA SABER DE QUE DIRECTORIO ESTAN HACIENDO LA PETICION
	
		//$_SERVER['PHP_SELF']
	
	//PARA SABER DE QUE DIRECTORIO ESTAN HACIENDO LA PETICION
	
	$aseg 		= str_pad(NomSeg($params['datos']['id_aseg']).$params['datos']['descrip'],  23, " "); 
	$cliente 	= str_pad($params['datos']['user_id'],  6, " ", STR_PAD_BOTH);
	
	$params['log_text'] = "
	$hora [".$params['tipo']."] CLIENTE[".$cliente."] ==>\tASEG: ".$aseg." ==> \tTIEMPO: ".FormatDinero($tiemp)." Segs. ==>\tMONTO: ".FormatDinero($params['datos']['monto'])."";
		
		}
		
		$arch 	= fopen($Narch,"a");
		fwrite($arch, $params['log_text']);
		fclose($arch);
		
	}
	
	// ==========================
	// CALCULAR TIEMPO
	// ==========================
	function getTiempo() { 
        list($usec, $sec) = explode(" ",microtime()); 
        return ((float)$usec + (float)$sec); 
  }
  
  
  function fecha_despues($fecha,$dias) { 
		
		list ($dia,$mes,$ano)=explode("/",$fecha); 
		if (!checkdate($mes,$dia,$ano)){
			return false;
		} 
		$dia	=	$dia+$dias; 
		$fecha	=	date( "d/m/Y", mktime(0,0,0,$mes,$dia,$ano) ); 
		return $fecha; 
}




	function Fecha_Fin_Mes($fecha,$meses) { 
		return date("Y-m-d", strtotime("+$meses month", strtotime($fecha) )); 
	}
