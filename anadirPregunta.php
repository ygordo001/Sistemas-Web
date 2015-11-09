<!DOCTYPE html>
<html>
	<head>
		
<?php
date_default_timezone_set('Europe/Madrid');
	$servidor = "mysql.hostinger.es";
	$usuario = "u575179605_yg001";
	$password = "websystems";
	$baseDatos = "u575179605_quiz";
	 
		// Se crea la conexión
		$conn = mysql_connect($servidor, $usuario, $password);
		
		// Se comprueba la conexión
		if (!$conn) {
			die("Conexión fallida: " . mysql_error());
		}

		// Seleccionamos la base de datos
		mysql_select_db($baseDatos, $conn);

		// Cogemos los valores de las variables
		$pregunta = $_GET['pregunta'];
		$respuesta = $_GET['respuesta'];
		$complejidad = $_GET['complejidad'];
		
		// Variable para comprobar si la validacion en el servidor ha sido correcta o no
		$errores = false;
			
		// Validamos la pregunta
		if (empty($pregunta)) {
			$errores = true;
		}
		
		// Validamos la respuesta
		if (empty($respuesta)) {
			$errores = true;
		}
		
		// Comprobamos la sesión y cogemos el valor de la variable email. 
		session_start(); 
			if(isset($_SESSION['usuario'])) {
				$email = $_SESSION['email'];
			}
			else {
				echo "Error al comprobar la sesión de usuario.";
			}
		$sql = "INSERT INTO `preguntas` (`Numero`, `Email`, `Pregunta`, `Respuesta`, `Complejidad`) VALUES (NULL, '$email', '$pregunta', '$respuesta', '$complejidad' );";
		if ($errores == true){
			echo "Los datos no son correctos vuelve a intentarlo.";
		}
		else {	
			if (!mysql_query($sql,$conn)) {
			  die('</br>Error: ' . mysql_error());
			  echo "Error al realizar la inserción en la BD.";	  
			}
			
			// Añadimos la información de la acción en la base de datos.
			else{
					
					$ip = $_SERVER['REMOTE_ADDR'];
					$sql2 = "SELECT IdCon FROM `conexiones` WHERE Email= '$email';";
					$result= mysql_query($sql2);
					if (!$result) { 
						die('Error: ' . mysql_error());
					}
					$row = mysql_fetch_array($result);
					$idCon = $row['IdCon'];
					
					$sql3 = "INSERT INTO `acciones` (`IdAcc`, `IdCon`, `Email`, `Tipo de Accion`, `Hora Conexion`, `IP Conexion`) VALUES (NULL, '$idCon', '$email', 'Insertar pregunta', CURRENT_TIMESTAMP, '$ip');";
					if (!mysql_query($sql3,$conn)) {
						die('</br>Error: ' . mysql_error());
					}
					echo "La pregunta se ha añadido correctamente.";
					
					// Añadimos la pregunta al archivo 'preguntas.xml'
					$archivo = "preguntas.xml";
					$preguntas = simplexml_load_file($archivo);
					if ($preguntas === false) {
						echo "Error al cargar el fichero XML.";
					}
					else {
						// Creamos un nuevo elemento 
						$assessmentItem = $preguntas->addChild("assessmentItem");
						// Añadimos los atributos
						$assessmentItem->addAttribute('complexity',$complejidad);
						$assessmentItem->addAttribute('subject', "");
						// Creamos los hijos
						$itemBody = $assessmentItem->addChild('itemBody');
						$itemBody->addChild('p', $pregunta);
						$correctResponse = $assessmentItem->addChild("correctResponse");
						$correctResponse->addChild("value", $respuesta);
						// Guardamos los cambios
						$preguntas->asXML($archivo);
						
						$preguntas = new DOMDocument('1.0');
						$preguntas->preserveWhiteSpace = false;
						$preguntas->formatOutput = true;
						$preguntas->loadXML($archivo->asXML());
						$preguntas->saveXML();

					}
				}
		}
		mysql_close($conn);
?> 
		</body>
	</html>