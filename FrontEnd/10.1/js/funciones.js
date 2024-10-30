async function insertarPeliculas(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const raw = JSON.stringify({
        "nombre": "Java Script",
        "year": "2024",
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
async function obtenerPeliculas(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'getPeliculas',
            metodo: 'GET'
        }),
        redirect: "follow"
    };
    await fetch("http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        const datos     = JSON.parse(result)
        const respuesta = JSON.parse(datos.data)
        if(datos.status!=200){
            throw new Error ('Error en la respuesta API')
        }else{
            document.getElementById('cardsPeliculas').innerHTML = respuesta.card
            document.getElementById('tablaPeliculas').innerHTML = respuesta.tabla
            let table = new DataTable('#myTable', {});
        }
    })
    .catch((error) => console.error(error));
}
obtenerPeliculas();
