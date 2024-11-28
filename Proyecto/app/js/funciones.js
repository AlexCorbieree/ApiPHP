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

document.addEventListener("DOMContentLoaded", function() {
    manejarEstadoUsuario();
    obtenerPerfiles();
});

function manejarEstadoUsuario() {
    const nombre = localStorage.getItem("nombre");
    const esAdmin = localStorage.getItem("esAdministrador") === "true"; 
    const userContainer = document.getElementById("user-container");
    const loginBtn = document.getElementById("loginBtn");
    const logoutBtn = document.getElementById("logoutBtn");

    if (nombre) {
        document.getElementById("user-name").textContent = `Hola, ${nombre}`;
        userContainer.style.display = "flex";
        loginBtn.style.display = "none";
        logoutBtn.style.display = "block";
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

            // Añadir event listeners a los botones de eliminar
            const eliminarButtons = document.querySelectorAll(".eliminar");
            eliminarButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const perfilId = button.getAttribute("data-id");
                    eliminarPerfil(perfilId);
                });
            });
        })
        .catch(error => {
            console.error("Error al cargar los perfiles:", error);
        });
}

// Función para eliminar un perfil
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
