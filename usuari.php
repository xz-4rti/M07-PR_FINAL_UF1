<?php

session_start(); // Iniciar nueva sesion o ya existiente
require_once 'auth.php'; // Incluye el archivo 'auth.php' para funciones de autenticación.
require_once 'db.php'; // Incluye el archivo 'db.php' para la conexión a la base de datos.


checkRole('Usuari'); // Verifica que el usuario tenga el rol de 'Usuari'.

// Prepara una consulta para obtener todos los contenidos disponibles.
$stmt = $conn->prepare("SELECT * FROM contingut");
$stmt->execute(); // Ejecuta la consulta.
$contingut = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene todos los resultados como un array asociativo.

?>

<!-- Include dades.php for the frontend -->
<?php include 'dades.php'; ?>