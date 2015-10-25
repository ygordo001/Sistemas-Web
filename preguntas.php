<!DOCTYPE html>
<html>
	<head>	
		<title> Preguntas </title>
		<meta name="keywords" content="ver", "pregunta", "formulario">
		<meta name="author" content="Yeray Gordo Castro">

	</head>
	<body bgcolor="#999">
	
	<h1 style="text-align:center">Ver preguntas</h1>
	<h3 style="text-align:center">A continuación se le muestran las preguntas almacenadas en la base de datos</h3><br>
	
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

	
	$sql = "SELECT `Pregunta`, `Complejidad` FROM `preguntas` ";
	$result=mysql_query($sql);

	// Comprobamos si ha ocurrido algun error al realizar la consulta
	if (!$result) { 
		die('Error: ' . mysql_error());
	}
	
	// Añadimos la información de la acción en la base de datos.
	$ip = $_SERVER['REMOTE_ADDR'];
	
	// Reanudamos la sesion en caso de existir
	session_start();
	
	// Si el usuario está logueado
	if((isset($_SESSION))) {
		$email= $_SESSION['email'];
		$sql2 = "SELECT IdCon FROM `conexiones` WHERE Email= '$email';";
		$resultado = mysql_query($sql2);
		if (!$resultado) { 
			die('Error: ' . mysql_error());
		}
		$row = mysql_fetch_array($resultado);
		$idCon = $row['IdCon'];
						
		$sql3 = "INSERT INTO `acciones` (`IdAcc`, `IdCon`, `Email`, `Tipo de Accion`, `Hora Conexion`, `IP Conexion`) VALUES (NULL, '$idCon', '$email', 'Ver preguntas', CURRENT_TIMESTAMP, '$ip');";
		if (!mysql_query($sql3,$conn)) {
			die('</br>Error: ' . mysql_error());
		}
	}
	
	// Si el usuario es anónimo 
	else {
		$sql4 = "INSERT INTO `acciones` (`IdAcc`, `IdCon`, `Email`, `Tipo de Accion`, `Hora Conexion`, `IP Conexion`) VALUES (NULL, NULL, NULL, 'Ver preguntas', CURRENT_TIMESTAMP, '$ip');";
		if (!mysql_query($sql4,$conn)) {
			die('</br>Error: ' . mysql_error());
		}
	}
	
	$fields_num = mysql_num_fields($result);
	echo "<table align='center' border='0'><tr>";

	// Se muestran los emcabezados de la tabla
	$field = mysql_fetch_field($result);
	echo "<th align='left'><big> &nbsp {$field->name} &nbsp </big></th>";
	$field = mysql_fetch_field($result);
	echo "<th><big> &nbsp {$field->name} &nbsp </big></th>";
	echo "</tr>\n";
	echo "<tr></br></tr><tr></tr>";
	
	while($row = mysql_fetch_array($result)) { 
        echo "<tr></tr><tr>";
        echo "<td align='left'>" . $row['Pregunta'] ."</td>"; 
        echo "<td align='center'>" . $row['Complejidad'] . "</td>";
		echo "<td></td>";
        echo "</tr>"; 
    }
	echo "</table>";
	echo "</br><p style='text-align:center'><img src='imagenes/flechaIzda.png' alt='Volver' style='width:40px;height:15px;'><a href='layout.html'>Volver al Inicio</a></p>";
	mysql_close($conn);
?> 
	</body>
</html>