<?
	// ARCHIVO DE CONFIGURACION DEL WEBSERVICE
	// by LinksDominicana.com
	// ----------------------------------------
	
	define("WS_DIR","ws6_3_8");
	define("WS_VER","uWS6.3.8-beta"); 
	
	define("LOGS",1);
	// transacciones que exeden el tiempo:
	define("EXEDTIME",19);
	
	
	// CODIGOS DE RESPUESTA
	// --------------------------------------
	$conf['Cod_resp'] = array(
		'00' => 'Seguro Procesado Correctamente',
		'11' => 'No tiene balance disponible',
		'14' => 'Usuario y/o Password incorrectos',
		'15' => 'Problemas de comunicacion con el webservice',
		'16' => 'Producto no disponible'
	); 
	//---------------------------------------
	
	
	function GetTransID_PAT($user){
		mysql_query(
		"INSERT INTO no_operacion_patria (id,fecha,user_id) 
		VALUES ('','".date('Y-m-d H:i:s')."','".$user."')");
		return mysql_insert_id();
	}
	
	function GetTransID_DOM($user){
		mysql_query(
		"INSERT INTO no_operacion_dominicana (id,fecha,user_id) 
		VALUES ('','".date('Y-m-d H:i:s')."','".$user."')");
		return mysql_insert_id();
	}
	
	function GetTransID_GENERAL($user){
		mysql_query(
		"INSERT INTO no_operacion_general (id,fecha,user_id) 
		VALUES ('','".date('Y-m-d H:i:s')."','".$user."')");
		return mysql_insert_id();
	}
	
	function GetTransID_ATRIO($user){
		mysql_query(
		"INSERT INTO no_operacion_atrio (id,fecha,user_id) 
		VALUES ('','".date('Y-m-d H:i:s')."','".$user."')");
		return mysql_insert_id();
	}
	
	function GetPrefijo($id){
		$sqlp = mysql_query("SELECT id,prefijo FROM seguros 
		WHERE id='".$id."' LIMIT 1");
		$distp = mysql_fetch_array($sqlp);
		return $distp['prefijo'];
	}
	
	
	?>