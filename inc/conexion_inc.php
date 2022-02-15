<? 	
	// CARGAR TIME ZONE LOCAL
	date_default_timezone_set('America/Anguilla');
	
	// CARGA DE UTILIDAD MEMCACHED
	//@include($_SERVER['DOCUMENT_ROOT']."/ws5_3/inc/class/Memcached_utils.php");
	
	function Conectarse(){ 
		$db_host= "multiseg-prod.cyyrfieqmu0s.us-east-1.rds.amazonaws.com"; // Host al que conectar, habitualmente es el ‘localhost’
		$db_nombre="multiseg_2"; // Nombre de la Base de Datos que se desea utilizar
		$db_user="multiseguroscom"; // Nombre del usuario con permisos para acceder
		$db_pass="Hayunpaisenelmundo"; // Contraseña de dicho usu
		$link=mysql_connect($db_host, $db_user, $db_pass);
		mysql_select_db($db_nombre ,$link); 
	}

	function FormatDinero($precio){
		if(!$precio)
			$precio =0; 
		return number_format($precio, 2, '.', ',');
	}

	// MANEJO DE LOGS
	function SaveLogs2($params){
		$Narch	= $_SERVER['DOCUMENT_ROOT']."/".
		WS_DIR."/Logs/".$params['user_id']."_".date("Y-m-d").".log";
		$hora 	= date("H:i:s");
		$tiemp 	= getTiempo() - TIM_INIC;
	
	if($params['tipo']){
		
		// FORMATO LOG - TRANSACCION COMPLETADA
		$params['datos']['provresp'] = substr($params['datos']['provresp'],0,28);
		if(!$params['datos']['num_tele'])
			$params['datos']['num_tele'] 	='0000000000';
		if(!$_REQUEST['proveedor']){
			$proveedor 						='0000';
		}
		else{
			$proveedor						= LavelCompany2($_REQUEST['proveedor']);
		}
	
	$logAdd .= "T:".$params['datos']['num_tele']." | M:".$params['datos']['monto']
	." |E:".@implode(",",$params['errors'])." | \t".FormatDinero($tiemp)." Segs.";
		  
	$params['log_text'] = "
	$hora [".$params['tipo']."]\t[".$params['datos']['id_pers']."]=>".$proveedor."\t".$logAdd." | \t".$params['datos']['provresp']."";
		  }
		$arch 	= fopen($Narch,"a");
		fwrite($arch, $params['log_text']);
		fclose($arch);
	}
	
	// CALCULAR TIEMPO
	// ==========================
	function getTiempo() { 
        list($usec, $sec) = explode(" ",microtime()); 
        return ((float)$usec + (float)$sec); 
  }
  
function getline( $fp, $delim ) {
		$result = "";
		while( !feof( $fp ) )
		{
			$tmp = fgetc( $fp );
			if( $tmp == $delim )
				return $result;
			$result .= $tmp;
		}
		return $result;
	}
	
function GuardarError($conf,$CodigoError){
		mysql_query("
			INSERT INTO transacciones_fallidas 
			(id_pers,monto,fecha,num_telefono,company,num_ref,proveedor,tiempo,codigo_error,referencia)
			VALUES 
			('".$conf['id_pers']."','".$conf['monto']."',now(),
			'".$conf['num_tel']."','".$conf['company']."',
			'".$num_tran_gener."','Claro','".$tiemp_trans."','".$CodigoError."','".$conf['referencia']."')");	
	}
	
	// anti inyection:
	function LimpiarCampos($param){
		// ANTI-SQL INYECTION
		// --------------------------
		$param 		= str_replace(
		array('',';','INSERT','UPDATE','update','insert',',','FROM','from','select','WHERE','where',' OR ',' or '),"",$param);
		return $param;
	}
