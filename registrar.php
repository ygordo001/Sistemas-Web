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
mysql_select_db($baseDatos, $conn);

// Cogemos los valores de las variables
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$contrasena = $_POST['password'];
$telefono = $_POST['telefono'];
$especialidad = $_POST['especialidad'];
$intereses = $_POST['intereses'];

// Comprobamos que el campo para definir otra especialidad existe y cogemos su valor en caso de ser cierto
if ($especialidad == 'otra') {
    $otraEspecialidad = $_POST['otraEspecialidad'];
} 
else {
	$otraEspecialidad = "";
}

$sql = "INSERT INTO `usuario` (`Nombre`, `Apellidos`, `Email`, `Password`, `Telefono`, `Especialidad`, `OtraEspecialidad`, `Intereses`) VALUES ('$nombre', '$apellidos', '$email', '$contrasena', '$telefono', '$especialidad', '$otraEspecialidad', '$intereses');";

if (!mysql_query($sql,$conn)) {
  die('Error: ' . mysql_error());
  }
else echo "<h1 align='center'>Datos añadidos correctamente en la base de datos</h1>";

echo "<h3 align='center'><a href='verUsuarios.php'>Pulse aquí para ver el contenido de la tabla</a></h3>";
 
mysql_close($conn);
?> 
	</body>
</html>