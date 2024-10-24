async function getPeliculas() {
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
            const datos = JSON.parse(result);
            console.log(datos);
            if (datos.status != 200) {
                throw new Error('Error en la respuesta API');
            } else {
                console.log(JSON.parse(datos.data));
            }
        })
        .catch((error) => console.error(error));
}


async function agregarPelicula() {
    const apiUrl = `http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/`;
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");

    const nombre = document.getElementById("nombre").value;
    const director = document.getElementById("director").value;
    const publicado = document.getElementById("publicado").value;
    const portada = document.getElementById("portada").value;

    if (nombre && director && publicado && portada) {
        const raw = JSON.stringify({
            nombre: nombre,
            director: director,
            publicado: publicado,
            portada: portada
        });

        const requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: raw,
            redirect: "follow"
        };

        try {
            const response = await fetch(apiUrl, requestOptions);
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const result = await response.json();
            alert("Película agregada correctamente");
            location.reload();
        } catch (error) {
            console.error("Error al agregar película:", error);
        }
    } else {
        alert("Por favor, completa todos los campos.");
    }
}

async function borrarPelicula(id) {
    const apiUrl = `http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/`;
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: "DELETE",
        headers: myHeaders,
        body: JSON.stringify({ id: id }),
        redirect: "follow"
    };

    try {
        const response = await fetch(apiUrl, requestOptions);
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        const result = await response.json();
        alert("Película eliminada correctamente");
        location.reload();
    } catch (error) {
        console.error("Error al eliminar película:", error);
    }
}





function mostrarFormularioModificar(pelicula) {
    document.getElementById("formulario-agregar").style.display = "none";
    document.getElementById("formulario-modificar").style.display = "block";

    document.getElementById("mod-id").value = pelicula.id;
    document.getElementById("mod-nombre").value = pelicula.nombre;
    document.getElementById("mod-director").value = pelicula.director;
    document.getElementById("mod-publicado").value = pelicula.publicado;
    document.getElementById("mod-portada").value = pelicula.portada;
}

function cancelarModificacion() {
    document.getElementById("formulario-modificar").style.display = "none";
    document.getElementById("formulario-agregar").style.display = "block";
}

function modificarPelicula() {
    const id = document.getElementById("mod-id").value;
    const nombre = document.getElementById("mod-nombre").value;
    const director = document.getElementById("mod-director").value;
    const publicado = document.getElementById("mod-publicado").value;
    const portada = document.getElementById("mod-portada").value;

    console.log("Datos capturados para modificar:", { id, nombre, director, publicado, portada });

    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
        "id": id,
        "nombre": nombre,
        "publicado": publicado,
        "director": director,
        "portada": portada
    });

    const requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: raw,
        redirect: "follow"
    };

    fetch("http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas", requestOptions)
        .then(response => response.json())
        .then(result => {
            if (result.error) {
                console.error("Error:", result.error);
                alert("Error al modificar la película: " + result.error);
            } else {
                console.log(result);
                alert("Película modificada correctamente");
                location.reload();

            }
        })
        .catch(error => {
            console.error("Error al modificar la película:", error);
        });
}

