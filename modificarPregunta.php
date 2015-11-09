	
<?php
sleep(1);
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
		$numero = $_GET['numero'];
		
		echo "Datos: ".$pregunta .$respuesta  .$complejidad  .$numero;
		
		// Variable para comprobar si la validacion en el servidor ha sido correcta o no
		$errores = false;
		/*	
		// Validamos la pregunta
		if (empty($pregunta)) {
			$errores = true;
		}
		
		// Validamos la respuesta
		if (empty($respuesta)) {
			$errores = true;
		}
		*/
		// Comprobamos la sesión y cogemos el valor de la variable email. 
		session_start(); 
			if(isset($_SESSION['usuario'])) {
				$email = $_SESSION['email'];
			}
			else {
				echo "Error al comprobar la sesión de usuario.";
			}
		$sql = "UPDATE `preguntas` SET `Pregunta` = '$pregunta', `Respuesta` = '$respuesta', `Complejidad` = '$complejidad' WHERE `preguntas`.`Numero` = '$numero';";
		if ($errores == true){
			echo "Los datos no son correctos vuelve a intentarlo.";	
		}
		else {	
			if (!mysql_query($sql,$conn)) {
			  die('</br>Error: ' . mysql_error());
			  echo "Error al realizar la modificacion en la BD.";		  
			}	
		}
		mysql_close($conn);
?> 