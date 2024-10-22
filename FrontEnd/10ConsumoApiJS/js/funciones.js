async function postPeliculas(){
    const myHeaders = new Headers();
    myHeaders.append("Authorization", "123");
    myHeaders.append("Content-Type", "application/json");
    const raw = JSON.stringify({
        "nombre": "hola",
        "publicado": "2012-05-04",
        "director": "juan perez",
        "portada": "shdj.jpg"
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

async function getPeliculas(){
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


getPeliculas();