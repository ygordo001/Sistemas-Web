<!DOCTYPE html>
<html>
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
	$consulta="SELECT `Nombre`, `Apellidos`, `Email`, `Telefono`, `Especialidad`, `OtraEspecialidad`, `Intereses` FROM `usuario` ;";
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
	
	// Se muestran las filas de la tabla
	while($row = mysql_fetch_row($result))
	{
		echo "<tr>";
		foreach($row as $cell)
			echo "<td> &nbsp $cell &nbsp </td>";
			
		echo "</tr>\n";
	}
	mysql_close();
?> 
	</body>
</html>