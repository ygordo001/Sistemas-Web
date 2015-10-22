<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
		function validacion(){
		
			// Leer valores del formulario
			var email = document.getElementById("email").value;
			var contrasena = document.getElementById("contrasena").value;
			
			var expEmail=/^((?:[a-z][a-z]+))([0-9]{3})((@ikasle.ehu.es)|(@ikasle.ehu.eus))$/; // Expresión regular para validar el email
			var error = "";
			
			// Verificar que el campo contraseña es correcto
			if(contrasena.length <6 || contrasena== null)
				error += "\tDebe introducir una contraseña de al menos 6 caracteres.\n";

			// Verificar el formato de la dirección de correo
			if(email =="" || email== null)
				error += "\tDebe introducir un e-mail.\n";
			else if(!expEmail.test(email))
				error += "\tIntroduzca un correo electrónico de la UPV/EHU\n";
			
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
		
		<title> Login </title>
		<meta name="keywords" content="login", "formulario">
		<meta name="author" content="Yeray Gordo Castro">

	</head>
	<body bgcolor="#999">
	
	<h1 style="text-align:center">Login</h1>
	<h3 style="text-align:center">Rellene los siguiente campos para iniciar sesión en la página</h3><br>
	
	<form id='login' name='login' action="login.php" method="post" onSubmit="return validacion();" > 
			<p style="text-align:center"><b><big>E-mail <span style="color: red">*</span>: </big></b><input type="text" id="email" name="email"></p>
			<p style="text-align:center"><b><big>Contraseña <span style="color: red">*</span>: </big></b><input type="password" id="contrasena" name="contrasena"></p>
			<p style="text-align:center"><span style="color: red"><b><big>*</big></b></span> Los campos marcados con asterisco (*) son obligatorios. </p>
			<br><p style="text-align:center"><input type="submit" style="width:120px; height:40px; font-weight:bold;" value="Enviar"><span style="display:inline-block; width: 80px;"></span><input type=reset style="width:120px; height:40px; font-weight:bold;" value="Borrar datos"></p>
			<p style="text-align:center"><img src="imagenes/flechaIzda.png" alt="Volver" style="width:40px;height:15px;"> <a href='layout.html'>Volver al Inicio</a></p>
	</form>
<?php
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
		$email = $_POST['email'];
		$contrasena = $_POST['contrasena'];
		
		$sql = "SELECT `Email`,`Password` FROM `usuario` WHERE email='$email';";
		
		$result = mysql_query($sql,$conn);
		
		if (!mysql_query($sql,$conn)) {
			die('</br>Error: ' . mysql_error());
		}
		
		//Validamos si el nombre del administrador existe en la base de datos o es correcto
		if($row = mysql_fetch_array($result)) { 
		
			//Si el usuario es correcto ahora validamos su contraseña
			if($row["Password"] == $contrasena) {
				
				//Creamos sesión
				session_start();  
				
				//Almacenamos el nombre de usuario  y el email en una variable de sesión usuario
				$_SESSION['usuario'] = $usuario;
				$_SESSION['email'] = $email;
				
				//Redireccionamos a la pagina: insertarPregunta.php
				header("Location: insertarPregunta.php");  
			}
			
			//En caso que la contraseña sea incorrecta enviamos un mensaje y redireccionamos a login.php
			else {
?>	  			
		<script>
			alert("La contraseña introducida es incorrecta.");
			location.href = "login.php";
		</script>
<?php			
			}
		}
		//en caso de que el email sea incorrecto enviamos un mensaje y redireccionamos a login.php
		else {
?>
			<script>
				alert("El e-mail introducido es incorrecto.");
				location.href = "login.php";
			</script>
<?php
		}
			mysql_close($conn);
}
?>
	</body>
</html>