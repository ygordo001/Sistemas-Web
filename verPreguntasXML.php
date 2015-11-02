<!DOCTYPE html>
<html>
	<head>	
		<title> Ver Preguntas XML</title>
		<meta name="keywords" content="ver", "pregunta", "formulario">
		<meta name="author" content="Yeray Gordo Castro">

	</head>
	<body bgcolor="#999">
	
	<h1 style="text-align:center">Ver preguntas (XML)</h1>
	<h3 style="text-align:center">A continuación se le muestran las preguntas almacenadas en el fichero XML</h3><br>
	
<?php
	$archivo = "preguntas.xml";
	$preguntas = simplexml_load_file($archivo);

	echo "<table align='center' border='0'><tr>";

	// Se muestran los encabezados de la tabla
	echo "<th align='right'><big> &nbsp Complejidad &nbsp </big></th>";
	echo "<th><big> &nbsp Tematica &nbsp </big></th>";
	echo "<th><big> &nbsp Pregunta &nbsp </big></th>";
	echo "</tr>\n";
	echo "<tr></br></tr><tr></tr>";
	// Se muestra el contenido de la tabla
	foreach($preguntas->assessmentItem as $assessmentItem){
		echo "<tr>";
		echo "<td align='center'>{$assessmentItem['complexity']}</td>";
		echo "<td align='center'>{$assessmentItem['subject']}</td>";
		echo "<td>{$assessmentItem->itemBody[0]->p}</td>";
		echo "<td>";
		echo "<br />";	
		echo "</tr>";
	}
	
	echo "</table>";
	echo "</br><p style='text-align:center'><img src='imagenes/flechaIzda.png' alt='Volver' style='width:40px;height:15px;'><a href='layout.html'>Volver al Inicio</a></p>";
?> 
	</body>
</html>