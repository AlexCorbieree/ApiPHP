<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Lotería</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Juego de Lotería</h1>

    <div class="controlsBoard">
        <label for="boardSize">Tamaño del tablero (n x n):</label>
        <input type="number" id="boardSize" min="1" placeholder="Ej. 4 para 4x4">
        <button id="generateBoard">Generar Tablero</button>
    </div>

    <div class="controlsPlay">
        <label for="cardCount">Cantidad de cartas: (Dejar vacío para retornar todas las cartas)</label>
        <input type="number" id="cardCount" min="1" placeholder="Ej. 16">
        <button id="getCards">Cantar Loteria</button>
    </div>

    <div class="main-container">
        <div id="boardContainer" class="left-container"> </div>
        <div id="cardDisplayContainer" class="right-container"></div>
    </div>

    <script src="script/script.js"></script>
</body>
</html>
