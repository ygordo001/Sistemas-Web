<?php
// Incluimos la clase nusoap.php
require_once('lib/nusoap.php');
require_once('lib/class.wsdlcache.php');

// Creamos el objeto de tipo soap_server
$ns="http://ygordo001.esy.es/Sistemas%20Web/comprobarContrasena.php?wsdl";

$server = new soap_server;
$server->configureWSDL('Contrasenas',$ns);
$server->wsdl->schemaTargetNamespace=$ns;

// Registramos la función que vamos a implementar
$server->register('comprobar',array('x'=>'xsd:string'),array('z'=>'xsd:string'),$ns);

// Implementamos la función
function comprobar ($x){
	if( strpos(file_get_contents("toppasswords.txt"),$x) !== false) {
		return "INVALIDA";
    }
	else {
		return "VALIDA";
	}
}

// Llamamos al método service de la clase nusoap
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>