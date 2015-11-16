<!DOCTYPE html>
<html>
	<head>
	<script language = "javascript">
	
	var XMLHttpRequestObject = null;
	XMLHttpRequestObject = new XMLHttpRequest();

	function estadoPeticion() {
		//Según el estado de la petición devolvemos un Texto.
		switch(XMLHttpRequestObject.readyState) {
			case 0: document.getElementById('divRecibido').innerHTML =
					"<p style='text-align:center'><b>Sin iniciar...</b></p>";
					break;
			case 1: document.getElementById('divRecibido').innerHTML =
					"<p style='text-align:center'><b>Cargando...</b></p>";
					breakn
			case 2: document.getElementById('divRecibido').innerHTML =
					"<p style='text-align:center'><b>Cargado...</b></p>";
					break;
			case 3: document.getElementById('divRecibido').innerHTML =
					"<p style='text-align:center'><b>Interactivo...</b></p>";
					break;
			case 4: document.getElementById('divRecibido').innerHTML =
					"<p style='text-align:center<b>Completado!</b></p>";
					//Si ya hemos completado la petición, devolvemos además la información.
					document.getElementById('divRecibido').innerHTML=XMLHttpRequestObject.responseText;
					break;
		}
	}
	
	function anadirPregunta() {
		if (validacion()== true && XMLHttpRequestObject ){
			XMLHttpRequestObject.onreadystatechange=estadoPeticion;
			var pregunta = document.getElementById("pregunta").value;
			var respuesta = document.getElementById("respuesta").value;
			var complejidad = document.getElementById("complejidad").value;
			var numero = document.getElementById("numero").value;
			
			XMLHttpRequestObject.open("GET", "anadirPregunta.php?pregunta=" + pregunta + "&respuesta=" + respuesta + "&complejidad=" + complejidad, true);
			XMLHttpRequestObject.send();
		}
	}
	
	function modificarPregunta() {
		if (validacionModificar()== true && XMLHttpRequestObject){
			XMLHttpRequestObject.onreadystatechange=estadoPeticion;
			var pregunta = document.getElementById("pregunta").value;
			var respuesta = document.getElementById("respuesta").value;
			var complejidad = document.getElementById("complejidad").value;
			var numero = document.getElementById("numero").value;
			
			XMLHttpRequestObject.open("GET", "modificarPregunta.php?pregunta=" + pregunta + "&respuesta=" + respuesta + "&complejidad=" + complejidad + "&numero=" + numero, true);
			XMLHttpRequestObject.send();
		}
	}
	</script>
	<script type="text/javascript">
		function validacion(){
		
			// Leer valores del formulario
			var pregunta = document.getElementById("pregunta").value;
			var respuesta = document.getElementById("respuesta").value;
			var complejidad = document.getElementById("complejidad").value;
			var error = "";
			// Verificar el formato de la pregunta
			if(pregunta =="" || pregunta== null)
				error += "\tDebe introducir una pregunta.\n";
					
			// Verificar el formato de la respuesta
			if(respuesta =="" || respuesta== null)
				error += "\tDebe introducir una respuesta.\n";
			
			// Si hay algún error, mostrar el mensaje
			if(error != "")
			{
				alert("Validación del formulario:\n" + error);
				return false;
			}
			else
				return true;
		}
		</script>
		<script type="text/javascript">
		function validacionModificar(){
		
			// Leer valores del formulario
			var pregunta = document.getElementById("pregunta").value;
			var respuesta = document.getElementById("respuesta").value;
			var complejidad = document.getElementById("complejidad").value;
			var numero = document.getElementById("numero").value

			var error = "";

			// Verificar el formato de la pregunta
			if(pregunta =="" || pregunta== null)
				error += "\tDebe introducir una pregunta.\n";
					
			// Verificar el formato de la respuesta
			if(respuesta =="" || respuesta== null)
				error += "\tDebe introducir una respuesta.\n";
			
			// Verificar el formato del numero
			if(numero =="" || numero == null)
				error += "\tDebe introducir un número para poder modificar una pregunta.\n";
			
			// Si hay algún error, mostrar el mensaje
			if(error != "")
			{
				alert("Validación del formulario:\n" + error);
				return false;
			}
			else
				return true;
		}
		</script>
		
		<title> Gestión Preguntas </title>
		<meta name="keywords" content="gestionar", "pregunta", "formulario">
		<meta name="author" content="Yeray Gordo Castro">

	</head>
	<body bgcolor="#999">
	
	<h1 style="text-align:center">Gestión Preguntas</h1>
	<h3 style="text-align:center">Añada o modifique sus preguntas</h3><br>
<?php
	// Comprobamos la sesión y cogemos el valor de la variable email. 
		session_start(); 
			if(isset($_SESSION['usuario'])) {
				$email = $_SESSION['email'];
			}
			else {
?>
					<script>
					alert("Error al comprobar la sesión de usuario.");
					location.href = "login.php";
					</script>
<?php
			}
?>
	<div>
		<div id="divPreguntas" style="width:45%;float:left; margin-left:5%;">
		<h3 style="text-align:center">Preguntas añadidas por: &nbsp &nbsp &nbsp &nbsp <span style="color: orangered"><?php echo $email?></span> </h3>
<?php
header('Content-Type: text/html; charset=UTF-8');
	$servidor = "mysql.hostinger.es";
	$usuario = "u575179605_yg001";
	$password = "websystems";
	$baseDatos = "u575179605_quiz";
	
	// Se crea la conexión
	$conn = mysql_connect($servidor, $usuario, $password);
	// Seleccionamos la base de datos
	mysql_select_db($baseDatos, $conn);
	
	
	$sqlpreguntas = "SELECT `Numero`, `Complejidad`, `Pregunta` FROM `preguntas` WHERE Email='$email' ";
	$result=mysql_query($sqlpreguntas);
	if (!mysql_query($sqlpreguntas,$conn)) {
		die('</br>Error: ' . mysql_error());
	}
	$fields_num = mysql_num_fields($result);
	echo "<table align='center' border='0'><tr>";
	// Se muestran los encabezados de la tabla
	$field = mysql_fetch_field($result);
	echo "<th align='left'><big> &nbsp {$field->name} &nbsp </big></th>";
	$field = mysql_fetch_field($result);
	echo "<th><big> &nbsp {$field->name} &nbsp </big></th>";
	$field = mysql_fetch_field($result);
	echo "<th><big> &nbsp {$field->name} &nbsp </big></th>";
	echo "</tr>\n";
	echo "<tr></br></tr><tr></tr>";
	
	while($row = mysql_fetch_array($result)) { 
        echo "<tr></tr><tr>";
		echo "<td align='center'>" . $row['Numero'] ."</td>"; 
        echo "<td align='center'>" . $row['Complejidad'] ."</td>"; 
        echo "<td align='center'>" . $row['Pregunta'] . "</td>";
		echo "<td></td>";
        echo "</tr>"; 
    }
	echo "</table>";
	
?>
		<div id="divRecibido" style="float:center;">
			<p style="text-align:center"></p>	
		</div>
		</div>		
		<div id="divFormulario" style="width:45%; float:right; margin-right:5%;">
			<p style="text-align:center">Para modificar una pregunta deberá indicar su Numero</p>
			<form id='formulario' name='formulario' > 
				<p style="text-align:center"><b><big>Pregunta <span style="color: red">*</span>: </big></b></p>
				<p style=" text-align:center"><textarea rows="5" cols="50" id="pregunta" name="pregunta"></textarea>
				<p style="text-align:center"><b><big>Respuesta <span style="color: red">*</span>: </big></b></p>
				<p style=" text-align:center"><textarea rows="5" cols="50" id="respuesta" name="respuesta"></textarea>
				<p style="text-align:center"><b><big>Numero: </big></b><input type="text" id="numero" name="numero" pattern="[0-9]{1-2}">
				<b><big>&nbsp Complejidad: </big></b>
				<select id="complejidad" name="complejidad">
					<option value="NULL" selected></option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<p style="text-align:center"><span style="color: red"><b><big>*</big></b></span> Los campos marcados con asterisco (*) son obligatorios. </p>
				<br><p style="text-align:center"><input type=button style="width:120px; height:40px; font-weight:bold;" id="botonAnadir" value="Añadir" onclick="anadirPregunta()"><span style="display:inline-block; width: 80px;"></span><input type=button style="width:120px; height:40px; font-weight:bold;" value="Modificar" onclick = "modificarPregunta()"></p>
			</form>
		</div>
		<div style="width:100%; position:fixed; bottom:0; float:center;">
			<p style="text-align:center"><a href='verPreguntasXML.php'>Ver el contenido de la tabla preguntas</a></p>
			<p style="text-align:center"><img src="imagenes/flechaIzda.png" alt="Volver" style="width:40px;height:15px;"> <a href='layout.html'>Volver al Inicio</a></p>
		</div>
	</div>

		</body>
	</html>