<?php

session_start(); // Iniciar nueva sesion o ya existiente
require_once 'auth.php'; // Incluye el archivo 'auth.php' para funciones de autenticación.
require_once 'db.php'; // Incluye el archivo 'db.php' para la conexión a la base de datos.


// Verifica que el usuari tenga el rol de Administrador
checkRole('Administrador');

// Verifica si el método de la solicitud es POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtiene el titol y descripcio enviados por el usuario.
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];

    // Prepara una consulta SQL para insertar un nuevo contenido en la base de datos.
    $stmt = $conn->prepare("INSERT INTO contingut (titol, descripcio) VALUES (:titol, :descripcio)");
    
    // Asocia los valores de título y descripción a los marcadores de la consulta.
    $stmt->bindParam(':titol', $titol);
    $stmt->bindParam(':descripcio', $descripcio);

    // Ejecuta la consulta preparada
    $stmt->execute();
    $message = "Contenido añadido correctamente."; // Mensaje de éxito.
    
}

// Prepara una consulta para obtener todos los contenidos existentes.
$stmt = $conn->prepare("SELECT * FROM contingut");
$stmt->execute(); // Ejecuta la consulta.
// Obtiene todos los resultados como un array asociativo.
$contingut = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Include form.php for the frontend -->
<?php include 'form.php'; ?>
