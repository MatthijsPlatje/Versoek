<?php
/*
 * Basic site settings and database configuration
 */

//site settings
$siteName = "Versoek";
$siteEmail = "info@versoek.nl";

$siteURL = 'https://';
$siteURL = $siteURL.$_SERVER["SERVER_NAME"].dirname($_SERVER['REQUEST_URI']).'/';

define('DB_HOST', 'sql.versoek.nl');
define('DB_USERNAME', 'username');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'versoek');

