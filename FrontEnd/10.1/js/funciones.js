async function insertarPeliculas(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const raw = JSON.stringify({
        "nombre": "Java Script",
        "director": "2024",
        "publicado": "2024",
        "portada": "javascript.jpg"
    });
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: raw,
        redirect: "follow"
    };
    await fetch("http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        const datos = JSON.parse(result)
        console.log(datos)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            console.log(JSON.parse(datos.data))
        }
    })
    .catch((error) => console.error(error));
}


async function obtenerPeliculas() {
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
            console.log("Respuesta completa del servidor:", result);

            const datos = JSON.parse(result);
            console.log("Datos parseados:", datos);

            if (datos.status !== 200) {
                throw new Error('Error en la respuesta API');
            } else {
                const peliculas = JSON.parse(datos.data);

                let cardsHTML = '';
                let tablaHTML = '';
                peliculas.forEach((pelicula) => {
                    cardsHTML += `
                        <div class="card">
                            <img src="img/${pelicula.portada}" 
                                alt="Imagen de la película" 
                                onerror="this.onerror=null; this.src='img/generic.png';" 
                                style="width: 220px; height: auto; float:left; margin-right: 20px">
                            <h3>${pelicula.nombre}</h3>
                            <p> <strong> Director: </strong> <br> ${pelicula.director}</p> 
                            <p> <strong> Año: </strong> <br> ${pelicula.publicado}</p> 
                        </div>`;

                    tablaHTML += `
                        <tr>
                            <td>${pelicula.id}</td>
                            <td>${pelicula.nombre}</td>
                            <td>${pelicula.publicado}</td>
                            <td>${pelicula.director}</td>
                            <td>
                            <img src="img/${pelicula.portada}" 
                                alt="Imagen de la película" 
                                onerror="this.onerror=null; this.src='img/generic.png';" 
                                style="width: 100px; height: auto; align: center">
                            </td>
                        </tr>`;
                });

                document.getElementById('cardsPeliculas').innerHTML = cardsHTML;
                document.getElementById('tablaPeliculas').innerHTML = tablaHTML;

                new DataTable('#myTable');
            }
        })
        .catch((error) => console.error(error));
}


obtenerPeliculas();
