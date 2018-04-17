<?php
// MySQL Database Credentials
define( 'DB_HOST' , 'localhost'  ); // Server Location
define( 'DB_NAME' , 'micro'      ); // Database Name
define( 'DB_USER' , 'root'       ); // Username
define( 'DB_PASS' , ''           ); // Password

// Define root constant from directory above this one (or replace with absolute path)
define( 'ROOT' , dirname( __DIR__ ) );

// Define log file for Exception Handling
define( 'LOG_FILE' , ROOT.'/log/log.txt' );

// Define Friendly Error Page for fatal error redirection
define( 'ERROR_DOC' , ROOT.'/error.html' );
?>