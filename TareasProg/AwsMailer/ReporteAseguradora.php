<?php
ini_set('display_errors', 1);
set_time_limit(0);
require 'PHPMailerAutoload.php';
include("../../inc/conexion_inc.php");
include("../../inc/nombres.func.php");
include("../../inc/fechas.func.php");
Conectarse();

//echo "carpeta raiz: ".$_SERVER['DOCUMENT_ROOT']."<br>";
//INFO
$fechaw = fecha_despues('' . date('d/m/Y') . '', -1);
$edaw = explode('/', $fechaw);
$fechasdaw = $edaw[2] . "-" . $edaw[1] . "-" . $edaw[0];
$wFecha2 = "fecha >= '$fechasdaw 00:00:00' AND fecha <= '$fechasdaw 23:59:59' ";
// exit();


function enviarEmailHtml($dist_id)
{

	//explode
	$fech = fecha_despues('' . date('d/m/Y') . '', -1);
	$ed = explode('/', $fech);
	$fechasd = $ed[2] . "-" . $ed[1] . "-" . $ed[0];
	$fecha1 = $ed[0] . "-" . $ed[1] . "-" . $ed[2];

/*	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'multiseguros.com.do';
	$mail->SMTPAuth = true;
	$mail->Username = 'operaciones@multiseguros.com.do';
	$mail->Password = '@x43RMcKh9@L';
	$mail->SMTPSecure = 'ssl';
	$mail->From = 'operaciones@multiseguros.com.do';
	$mail->FromName = 'MultiSeguros';
	$mail->Port = '465';
	$mail->SMTPDebug = true;
*/
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'smtp.ckpnd.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'tes@aldeamo.com';
	$mail->Password = 'vroxrVI7YS';
	$mail->SMTPSecure = 'ssl';
	$mail->From = 'operaciones@segurosexpress.com';
	$mail->FromName = 'MultiSeguros';
	$mail->Port = '2526';
	$mail->SMTPDebug = true;

	$query = mysql_query("SELECT * FROM suplidores WHERE id_seguro ='" . $dist_id . "' LIMIT 1");
	$row = mysql_fetch_array($query);

	$desg = explode(",", $row['email_finanzas']);
	$cant = count($desg);
	$cant = $cant - 1;
	if ($_GET['DEBUG']) {
		echo "DEBUG";
	} else {
		for ($i = 0; $i <= $cant; $i++) {
			$mail->AddAddress("" . $desg[$i] . "", "");
		}
	}
	$mail->addAddress('grullon.jose@gmail.com');
	$mail->AddBCC('rivera.nelson.r@gmail.com');

	/*if($dist_id=='1'){
		$carpeta = 'DOM';
	}else if($dist_id=='3'){
		$carpeta = 'GEN';
	}*/


	$archivo1 = '/ws6_3_8/TareasProg/Excel/ASEGURADORA/' . $dist_id . '/MS_RDV_' . $fechasd . '.xls';
	$archivo2 = "/excelFiles/$dist_id/MS_EM_$fechasd.xlsx";
	echo "$archivo1,$archivo2";


	$archivo1 = realpath(__DIR__ . '/../../../') . $archivo1;
	$archivo2 = realpath(__DIR__ . '/../../../') . $archivo2;

	if (!file_exists($archivo1) && !file_exists($archivo2)) {
		return;
	}

	$mail->AddAttachment($archivo1);
	$mail->AddAttachment($archivo2);

	$mail->WordWrap = 50;
	$mail->Subject = 'Ventas de ' . NomAseg($dist_id) . ' del ' . $fecha1 . ' ';
	$mail->Body    = 'para ver el mensaje necesita HTML.';
	$mail->IsHTML(true);


	//$mail->SMTPDebug  = 2;
	$mail->MsgHTML(
		"Buenos d&iacute;as, el archivo de las ventas esta anexado.
		<p>
		--------------------------------------------------------------------------------
<br /><br />
Este mensaje puede contener informaci&oacute;n privilegiada y confidencial. Dicha informaci&oacute;n es exclusivamente para el uso del individuo o entidad al cual es enviada. Si el lector de este mensaje no es el destinatario del mismo, queda formalmente notificado que cualquier divulgaci&oacute;n, distribuci&oacute;n, reproducci&oacute;n o copiado de esta comunicaci&oacute;n est&aacute; estrictamente prohibido. Si este es el caso, favor de eliminar el mensaje de su computadora e informar al emisor a trav&eacute;s de un mensaje de respuesta. Las opiniones expresadas en este mensaje son propias del autor y no necesariamente coinciden con las de MultiSeguros.<br />
<br />
<br />
Gracias.<br />
<br />
<br />
 MultiSeguros"
	);

	if (!$mail->send()) {
		echo "15/error enviando/15";
	} else {
		echo realpath(__FILE__) . "00/mensaje enviado/00";
	}
}



$sq = mysql_query("SELECT * FROM seguros WHERE activo ='si' ");
while ($p = mysql_fetch_array($sq)) {

	$sqaw = mysql_query("SELECT * FROM seguro_transacciones WHERE id_aseg='" . $p['id'] . "' AND $wFecha2 order by id desc limit 1");
	$paw = mysql_fetch_array($sqaw);

	if ($paw['id']) {
		enviarEmailSendiu($p['id']);
	}
}

function enviarEmailSendiu($dist_id){
		//explode
		$fech = fecha_despues('' . date('d/m/Y') . '', -1);
		$ed = explode('/', $fech);
		$fechasd = $ed[2] . "-" . $ed[1] . "-" . $ed[0];
		$fecha1 = $ed[0] . "-" . $ed[1] . "-" . $ed[2];

		$query = mysql_query("SELECT * FROM suplidores WHERE id_seguro ='" . $dist_id . "' LIMIT 1");
		$row = mysql_fetch_array($query);

		$desg = explode(",", $row['email_finanzas']);
		$cant = count($desg);
		$cant = $cant - 1;
		if ($_GET['DEBUG']) {
			echo "DEBUG";
		} else {
			for ($i = 0; $i <= $cant; $i++) {
				$email = "" . $desg[$i] . "";
			}
		}

		$email = 'odalisdabreu@gmail.com';
		$emailCC = 'grullon.jose@gmail.com';

		$archivo1 = '/ws6_3_8/TareasProg/Excel/ASEGURADORA/' . $dist_id . '/MS_RDV_' . $fechasd . '.xls';
		$archivo2 = "/excelFiles/$dist_id/MS_EM_$fechasd.xlsx";
		echo "$archivo1,$archivo2";
		$subject = 'Ventas de ' . NomAseg($dist_id) . ' del ' . $fecha1 . ' ';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.ckpnd.com:5001/v1/email',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
									"to": [
										{
											"email": "'.$email.'"
										}
									],
									"options": {
										"cc": [
											{
												"email": "'.$emailCC.'"
											}
										]
									},
									"from": {
										"email": "operaciones@segurosexpress.com",
										"name": "Multiseguros"
									},
									"replyTo": {
										"email": "operaciones@segurosexpress.com",
										"name": "Multiseguros"
									},
									"subject": "'.$subject.'",
									"body": "
											Buenos d&iacute;as, el archivo de las ventas esta anexado.
											<p>
											--------------------------------------------------------------------------------
											<br /><br />
											Este mensaje puede contener informaci&oacute;n privilegiada y confidencial. Dicha informaci&oacute;n es exclusivamente para el uso del individuo o entidad al cual es enviada. Si el lector de este mensaje no es el destinatario del mismo, queda formalmente notificado que cualquier divulgaci&oacute;n, distribuci&oacute;n, reproducci&oacute;n o copiado de esta comunicaci&oacute;n est&aacute; estrictamente prohibido. Si este es el caso, favor de eliminar el mensaje de su computadora e informar al emisor a trav&eacute;s de un mensaje de respuesta. Las opiniones expresadas en este mensaje son propias del autor y no necesariamente coinciden con las de MultiSeguros.<br />
											<br />
											<br />
											Gracias.<br />
											<br />
											<br />
											MultiSeguros
									",
									"attachments": [
										{
											"path": "'.realpath(__DIR__ . '/../../../') . $archivo1.'"
										},
										{
											"path": "'.realpath(__DIR__ . '/../../../') . $archivo2.'"
										}
									]
								}',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer 3f6cad2f.0f9f49318468647529d45efa',
			'Content-Type: application/json'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;


}