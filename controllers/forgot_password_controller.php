<?php
	header('Content-Type: text/html; charset=utf-8');
	include('config.php');
	include('security.php');
#	require $_SERVER['DOCUMENT_ROOT'] . '/aurum/lib/PHPMailer/PHPMailerAutoload.php';
#	require_once '../lib/PHPMailer/PHPMailerAutoload.php';

#	$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
	$protocol  = 'http';
    $port      = $_SERVER['SERVER_PORT'];
    $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
    $domain    = $_SERVER['SERVER_NAME'];

	define('app_path', "${protocol}://${domain}" . '/');

#	require_once(app_path . 'lib/PHPMailer/PHPMailerAutoload.php');
	echo 'path: ' . app_path . 'lib/PHPMailer/PHPMailerAutoload.php';

	$msgDisplay = "";
	$msgMismatch = "<div class='alert alert-danger alert-dismissable fade in'>
						<a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						Email address mismatch. Please make sure that both inputs match.
					</div>";
	$msgInvalid = "<div class='alert alert-danger alert-dismissable fade in'>
						<a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						That email address does not exist. Please check your input and try again.
					</div>";
	$msgError = "<div class='alert alert-danger alert-dismissable fade in'>
						<a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						There was an error sending your reset email. Please try again.
					</div>";
	$msgSuccess = "<div class='alert alert-success alert-dismissable fade in'>
						<a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						A reset link has been sent to your email. Please check your inbox.
					</div>";
					
	if(isset($_POST['btnReset']))
	{
		$inpEmail = base64_encode(openssl_encrypt($_POST['inpEmail'], $method, $password, OPENSSL_RAW_DATA, $iv));
		$inpCEmail = base64_encode(openssl_encrypt($_POST['inpCEmail'], $method, $password, OPENSSL_RAW_DATA, $iv));
	
		#email and confirm email must match 
		if(strcmp(trim($inpEmail), trim($inpCEmail)) == 0)
		{
			#match
			#now check if it exists and belongs to an active account
			$sql_check = "SELECT COUNT(accountID) AS emailCount FROM accounts WHERE accountEmail = ? AND accountStatus != ?";
			$params_check = array($inpEmail, 'Archived');
			$stmt_check = sqlsrv_query($con, $sql_check, $params_check);

			while($row = sqlsrv_fetch_array($stmt_check))
			{
				$emailCount = $row['emailCount'];
			}

			if($emailCount <= 0)
			{
				#email does not exist
				$msgDisplay = $msgInvalid;
			}
			else
			{
				#email is existing; get the account details and send an email
				$sql_account = "SELECT accountID, accountFN, accountMN, accountLN, accountEmail FROM accounts WHERE accountEmail = ?";
				$parmas_account = array($inpEmail);
				$stmt_account = sqlsrv_query($con, $sql_account, $parmas_account);

				while($det = sqlsrv_fetch_array($stmt_account))
				{
					$accountID = base64_encode(openssl_encrypt($det['accountID'], $method, $password, OPENSSL_RAW_DATA, $iv));
					$accountFN = htmlspecialchars($det['accountFN'], ENT_QUOTES, 'UTF-8');
					$accountMN = htmlspecialchars($det['accountMN'], ENT_QUOTES, 'UTF-8');
					$accountLN = htmlspecialchars($det['accountLN'], ENT_QUOTES, 'UTF-8');
					$accountEmail = htmlspecialchars($det['accountEmail'], ENT_QUOTES, 'UTF-8');

					$displayFN = htmlspecialchars(openssl_decrypt(base64_decode($det['accountFN']), $method, $password, OPENSSL_RAW_DATA, $iv), ENT_QUOTES, 'UTF-8');
					$displayMN = htmlspecialchars(openssl_decrypt(base64_decode($det['accountMN']), $method, $password, OPENSSL_RAW_DATA, $iv), ENT_QUOTES, 'UTF-8');
					$displayLN = htmlspecialchars(openssl_decrypt(base64_decode($det['accountLN']), $method, $password, OPENSSL_RAW_DATA, $iv), ENT_QUOTES, 'UTF-8');
					$displayName = $displayFN . ' ' . $displayLN;
					$displayEmail = htmlspecialchars(openssl_decrypt(base64_decode($det['accountEmail']), $method, $password, OPENSSL_RAW_DATA, $iv), ENT_QUOTES, 'UTF-8');

					$link = 'http://localhost:8088/aurum/reset_password.php?id=' . urlencode($accountID) . '&request=' . urlencode($accountEmail) . '&user=' . urlencode($accountLN);

/*					# source:
					# https://github.com/PHPMailer/PHPMailer/tree/5.2-stable
					$mail = new PHPMailer;
				
					# 0 - disable (default)
					# 1 - output client messages
					# 2 - output messages sent by client + from server
					# 3 - as 2, + information about the initial connection - can help with STARTTLS failures
					# 4 - as 3, plus even lower level information
					$mail->SMTPDebug = 0; 
				
					$mail->isSMTP();                                      		# Set mailer to use SMTP
					$mail->Host = 'smtp.gmail.com';  					    	# Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                                		# Enable SMTP authentication
					$mail->Username = 'miac.11221127@gmail.com';           		# SMTP username
					$mail->Password = 'damong_talahiban';                       # SMTP password
					$mail->SMTPSecure = 'tls';                            		# Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    		# TCP port to connect to
				
					$mail->setFrom('support@aurum.com', 'Aurum System'); 	  	# sender email that will appear, sender name that will be displayed
					$mail->addAddress($displayEmail, $displayName);	# the address to which the email will be sent, name is optional
					
					$mail->isHTML(true);
					$mail->Subject = 'Password Reset Request'; 
					$mail->Body = '
						Hello ' . $displayName . '!
						<br /><br />
						We have received your password reset request. Here is your reset link:
						<br /><br /> ' .
						$link
						. '<br /><br />
						If you did not request this, you may ignore this email.
						<br /><br />
						Regards, <br />
						Aurum System Team
					';
					
					$mail->AltBody = '
						Hello ' . $displayName . '!

						We have received your password reset request. Here is your reset link: ' .
						$link

						. 'If you did not request this, you may ignore this email.

						Regards, 
						Aurum System Team
					';
				
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
	
					if(!$mail->send()) 
					{
						#echo 'Message was not sent.';
						#echo 'Mailer error: ' . $mail->ErrorInfo;
						$msgDisplay = $msgError;
					}
					else 
					{
						#echo 'Message has been sent.';
						$msgDisplay = $msgSuccess;
					} */
				}
			}
		}
		else 
		{
			#mismatch
			$msgDisplay = $msgMismatch;
		}
	}
?>