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
        method: "POST",
        headers: myHeaders,
        body: JSON.stringify({
            endpoint: 'getPeliculas',
            metodo: 'GET'
        }),
        redirect: "follow"
    };
    await fetch("http://localhost/webmoviles/FrontEnd/11Peliculas/app/php/intermediario.php", requestOptions)
    .then((response) => response.text())
    .then((result) => {
		console.log("result")
        console.log(result)

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
