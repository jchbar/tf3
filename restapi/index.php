<?php

	date_default_timezone_set('America/Caracas'); 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'slim/vendor/autoload.php';
require 'controlador/TimbreFiscal.php';
require 'vista/Json.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['logger'] = function($c){
	$logger = new \Monolog\Logger('WebServiceLogger');
	$file_handler = new \Monolog\Handler\StreamHandler("app.log");
	$logger->pushHandler($file_handler);
	return $logger;
};

$container['tf'] = function($c){
	$tf = new TimbreFiscal();
	return $tf;
};

$container['vista'] = function($c){
	$vista = new Json();
	return $vista;
};

$app->get('/V1/{IDTF}', function(Request $req,Response $res,$arg = []) {
	$idtf = $req->getAttribute('IDTF');
	$this->logger->addInfo("logger " . $idtf);
	$info = $this->tf->getTF($idtf);
	$res->getBody()->write("Tipo de Operacion, $idtf" . "</br>");
	if(isset($info)){
		$this->vista->imprimir($info);
	}
    return $res;	
});

$app->run();

?>