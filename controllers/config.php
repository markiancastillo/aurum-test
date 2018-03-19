<?php
#	Follows the syntax: $servername = "serverName/instanceName";
	$serverName = "den1.mssql2.gear.host";

	$connectionInfo  = array("Database"=>"aurum", "UID"=>"aurum", "PWD"=>"damong_talahiban");
#	If password is not specified, connection will be attempted through windows authentication
#	$connectionInfo = array("Database" => "aurum");
	$con = sqlsrv_connect($serverName, $connectionInfo);
?>
