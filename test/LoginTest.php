<?php

// Incluimos una herramienta que nos ayuda a hacer pruebas de nuestras funciones.
use PHPUnit\Framework\TestCase;

// Creamos una clase que contiene las pruebas para el inicio de sesión.
class LoginTest extends TestCase {

    // Declaramos una variable para guardar la conexión a la base de datos.
    private PDO $conn;
    
    // Esta función se ejecuta antes de cada prueba para preparar la conexión
    protected function setUp(): void
    {
        $servername = "localhost:3306"; // Dirección del servidor y puerto de la base de datos.
        $username = "root"; // Nombre de usuario para acceder a la base de datos.
        $password = ""; // Contraseña del usuario.
        $dbname = "projecte_final"; // Nombre de la base de datos.
        // Creamos una "dirección" para conectarnos a la base de datos.
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
    
        try {
            // Intentamos conectarnos a la base de datos con la información anterior.
            $this->conn = new PDO($dsn, $username, $password);
            // Configuramos para que muestre los errores si algo falla.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Si hay un error al conectar, mostramos un mensaje y detenemos las pruebas.
            throw new RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    // Prueba para verificar que el inicio de sesión funciona con datos correctos.
    public function testValidLogin(): void
    {
        // Guardamos el nombre de usuario correcto.
        $nom_usuari = 'admin';
        // Guardamos la contraseña correcta (lo que el usuario escribiría).
        $contrasenya = 'admin123';

        // Preparamos una consulta para buscar al usuario en la base de datos.
        $stmt = $this->conn->prepare("SELECT * FROM usuaris WHERE nom_usuari = :nom_usuari");
        // Reemplazamos ":nom_usuari" con el nombre de usuario guardado.
        $stmt->bindParam(':nom_usuari', $nom_usuari);
        // Ejecutamos la consulta.
        $stmt->execute();

        // Guardamos el resultado (los datos del usuario) en una variable.
        $usuari = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos que la información del usuario no esté vacía (el usuario existe).
        $this->assertNotEmpty($usuari);
        // Verificamos que la contraseña guardada coincida con la ingresada.
        $this->assertTrue(password_verify($contrasenya, $usuari['contrasenya']));
    }

    // Prueba para verificar que no se pueda entrar con una contraseña incorrecta.
    public function testInvalidPassword(): void
    {
        // Guardamos el nombre de usuario correcto.
        $nom_usuari = 'admin';
        // Guardamos una contraseña incorrecta.
        $contrasenya = 'wrongpassword';

        // Preparamos una consulta para buscar al usuario en la base de datos.
        $stmt = $this->conn->prepare("SELECT * FROM usuaris WHERE nom_usuari = :nom_usuari");
        // Reemplazamos ":nom_usuari" con el nombre de usuario guardado.
        $stmt->bindParam(':nom_usuari', $nom_usuari);
        // Ejecutamos la consulta.
        $stmt->execute();

        // Guardamos el resultado (los datos del usuario) en una variable.
        $usuari = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos que la información del usuario no esté vacía (el usuario existe).
        $this->assertNotEmpty($usuari);
        // Verificamos que la contraseña guardada NO coincida con la ingresada.
        $this->assertFalse(password_verify($contrasenya, $usuari['contrasenya']));
    }

    // ./vendor/bin/phpunit --bootstrap vendor/autoload.php test para ejecutar el test
}

?>