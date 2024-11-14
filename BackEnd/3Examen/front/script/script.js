document.addEventListener("DOMContentLoaded", () => {
    const boardContainer = document.getElementById("boardContainer");

    boardContainer.addEventListener("click", (e) => {
        if (e.target.closest(".card")) {
            e.target.closest(".card").classList.toggle("clicked");
        }
    });
});

document.getElementById("generateBoard").addEventListener("click", generateBoard);
document.getElementById("getCards").addEventListener("click", getCards);  

async function generateBoard() {
    const boardContainer = document.getElementById("boardContainer");
    const boardSizeInput = document.getElementById("boardSize").value;  

    const boardSize = parseInt(boardSizeInput, 10);
    if (isNaN(boardSize) || boardSize <= 0) {
        console.error("Debe proporcionar un tamaño válido para el tablero.");
        return;
    }

    let totalSize = boardSize * boardSize;

    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: "GET",
        headers: myHeaders,
        redirect: "follow"
    };

    try {
        const apiUrl = `http://localhost/webmoviles/BackEnd/3Examen/php/servicios/loteria/?n=${totalSize}`;
        const response = await fetch(apiUrl, requestOptions);
        
        if (!response.ok) {
            throw new Error('Error en la respuesta de la API');
        }

        const result = await response.json();
        
        if (result.data && typeof result.data === 'string') {
            try {
                const cardData = JSON.parse(result.data);

                if (Array.isArray(cardData)) {
                    boardContainer.innerHTML = '';
                    boardContainer.style.gridTemplateColumns = `repeat(${boardSize}, 1fr)`;

                    cardData.forEach((card) => {
                        const cardContainer = document.createElement("div");
                        cardContainer.classList.add("card");
                        
                        const cardImage = document.createElement("img");
                        cardImage.src = `http://localhost/webmoviles/BackEnd/3Examen/php/img/loteria/${card.imagen}`;
                        cardImage.alt = card.nombre;
                        cardImage.classList.add("card-image");

                        cardContainer.appendChild(cardImage);
                        boardContainer.appendChild(cardContainer);
                    });
                }
            } catch (parseError) {
                console.error("Error al parsear 'data':", parseError);
            }
        }
    } catch (error) {
        console.error("Error al generar el tablero:", error);
    }
}

async function getCards() {
    const cardCountInput = document.getElementById("cardCount").value;
    const cardCount = cardCountInput ? parseInt(cardCountInput) : null;
    const cardDisplayContainer = document.getElementById("cardDisplayContainer");

    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: "GET",
        headers: myHeaders,
        redirect: "follow"
    };

    try {
        const apiUrl = cardCount 
            ? `http://localhost/webmoviles/BackEnd/3Examen/php/servicios/loteria/?n=${cardCount}` 
            : "http://localhost/webmoviles/BackEnd/3Examen/php/servicios/loteria/";
        
        const response = await fetch(apiUrl, requestOptions);
        const result = await response.text();
        const responseData = JSON.parse(result);

        if (responseData.data && typeof responseData.data === 'string') {
            let cardData = JSON.parse(responseData.data);

            if (Array.isArray(cardData)) {
                localStorage.setItem("cards", JSON.stringify(cardData));

                let currentIndex = 0;

                function displayNextCard() {
                    if (currentIndex < cardData.length) {
                        const card = cardData[currentIndex];
                        const cardContainer = document.createElement("div");
                        cardContainer.classList.add("card");

                        const cardImage = document.createElement("img");
                        cardImage.src = `http://localhost/webmoviles/BackEnd/3Examen/php/img/loteria/${card.imagen}`;
                        cardImage.alt = card.nombre;

                        const cardName = document.createElement("p");
                        cardName.textContent = card.nombre;

                        cardContainer.appendChild(cardImage);
                        cardContainer.appendChild(cardName);

                        const previousCard = cardDisplayContainer.querySelector(".card");
                        if (previousCard) {
                            previousCard.remove();
                        }

                        cardDisplayContainer.appendChild(cardContainer);

                        setTimeout(() => {
                            cardContainer.classList.add("show");

                            const previousCard = cardDisplayContainer.querySelector(".card:not(.show)");
                            if (previousCard) {
                                previousCard.classList.add("hide");
                            }
                        }, 0); 

                        currentIndex++;

                        setTimeout(displayNextCard, 5000); 
                    }
                }

                displayNextCard(); 
            }
        }
    } catch (error) {
        console.error("Error al obtener las cartas:", error);
    }
}

document.getElementById("getCards").addEventListener("click", getCards);
