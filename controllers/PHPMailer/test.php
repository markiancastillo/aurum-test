<?php
	require 'PHPMailerAutoload.php';

	# source:
	# https://github.com/PHPMailer/PHPMailer/tree/5.2-stable
	$mail = new PHPMailer;

	# 0 - disable (default)
	# 1 - output client messages
	# 2 - output messages sent by client + from server
	# 3 - as 2, + information about the initial connection - can help with STARTTLS failures
	# 4 - as 3, plus even lower level information
	$mail->SMTPDebug = 3; 

	$mail->isSMTP();                                      		# Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  					    	# Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                                		# Enable SMTP authentication
	$mail->Username = 'miac.11221127@gmail.com';           		# SMTP username
	$mail->Password = 'damong_talahiban';                       # SMTP password
	$mail->SMTPSecure = 'tls';                            		# Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    		# TCP port to connect to

	$mail->setFrom('aurum@example.com', 'Your Name'); 	  		# sender email that will appear, sender name that will be displayed
	$mail->addAddress('mark05ian95@gmail.com', 'My Client');	# the address to which the email will be sent, name is optional
	
	$mail->isHTML(true);
	$mail->Subject = 'First PHPMailer Message'; 
	$mail->Body = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	# allows insecure connections by using the SMTPOptions property
	# taken from:
	# https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting#php-56-certificate-verification-failure
	$mail->SMTPOptions = array(
    	'ssl' => array(
    	    'verify_peer' => false,
    	    'verify_peer_name' => false,
    	    'allow_self_signed' => true
    	)
	);

	if(!$mail->send()) {
		echo 'Message was not sent.';
		echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
		echo 'Message has been sent.';
	}
?>