<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Front end</title>
    <link rel="stylesheet" href="./style/form.css">
</head>

<body>

<div class="admin-container">
        <h1>Administración</h1>

        <!-- Formulario para añadir un nuevo contenido -->
        <form method="POST">
            <input type="text" name="titol" placeholder="Título" required>
            <textarea name="descripcio" placeholder="Descripción" required></textarea>
            <button type="submit">Añadir</button>
        </form>

        <!-- Muestra un mensaje si el contenido fue añadido con éxito -->
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

        <!-- Lista de contenidos existentes -->
        <h2>Lista de Contenidos</h2>
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