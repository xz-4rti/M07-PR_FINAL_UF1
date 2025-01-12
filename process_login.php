<?php

session_start(); // Inicia una nueva sesión o reanuda una existente

// Datos para conectarse a la base de datos
$servername = "localhost:3306"; // Servidor y puerto de la base de datos
$username = "root";             // Nombre de usuario de la base de datos
$password = "";                 // Contraseña de la base de datos
$dbname = "sistema_acces";      // Nombre de la base de datos

// Crear conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión tiene errores
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos enviados desde el formulario
$user = $_POST['username'];
$pass = $_POST['password'];

// Buscar al usuario en la base de datos
$sql = "SELECT * FROM usuaris WHERE nom_usuari = ?"; // Consulta preparada para evitar inyección SQL
$stmt = $conn->prepare($sql); // Preparar la consulta
$stmt->bind_param("s", $user); // Sustituir el marcador "?" con el valor de $user
$stmt->execute(); // Ejecutar la consulta
$result = $stmt->get_result(); // Obtener los resultados de la consulta

// Verificar si se encontró algún usuario
if ($result->num_rows > 0) {

    // Obtener los datos del usuario encontrado
    $row = $result->fetch_assoc(); 
    // Verificar si la contraseña ingresada coincide con la almacenada (hash)
    if (password_verify($pass, $row['contrasenya'])) {

        $_SESSION['user_id'] = $row['id'];          // Guardar el ID del usuario en la sesión
        $_SESSION['username'] = $row['nom_usuari']; // Guardar el nombre de usuario en la sesión
        $_SESSION['role'] = $row['rol'];            // Guardar el rol del usuario en la sesión

        // Redirigir al usuario a diferentes páginas según su rol
        if ($row['nom_usuari'] == "usuari") {

            // Redirigir a la página del usuario
            header("Location: usuari.php");

        } else if ($row['nom_usuari'] == "admin") {

            // Redirigir a la página del administrador
            header("Location: admin.php"); 

        }

    } else {
        echo "Incorrect Password.";
    }

} else {
    echo "User does not exist";
}

// Mostrar los datos enviados desde el formulario (para depuración)
var_dump($_POST);

// Cerrar la consulta y la conexión a la base de datos
$stmt->close();
$conn->close();
?>
