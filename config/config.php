<?php
// MySQL Database Credentials
define( 'DB_HOST' , 'localhost'  ); // Server Location
define( 'DB_NAME' , 'micro'      ); // Database Name
define( 'DB_USER' , 'root'       ); // Username
define( 'DB_PASS' , ''           ); // Password

// Password Salt (do not change this after initial setup)
define( 'SALT' , 'hX1dcqoN9UPztY6zr#jIxI^$%LD$vb$4N0e*bcz8' ); // Put many random characters here directly after installation

// Define root constant from directory above this one (or replace with absolute path)
define( 'ROOT_DIR' , dirname( dirname( __FILE__ ) ) );

// Define log file for Exception Handling
define( 'LOG_FILE' , ROOT_DIR.'/log/log.txt' );

// Define Friendly Error Page for fatal error redirection
define( 'ERROR_DOC' , ROOT_DIR.'/error.html' );

// Define template
define( 'TEMPLATE' , 'default' );

// Define admin directory
define( 'ADMIN_DIR' , 'beheer' );
?>