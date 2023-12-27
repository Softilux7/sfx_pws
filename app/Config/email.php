<?php
class EmailConfig {

	public $default = array(
		'host' => 'smtp.mailgun.org',
		'port' => 587,
		'username' => 'noreply@psfx.com.br',
		'password' => 'sfxilux!',
		'transport' => 'Smtp',
		'tls' => true // As of 2.3.0 you can also enable TLS SMTP
	);
//
//	public $default = array(
//			'host' => 'ssl://smtp.gmail.com',
//			'port' => 465,
//			'username' => 'wagnorama@gmail.com',
//			'password' => 'W29@07#a6',
//			'transport' => 'Smtp',
//// 			'tls' => true // As of 2.3.0 you can also enable TLS SMTP
//	);
}