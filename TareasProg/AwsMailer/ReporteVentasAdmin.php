<?php


	ini_set('display_errors',1);
	set_time_limit(0);
	require 'PHPMailerAutoload.php';
	include("../../inc/conexion_inc.php");
	include("../../inc/nombres.func.php");
	include("../../inc/fechas.func.php");
	Conectarse(); 
	
	
		// exit();
function enviarEmailHtml($html){
	
	//explode
	$fech = fecha_despues(''.date('d/m/Y').'',-1);
	$ed = explode('/',$fech);
	$fechasd = $ed[2]."-".$ed[1]."-".$ed[0];
	$fecha1 = $ed[0]."-".$ed[1]."-".$ed[2];
	
	/*$mail = new PHPMailer;
	$mail->isSMTP();                                     
	$mail->Host = 'mail.multiseguros.com.do';  
	$mail->SMTPAuth = true;                             
	$mail->Username = 'operaciones@multiseguros.com.do';  
	$mail->Password = '@x43RMcKh9@L'; 
	$mail->SMTPSecure = 'tls'; 
	$mail->From = 'operaciones@multiseguros.com.do';
	$mail->FromName = 'MultiSeguros';
	$mail->SMTPDebug = true;*/

	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'smtp.ckpnd.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'tes@aldeamo.com';
	$mail->Password = 'vroxrVI7YS';
	$mail->SMTPSecure = 'tls';
	$mail->From = 'operaciones@segurosexpress.com';
	$mail->FromName = 'MultiSeguros';
	$mail->Port = '2525';
	$mail->SMTPDebug = true;
	
	 
	$mail->addAddress('linksdominicana@gmail.com');
	$mail->addAddress('grullon.jose@gmail.com');

	$archivo1 = '/ws6_3_8/TareasProg/AccionesRep/EXCEL/VENTAS_CLIENTES/Ventas_Clientes_'.$fechasd.'.xls';
	$archivo2 = '/ws6_3_8/TareasProg/AccionesRep/EXCEL/VENTAS/Ventas_Admin_'.$fechasd.'.xls';
	
	$arch21 = realpath(__DIR__.'/../../../').$archivo1; 	  
	$arch22 = realpath(__DIR__.'/../../../').$archivo2; 
	
	$mail->AddAttachment($arch21);
	$mail->AddAttachment($arch22);
	
	
	$mail->WordWrap = 50; 
	$mail->Subject = 'Ventas Administrativas del '.$fecha1.' '; 
	$mail->Body    = 'para ver el mensaje necesita HTML.';
	$mail->IsHTML(true);  
	
	//$mail->AddAttachment($sfile);// <--- Adjuntando archivo
	
	//$mail->SMTPDebug  = 2;
	$mail->MsgHTML(
		"
		
		Buenos Dias, el archivo de las ventas esta anexado.
		<p>
		--------------------------------------------------------------------------------
<br /><br />
Este mensaje puede contener información privilegiada y confidencial. Dicha información es exclusivamente para el uso del individuo o entidad al cual es enviada. Si el lector de este mensaje no es el destinatario del mismo, queda formalmente notificado que cualquier divulgación, distribución, reproducción o copiado de esta comunicación está estrictamente prohibido. Si este es el caso, favor de eliminar el mensaje de su computadora e informar al emisor a través de un mensaje de respuesta. Las opiniones expresadas en este mensaje son propias del autor y no necesariamente coinciden con las de MultiSeguros.<br />
<br />
<br />
Gracias.<br />
<br />
<br />
 MultiSeguros");

	if(!$mail->send()) {
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $mail->ErrorInfo;
		echo "15/error enviando/15";
		
	} else {
		//echo 'Message has been sent';
		echo realpath(__FILE__)."00/mensaje enviado/00"; 
	}

}
	
	
	
if($_GET['enviar']=='1'){		
	$html = file_get_contents(
	"http://127.0.0.1/ws2/TareasProg/AwsMailer/ReporteVentasAdmin.php");
	enviarEmailHtml($html);
	exit();
}

?>