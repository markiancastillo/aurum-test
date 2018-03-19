<?php
	#cipher method to be used
	$method = 'aes-256-cbc';
	$password = '3sc3RLrpd17';
	
	#Must be exact 32 chars (256 bit)
	$password = substr(hash('sha256', $password, true), 0, 32);
	
	#OPENSSL_RAW_DATA - returns binary data
	
	#IV must be exact 16 chars (128 bit)
	$iv = chr(0x74) . chr(0x68) . chr(0x69) . chr(0x73) . chr(0x49) . chr(0x73) . chr(0x41) . chr(0x53) . chr(0x65) . chr(0x63) . chr(0x72) . chr(0x65) . chr(0x74) . chr(0x4b) . chr(0x65) . chr(0x79);
?>