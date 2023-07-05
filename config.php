<?php
require 'environment.php';

global $config;
global $db;

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/fragrancia/");
	$config['dbname'] = 'brinquedos';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "https://fragranciaewine.com.br/");
	$config['dbname'] = 'brinquedos';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'ZjdurIDu*%%!dkkeH!dmeYjKds';
}

$config['name_company'] = 'Fragrancia';
$config['default_lang'] = 'pt-br';
$config['cep_origin']='06453038';
//Barueri - Cep: 06453038


//Config PagSeguro biadigy@hotmail.com
$config['pagseguro_seller'] = "biadigy@hotmail.com";


$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Fragrancia")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Fragrancia")->setRelease("1.0.0");

\PagSeguro\Configuration\Configure::setEnvironment('production');// sandbox ou production
\PagSeguro\Configuration\Configure::setAccountCredentials('biadigy@hotmail.com','82135cd5-ac93-4740-b17c-bf7d08b379732c4bc69643b3b76bcba25062b90e68f93eb0-9f27-4134-97a2-bc83bf97ac3a');

/* 
token fragrancia
82135cd5-ac93-4740-b17c-bf7d08b379732c4bc69643b3b76bcba25062b90e68f93eb0-9f27-4134-97a2-bc83bf97ac3a */

/* COLOCAR TOKEN DO DONO DA CONTA PAGSEGURO O MEU È ESSE 1e29cffe-d477-46bf-9562-cb5169c8e74af6f9ba564c529f95ac33612a88c697db2006-78dc-4021-8e21-5867894c1566 */

\PagSeguro\Configuration\Configure::setCharset('UTF-8');
\PagSeguro\Configuration\Configure::setLog(true, 'pagseguro.log');
