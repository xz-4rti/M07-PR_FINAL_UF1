<?php
// Inicia una sesión
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión actual y sus datos
session_destroy();

// Redirige al usuario a la página de inicio de sesión (login.php)
header("Location: login.php");

// Detiene la ejecución del script para asegurarse de que no se ejecute ningún código adicional
exit();
?>

