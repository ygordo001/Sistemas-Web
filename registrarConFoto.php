<!DOCTYPE html>
<html>
	<head>	
		<title> Registrar Usuario </title>
		<meta name="keywords" content="registrar", "usuario", "formulario">
		<meta name="author" content="Yeray Gordo Castro">

	</head>
	<body bgcolor="#999">

<?php

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
	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$email = $_POST['email'];
	$contrasena = $_POST['password'];
	$contrasena2 = $_POST['password2'];
	$telefono = $_POST['telefono'];
	$especialidad = $_POST['especialidad'];
	$intereses = $_POST['intereses'];
	
	// Variable para comprobar si la validacion en el servidor ha sido correcta o no
	$errores = false;

	// Validamos el email por segunda vez	
	if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo '</br> "'.$email.'" no es una dirección de correo válida.'; 
		$errores = true;
	}
	// Validar nombre
	if (empty($nombre)) {
		echo '</br> El campo Nombre es erroneo.';
		$errores = true;
	}
	// Validar apellidos
	if (empty($apellidos)) {
		echo '</br>El campo Apellidos es erroneo.';
		$errores = true;
	}
	// Validar telefono
	if(strlen($telefono)!=9 || !is_numeric($telefono)) {
		echo '</br> "'.$telefono.'" no es un número de teléfono válido.';
		$errores = true;
	}
	// Validar contraseña
	if (empty($contrasena) || empty($contrasena2) || $contrasena!=$contrasena2 ) {
		echo '</br> El campo Contraseña es erroneo.';
		$errores = true;
	}
	// Comprobamos que el campo para definir otra especialidad existe, cogemos su valor en caso de ser cierto y lo validamos
	if ($especialidad == 'otra') {
		$otraEspecialidad = $_POST['otraEspecialidad'];
		if(empty($otraEspecialidad)){
			echo '</br>El campo de otra Especialidad es erroneo.';
			$errores = true;
		}
	} 
	else {
		$otraEspecialidad = "";
	}
	if (isset($_FILES['subirFoto']) && $_FILES['subirFoto']['size'] > 0) { 

		@list(, , $imtype, ) = getimagesize($_FILES['subirFoto']['tmp_name']);
		 if (!isset($msg)) // Si no hay errores
		{
			$data = file_get_contents($_FILES['subirFoto']['tmp_name']);
			$data = mysql_real_escape_string($data);
		}
	}
	$sql = "INSERT INTO `usuario` (`Nombre`, `Apellidos`, `Email`, `Password`, `Telefono`, `Especialidad`, `OtraEspecialidad`, `Intereses`, `Imagen`) VALUES ('$nombre', '$apellidos', '$email', '$contrasena', '$telefono', '$especialidad', '$otraEspecialidad', '$intereses', '$data');";
	
	if ($errores==true){
		echo "<h1 align='center'>Los datos del formulario no son correctos</h1>";
		echo "<h3 align='center'>La información mostrada arriba sobre los campos erroneos únicamente se muestra para mostrar el correcto funcionamiento de la validacion en el servidor.</h3>";
		echo "<h3 align='center'>En un caso real, esta información no debería mostrarse para no dar información sobre como funciona la validación de los datos en el servidor.</h3>";
	}
	else{
		if (!mysql_query($sql,$conn)) {
		  die('</br>Error: ' . mysql_error());
		  }
		else echo "<h1 align='center'>Datos añadidos correctamente en la base de datos</h1>";
		echo "<h3 align='center'><a href='verUsuariosConFoto.php'>Pulse aquí para ver el contenido de la tabla</a></h3>";
	}	
	echo "<p style='text-align:center'><img src='imagenes/flechaIzda.png' alt='Volver' style='width:40px;height:15px;'><a href='layout.html'>Volver al Inicio</a></p>";
	mysql_close($conn);
?> 
	</body>
</html>