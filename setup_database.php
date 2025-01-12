<?php
// Datos de conexión a la base de datos.

$servername = "localhost:3306"; // Dirección del servidor y puerto de la base de datos.
$username = "root"; // Nombre de usuario para acceder a la base de datos.
$password = ""; // Contraseña del usuario.
$dbname = "projecte_final"; // Nombre de la base de datos.

try {

    // Establecer la conexión al servidor de la base de datos usando PDO.
    $conn = new PDO("mysql:host=$servername", $username, $password);

    // Configurar el modo de errores para que las excepciones sean lanzadas si algo falla.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear la base de datos si no existe.
    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $conn->exec("USE $dbname"); // Seleccionar la base de datos para trabajar en ella.

    // Crear la tabla 'usuaris' si no existe.
    $conn->exec("
        CREATE TABLE IF NOT EXISTS usuaris (
            id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único para cada usuario.
            nom_usuari VARCHAR(50) UNIQUE NOT NULL, -- Nombre de usuario único y obligatorio.
            contrasenya VARCHAR(255) NOT NULL, -- Contraseña cifrada.
            rol ENUM('Administrador', 'Usuari') NOT NULL -- Rol del usuario.
        )
    ");

    // Insertar datos iniciales en la tabla 'usuaris'.
    $passwordAdmin = password_hash('admin123', PASSWORD_BCRYPT); // Cifrar la contraseña del administrador.
    $passwordUser = password_hash('user123', PASSWORD_BCRYPT); // Cifrar la contraseña del usuario.
    $conn->exec("
        INSERT INTO usuaris (nom_usuari, contrasenya, rol) VALUES
        ('admin', '$passwordAdmin', 'Administrador'), -- Usuario administrador.
        ('user', '$passwordUser', 'Usuari')
    ");

    // Crear la tabla 'contingut' si no existe.
    $conn->exec("
        CREATE TABLE IF NOT EXISTS contingut (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titol VARCHAR(100) NOT NULL,
            descripcio TEXT NOT NULL,
            data_creacio DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Mensaje de éxito al finalizar todas las operaciones.
    echo "Base de datos creada exitosamente.";

} catch (PDOException $e) {
    // Si ocurre un error, mostrar el mensaje y detener el programa.
    echo "Error: " . $e->getMessage();
}
