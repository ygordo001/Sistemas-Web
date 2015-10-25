<!DOCTYPE html>
<html>
	<head>
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
		
		<title> Insertar Pregunta </title>
		<meta name="keywords" content="insertar", "pregunta", "formulario">
		<meta name="author" content="Yeray Gordo Castro">

	</head>
	<body bgcolor="#999">
	
	<h1 style="text-align:center">Insertar Pregunta</h1>
	<h3 style="text-align:center">Rellene los siguiente campos para añadir una pregunta</h3><br>
	
	<form id='login' name='login' action="insertarPregunta.php" method="post" onSubmit="return validacion();" > 
			<p style="text-align:center"><b><big>Pregunta <span style="color: red">*</span>: </big></b></p>
			<p style=" text-align:center"><textarea rows="5" cols="50" id="pregunta" name="pregunta"></textarea>
			<p style="text-align:center"><b><big>Respuesta <span style="color: red">*</span>: </big></b></p>
			<p style=" text-align:center"><textarea rows="5" cols="50" id="respuesta" name="respuesta"></textarea>
			<p style="text-align:center"><b><big>Complejidad: </big></b>
			<select id="complejidad" name="complejidad">
				<option value="NULL" selected></option>
    			<option value="1">1</option>
    			<option value="2">2</option>
    			<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
			<p style="text-align:center"><span style="color: red"><b><big>*</big></b></span> Los campos marcados con asterisco (*) son obligatorios. </p>
			<br><p style="text-align:center"><input type="submit" style="width:120px; height:40px; font-weight:bold;" value="Enviar"><span style="display:inline-block; width: 80px;"></span><input type=reset style="width:120px; height:40px; font-weight:bold;" value="Borrar datos"></p>
			<p style="text-align:center"><img src="imagenes/flechaIzda.png" alt="Volver" style="width:40px;height:15px;"> <a href='layout.html'>Volver al Inicio</a></p>
	</form>
<?php
date_default_timezone_set('Europe/Madrid');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
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
		$pregunta = $_POST['pregunta'];
		$respuesta = $_POST['respuesta'];
		$complejidad = $_POST['complejidad'];
		
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
?>
					<script>
					alert("Error al comprobar la sesión de usuario.");
					location.href = "login.php";
					</script>
<?php
			}
		$sql = "INSERT INTO `preguntas` (`Numero`, `Email`, `Pregunta`, `Respuesta`, `Complejidad`) VALUES (NULL, '$email', '$pregunta', '$respuesta', '$complejidad' );";
		if ($errores == true){
?>
				<script>
				alert("Los datos no son correctos, vuelva a intentarlo.");
				location.href = "insertarPregunta.php";
				</script>
<?php	
		}
		else {	
			if (!mysql_query($sql,$conn)) {
			  die('</br>Error: ' . mysql_error());
?>
					<script>
					alert("Error al realizar la inserción en la BD.");
					location.href = "insertarPregunta.php";
					</script>
<?php		  
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
?>
					<script>
					alert("La pregunta se ha añadido correctamente.");
					location.href = "insertarPregunta.php";
					</script>
<?php	
				}
		}
		mysql_close($conn);
 }
?> 
		</body>
	</html>