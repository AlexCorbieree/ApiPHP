function seguridad(){
	const myHeaders = new Headers()
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: "",
        redirect: "follow"
    };
    fetch("http://localhost/webmoviles/FrontEnd/11Peliculas/app/php/seguridad.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        console.log(result)
        const datos     = JSON.parse(result)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
			localStorage.setItem('key', datos.data);
        }
    })
    .catch((error) => console.error(error));
}
seguridad();
async function obtenerPeliculas(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "GET",
        headers: myHeaders,
        redirect: "follow"
    };
    
    await fetch("http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        
        const datos     = JSON.parse(result)
        
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            const movieContainer = document.getElementById("movieCards");
            movieContainer.innerHTML = ''; 

            const respuesta = JSON.parse(datos.data);

            respuesta.forEach((pelicula) => {
                const colDiv = document.createElement("div");
                colDiv.classList.add("col");

                const cardDiv = document.createElement("div");
                cardDiv.classList.add("card", "shadow-sm");

                const cardImage = document.createElement("img");
                cardImage.src = `http://localhost/webmoviles/BackEnd/09ApiRest/img/peliculas/${pelicula.portada}`;
                cardImage.alt = pelicula.nombre; 
                cardImage.classList.add("card-img-top");

                cardImage.onerror = () => {
                    cardImage.src = "http://localhost/webmoviles/BackEnd/09ApiRest/img/peliculas/generic.png";
                };

                const cardBody = document.createElement("div");
                cardBody.classList.add("card-body");

                const cardNombre = document.createElement("p");
                cardNombre.classList.add("card-text");
                cardNombre.textContent = `Titulo: ${pelicula.nombre}`;
                cardBody.appendChild(cardNombre);


                const cardDirector = document.createElement("p");
                cardDirector.classList.add("card-text");
                cardDirector.textContent = `Director: ${pelicula.director}`;
                cardBody.appendChild(cardDirector);


                const cardPublicado = document.createElement("p");
                cardPublicado.classList.add("card-text");
                cardPublicado.textContent = `Publicado: ${pelicula.publicado}`;
                cardBody.appendChild(cardPublicado);


                const buttonGroup = document.createElement("div");
                buttonGroup.classList.add("btn-group");

                const viewButton = document.createElement("button");
                viewButton.classList.add("btn", "btn-sm", "btn-outline-secondary");
                viewButton.textContent = "View";

                const editButton = document.createElement("button");
                editButton.classList.add("btn", "btn-sm", "btn-outline-secondary");
                editButton.textContent = "Edit";

                const timeSmall = document.createElement("small");
                timeSmall.classList.add("text-body-secondary");
                timeSmall.textContent = "9 mins"; 

                buttonGroup.appendChild(viewButton);
                buttonGroup.appendChild(editButton);

                const dFlex = document.createElement("div");
                dFlex.classList.add("d-flex", "justify-content-between", "align-items-center");
                dFlex.appendChild(buttonGroup);
                dFlex.appendChild(timeSmall);

                cardBody.appendChild(dFlex);

                cardDiv.appendChild(cardImage);
                cardDiv.appendChild(cardBody);
                colDiv.appendChild(cardDiv);
                
                movieContainer.appendChild(colDiv);
            });

        }
    })
    .catch((error) => console.error(error));
}
obtenerPeliculas();
