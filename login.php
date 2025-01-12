<?php

session_start(); // Iniciar nueva sesion o ya existiente
require_once 'db.php'; // Inclue el archivo solo una vez para evitar duplicados

// Verifica si el método de la solicitud es POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtiene el nombre de usuario y la contraseña enviados por el usuario.
    $nom_usuari = $_POST['nom_usuari'];
    $contrasenya = $_POST['contrasenya'];

    // Prepara una consulta SQL para buscar al usuario por su nombre de usuario.
    $stmt = $conn->prepare("SELECT * FROM usuaris WHERE nom_usuari = :nom_usuari");

    // Asocia el valor de $nom_usuari al marcador :nom_usuari en la consulta.
    $stmt->bindParam(':nom_usuari', $nom_usuari);

    $stmt->execute(); // Ejecuta la consulta preparada

    // Obtiene el primera fila del resultado si existe. Devuelve false si no hay resultados.
    $usuari = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si el usuario existe y si la contraseña es válida.
    // la funcion password_verfy esta en el fichero auth.php
    if ($usuari && password_verify($contrasenya, $usuari['contrasenya'])) {

        // Guarda el ID del usuario y su rol en la sesión para que inicie sesión.
        $_SESSION['user_id'] = $usuari['id'];
        $_SESSION['rol'] = $usuari['rol'];

        // Redirige al usuario según su rol: a 'admin.php' si es Administrador, o a 'usuari.php' si no lo es.
        if ($usuari['rol'] === 'Administrador') {
            header("Location: admin.php"); // Redirect admin to admin.php
        } else {
            header("Location: usuari.php"); // Redirect regular user to usuari.php
        }

        // Detiene la ejecución del código después de la redirección.
        exit;

    } else {

        // Si la autenticación falla, guarda un mensaje de error.
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <!-- Formulario de inicio de sesión  -->
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form method="POST">
            <input type="text" name="nom_usuari" placeholder="Usuario" required>
            <input type="password" name="contrasenya" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </div>
</body>

</html>