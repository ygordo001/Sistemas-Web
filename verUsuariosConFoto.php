<!DOCTYPE html>
<html>
	<head>	
		<title> Ver Usuarios </title>
		<meta name="keywords" content="ver", "foto", "usuarios">
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
	$bd = mysql_select_db($baseDatos, $conn);
	if (!$bd) {
		die("Conexión fallida: " . mysql_error());
	}
	// Realizamos la consulta en la base de datos
	$consulta="SELECT `Nombre`, `Apellidos`, `Email`, `Telefono`, `Especialidad`, `OtraEspecialidad`, `Intereses`, `Imagen` FROM `usuario` ;";
	$result=mysql_query($consulta);
	
	// Comprobamos si ha ocurrido algun error al realizar la consulta
	if (!$result) { 
    die('Error: ' . mysql_error());
	}
	
	echo "<h1><center>Contenido de la tabla Usuarios</center></h1><br><br>";
	$fields_num = mysql_num_fields($result);
	echo "<table align='center' border='2'><tr>";
	
	// Se muestran los encabezados de las tablas
	for($i=0; $i<$fields_num; $i++)
	{
		$field = mysql_fetch_field($result);
		echo "<th><big> &nbsp {$field->name} &nbsp </big></th>";
	}
	
	echo "</tr>\n";
	  while($row = mysql_fetch_array($result)) { 
		$imagen = $row['Imagen'];
        echo "<tr>";
        echo "<td>" . $row['Nombre'] . "</td>"; 
        echo "<td>" . $row['Apellidos'] . "</td>";
		echo "<td>" . $row['Email'] . "</td>";
		echo "<td>" . $row['Telefono'] . "</td>";
		echo "<td>" . $row['Especialidad'] . "</td>";
		echo "<td>" . $row['OtraEspecialidad'] . "</td>";
		echo "<td>" . $row['Intereses'] . "</td>";
		if ($row['Imagen']!=""){
			echo '<td><img src="data:image/jpeg;base64,'.base64_encode( $row['Imagen'] ).'"width="250" height="100" align="middle"/></td>';
		}
		else {
			echo "<td></td>";
		}
        echo "</tr>"; 
    }
	echo "</table>";
	mysql_close();
	echo "</br><p style='text-align:center'><img src='imagenes/flechaIzda.png' alt='Volver' style='width:40px;height:15px;'><a href='layout.html'>Volver al Inicio</a></p>";
?> 
	</body>
</html>