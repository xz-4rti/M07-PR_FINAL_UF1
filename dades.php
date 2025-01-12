<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario - Front end</title>
    <link rel="stylesheet" href="./style/dades.css">
</head>

<body>
    <div class="usuario-container">
        <h1>Bienvenido, Usuario</h1>

        <!-- Lista de todos los contenidos disponibles -->
        <h2>Contenido Disponible</h2>
        <ul>
            <?php foreach ($contingut as $item): ?>
                <li><?= htmlspecialchars($item['titol']) ?>: <?= htmlspecialchars($item['descripcio']) ?></li>
            <?php endforeach; ?>
        </ul>

        <!-- Enlace para cerrar la sesión -->
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</body>

</html>