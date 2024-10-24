<?php
$apiUrl = "http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/";
$authorization = "123";

$options = [
    "http" => [
        "header" => "Authorization: $authorization\r\n" .
                    "Content-Type: application/json\r\n",
        "method" => "GET",
    ]
];

$context = stream_context_create($options);

$response = file_get_contents($apiUrl, false, $context);

if ($response === FALSE) {
    die('Error al conectar con la API.');
}
$data = json_decode($response, true);

if (isset($data['status']) && $data['status'] == 200) {
    $peliculas = json_decode($data['data'], true);
} else {
    die('Error al obtener los datos de las películas.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/funciones.js"></script> 
</head>
<body>
    <div class="container">
        <h1>Películas</h1>
        <div id="peliculas-grid" class="grid">
            <?php if (!empty($peliculas)) : ?>
                <?php foreach ($peliculas as $pelicula) : ?>
                    <div class="card">
                        <img src="<?php echo 'http://localhost/webmoviles/BackEnd/09ApiRest/img/peliculas/' . htmlspecialchars($pelicula['portada']); ?>" 
                            alt="<?php echo htmlspecialchars($pelicula['nombre']); ?>"
                            onerror="this.onerror=null;this.src='http://localhost/webmoviles/BackEnd/09ApiRest/img/peliculas/generic.png';">
                        <h2><?php echo htmlspecialchars($pelicula['nombre']); ?></h2>
                        <p>Director: <?php echo htmlspecialchars($pelicula['director']); ?></p>
                        <p>Publicado: <?php echo htmlspecialchars($pelicula['publicado']); ?></p>

                        <button onclick="mostrarFormularioModificar(<?php echo htmlspecialchars(json_encode($pelicula)); ?>)">Modificar</button>
                        <button onclick="borrarPelicula(<?php echo $pelicula['id']; ?>)">Borrar</button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay películas disponibles.</p>
            <?php endif; ?>
        </div>

        <div id="formulario-agregar">
            <h2>Agregar nueva película</h2>
            <form id="form-agregar" onsubmit="event.preventDefault(); agregarPelicula();">
                <input type="text" id="nombre" placeholder="Nombre de la película" required>
                <input type="text" id="director" placeholder="Director" required>
                <input type="date" id="publicado" required>
                <input type="text" id="portada" placeholder="Portada (nombre de archivo)" required>
                <button type="submit">Agregar película</button>
            </form>
        </div>

        <div id="formulario-modificar" style="display: none;">
            <h2>Modificar película</h2>
            <form id="form-modificar" onsubmit="event.preventDefault(); modificarPelicula();">
                <input type="hidden" id="mod-id">
                <input type="text" id="mod-nombre" placeholder="Nombre de la película" required>
                <input type="text" id="mod-director" placeholder="Director" required>
                <input type="date" id="mod-publicado" required>
                <input type="text" id="mod-portada" placeholder="Portada (nombre de archivo)" required>
                <button type="submit">Modificar película</button>
                <button type="button" onclick="cancelarModificacion()">Cancelar</button>
            </form>
        </div>



    </div>
</body>
</html>
