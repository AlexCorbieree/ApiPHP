document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const usuario = document.getElementById('correo').value;
    const clave = document.getElementById('password').value;

    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: "obtenerPerfiles",
            metodo: "GET",
            correo: usuario,
            password: clave
        }),
        redirect: "follow"
    };

    fetch('http://localhost/webmoviles/Proyecto/api/servicios/login/', requestOptions)
        .then(response => response.text())
        .then(data => {
            const datos = JSON.parse(data);
            if (datos.status === 200) {
                const nestedData = JSON.parse(datos.data);
                localStorage.setItem('usuario', usuario);
                localStorage.setItem('esAdministrador', 'true');
                localStorage.setItem('nombre', nestedData.nombre);

                alert('Inicio de sesión exitoso');
                window.location.href = 'html/index.html';
            } else {
                alert('Credenciales incorrectas');
            }
        })
        .catch(error => {
            alert('Error al procesar el inicio de sesión');
            console.error('Error en el login:', error);
        });
});

document.getElementById('btnInvitado').addEventListener('click', function() {
    localStorage.clear();
    localStorage.setItem('esAdministrador', 'false');
    localStorage.setItem('nombre', "");
    localStorage.setItem('usuario', "");
    window.location.href = 'html/index.html';
});
