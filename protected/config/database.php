<?php

// This is the database connection configuration.
return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
//    'enableProfiling'=>true,
//    'enableParamLogging' => true,
	'connectionString' => 'mysql:host=localhost;dbname=discipline_chooser',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',

);