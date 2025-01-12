<?php

// Función para verificar si el usuario está autenticado.
function checkAuth()
{

    // Si no existe una sesión activa con el ID del usuario, redirige al login.
    if (!isset($_SESSION['user_id'])) {

        // Redirige al login.php
        header("Location: login.php");
        // Detiene la ejecución del resto del código.
        exit;

    }
}

// Función para verificar si el usuario tiene el rol requerido.
function checkRole($requiredRole)
{
    // Llama a checkAuth para asegurarse de que el usuario esté autenticado.
    checkAuth();
    // Si el rol del usuario no coincide con el rol requerido, se bloquea el acceso.
    if ($_SESSION['rol'] !== $requiredRole) {

        // Devuelve un código HTTP 403 (Acceso prohibido).
        header("HTTP/1.1 403 Forbidden");
        // Muestra un mensaje de error.
        echo "Acceso denegado.";
        // Detiene la ejecución del resto del código.
        exit;
        
    }
}
