function seguridad() {
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: "",
        redirect: "follow"
    };

    fetch("http://localhost/webmoviles/Proyecto/api/base/seguridad.php", requestOptions)
        .then(response => response.text())
        .then(result => {
            const datos = JSON.parse(result);
            if (datos.status === 200) {
                localStorage.setItem("key", datos.data);
            } else {
                throw new Error("Error en la respuesta API");
            }
        })
        .catch(error => console.error("Error en seguridad:", error));
}
seguridad();

document.addEventListener("DOMContentLoaded", function () {
    manejarEstadoUsuario();
    obtenerPerfiles();
});

function manejarEstadoUsuario() {
    const nombre = localStorage.getItem("nombre");
    const esAdmin = localStorage.getItem("esAdministrador") === "true";
    const userContainer = document.getElementById("user-container");
    const loginBtn = document.getElementById("loginBtn");
    const logoutBtn = document.getElementById("logoutBtn");
    const crearPerfilBtn = document.getElementById("crearPerfil");

    if (nombre) {
        document.getElementById("user-name").textContent = `Hola, ${nombre}`;
        userContainer.style.display = "flex";
        loginBtn.style.display = "none";
        logoutBtn.style.display = "block";

        if (esAdmin) {
            crearPerfilBtn.style.display = "inline-block";
            crearPerfilBtn.addEventListener("click", function () {
                window.location.href = "./crearPerfil.html";
            });
        } else {
            crearPerfilBtn.style.display = "none";
        }
    } else {
        userContainer.style.display = "none";
        loginBtn.style.display = "block";
        logoutBtn.style.display = "none";
    }
}

function logout() {
    localStorage.clear();
    window.location.href = "../index.html";
}

document.getElementById("logoutBtn").addEventListener("click", logout);

async function obtenerPerfiles() {
    const myHeaders = new Headers();
    const key = localStorage.getItem("key");
    myHeaders.append("Authorization", key || "123");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: "obtenerPerfiles",
            metodo: "GET",
            admin: localStorage.getItem("esAdministrador")
        }),
        redirect: "follow"
    };

    await fetch("http://localhost/webmoviles/Proyecto/app/php/intermediario.php", requestOptions)
        .then(response => response.text())
        .then(result => {
            const datos = JSON.parse(result);
            const cardsContainer = document.getElementById("cards");
            cardsContainer.innerHTML = datos.data?.html || "<p>No hay perfiles disponibles.</p>";

            const eliminarButtons = document.querySelectorAll(".eliminar");
            eliminarButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const perfilId = button.getAttribute("data-id");
                    eliminarPerfil(perfilId);
                });
            });
        })
        .catch(error => {
            console.error("Error al cargar los perfiles:", error);
        });
}

async function eliminarPerfil(id) {
    const myHeaders = new Headers();
    const key = localStorage.getItem("key");
    myHeaders.append("Authorization", key || "123");
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: "DELETE",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: "eliminarPerfil",
            metodo: "DELETE",
            id: id
        }),
        redirect: "follow"
    };

    await fetch("http://localhost/webmoviles/Proyecto/app/php/intermediario.php", requestOptions)
        .then(response => response.text())
        .then(result => {
            const datos = JSON.parse(result);
            if (datos.status === 200) {
                alert("Perfil eliminado correctamente.");
                obtenerPerfiles();
            } else {
                alert("Error al eliminar el perfil.");
            }
        })
        .catch(error => {
            console.error("Error al eliminar el perfil:", error);
            alert("Hubo un error al eliminar el perfil.");
        });
}

document.getElementById("formCrearPerfil")?.addEventListener("submit", async function (e) {
    e.preventDefault();

    // Crear headers
    const myHeaders = new Headers();
    const key = localStorage.getItem("key");
    myHeaders.append("Authorization", key || "123");
    myHeaders.append("Content-Type", "application/json");

    // Obtener datos del formulario
    const nombre = document.getElementById("nombre").value;
    const puesto = document.getElementById("puesto").value;
    const edad = document.getElementById("edad").value;
    const educacion = document.getElementById("educacion").value;
    const locacion = document.getElementById("locacion").value;
    const foto = document.getElementById("foto").value;
    const biografia = document.getElementById("biografia").value;
    const metas = document.getElementById("metas").value;
    const motivaciones = document.getElementById("motivaciones").value;
    const preocupaciones = document.getElementById("preocupaciones").value;

    // Construir objeto de datos
    const datos = {
        endpoint: "crearPerfil",
        metodo: "POST",
        admin: localStorage.getItem("esAdministrador"),
        datos: {
            nombre,
            puesto,
            edad,
            educacion,
            locacion,
            foto,
            biografia,
            metas,
            motivaciones,
            preocupaciones,
        },
    };

    // Crear opciones de la solicitud
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify(datos), // Incluir datos en el cuerpo de la solicitud
        redirect: "follow",
    };

    console.log("Enviando datos:", datos);

    try {
        // Realizar la solicitud al servidor
        const response = await fetch("http://localhost/webmoviles/Proyecto/app/php/intermediario.php", requestOptions);

        const resultado = await response.json(); // Parsear respuesta JSON
        console.log("Respuesta del servidor:", resultado);
        console.log("response del servidor:", response);


        // Verificar estado de la respuesta
        if (resultado.status === 200) {
            alert("Perfil creado correctamente");
            window.location.href = "index.html"; // Redirigir a index
        } else {
            alert("Error al crear el perfil: " + resultado.message);
        }
    } catch (error) {
        console.error("Error al enviar los datos:", error);
        alert("Ocurrió un error al comunicarse con el servidor.");
    }
});

