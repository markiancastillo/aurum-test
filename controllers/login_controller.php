<?php
	include('config.php');
	include('security.php');

	$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $port      = $_SERVER['SERVER_PORT'];
    $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
    $domain    = $_SERVER['SERVER_NAME'];

#	define('app_path', "${protocol}://${domain}${disp_port}" . '/aurum/');
    define('app_path', "${protocol}://${domain}");

	$msgDisplay = "";
	$msgSuccess = "<div class='alert alert-success alert-dismissable fade in'>
						<a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						Your password was successfully updated. Try logging in with your new password.
					</div>";

	if(isset($_POST['btnLogin']))
	{
		$inpUsername = base64_encode(openssl_encrypt($_POST['inpUsername'], $method, $password, OPENSSL_RAW_DATA, $iv));
		$inpPassword = base64_encode(openssl_encrypt($_POST['inpPassword'], $method, $password, OPENSSL_RAW_DATA, $iv));

		$sql_login = "SELECT accountID, positionID, accountStatus FROM accounts WHERE accountUsername = ? AND accountPassword = ? AND accountStatus != 'Archived'";
		$params_login = array($inpUsername, $inpPassword);
		$options_login = array("Scrollable"=>'static');
		$stmt_login = sqlsrv_query($con, $sql_login, $params_login, $options_login);
		
		$login_row_count = sqlsrv_num_rows($stmt_login);

		if($login_row_count > 0)
		{
			#login was successful
			session_start();
			#bind the accountID and positionID into the sesison
			#accountID -- identifies the account/user
			#positionID -- identifies the access level
			while($row = sqlsrv_fetch_array($stmt_login))
			{
				$accID = $row['accountID'];
				$posID = $row['positionID'];
				$accountStatus = $row['accountStatus'];
	
				$_SESSION['accID'] = $accID;
				$_SESSION['posID'] = $posID;

				if($accountStatus === 'Active')
				{
					header('location: index.php');
				}
				else if($accountStatus === 'Pending')
				{
					#header('location: change_password.php');
					header('location: index.php');
				}
			}
		}
	}

	if(isset($_GET['reset']))
	{
		$msgDisplay = $msgSuccess;
	}
?>