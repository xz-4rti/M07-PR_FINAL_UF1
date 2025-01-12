<?php
// Datos de conexión a la base de datos.

$servername = "localhost:3306"; // Dirección del servidor y puerto de la base de datos.
$username = "root"; // Nombre de usuario para acceder a la base de datos.
$password = ""; // Contraseña del usuario.
$dbname = "projecte_final"; // Nombre de la base de datos.

// Intentar establecer la conexión a la base de datos usando PDO.
try {

    // Crear una nueva instancia de PDO con los datos de conexión.
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configurar el modo de errores para que las excepciones sean lanzadas si algo falla.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    // Si ocurre un error en la conexión, se detiene el programa y muestra el mensaje de error.
    die("Error en la conexión: " . $e->getMessage());

}
