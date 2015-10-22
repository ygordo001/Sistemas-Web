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
	/*
	$espaciado= "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
	echo "";
	echo "<p style='text-align:center'> <b><big> Pregunta : "."$espaciado"."$espaciado"."$espaciado"." Complejidad: </big></b></p>";
	  while($row = mysql_fetch_array($result)) { 
		//echo "<p style='text-align:center'> <b><big> Pregunta : "."$espaciado"." Complejidad: </big></b></p>";
        echo "<p style='text-align:center'>".$row['Pregunta']."$espaciado"."$espaciado"."$espaciado".$row['Complejidad']."</p>";  
    }
	*/
	echo "</br><p style='text-align:center'><img src='imagenes/flechaIzda.png' alt='Volver' style='width:40px;height:15px;'><a href='layout.html'>Volver al Inicio</a></p>";
	mysql_close($conn);
?> 
	</body>
</html>