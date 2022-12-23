if(window.location == "http://wesharp.com/checkout"){
    let resultList =  document.getElementById('mappp').dataset.value;

    if(resultList == undefined){
        resultList = [19.42847,-99.12766];
    }else{
        resultList = JSON.parse( document.getElementById('mappp').dataset.value);
    }

    const title = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
    let myMap=0;

    function mapa(resultList){

        if(myMap!=0){
            myMap.remove();
        }

    let finalMap= document.getElementById("mappp");
    finalMap.setAttribute("data-value", resultList);

    myMap= L.map('myMap').setView(resultList, 25);

    L.tileLayer(title,{
        maxZoom: 18,
    }).addTo(myMap);

    let iconMarker = L.icon({
        iconUrl:'img/mark.png',
        iconSize:[40,40],
        iconAnchor: [20,20]
    });

    let marker=  L.marker(resultList, {
        icon: iconMarker,
        draggable: true
    }).addTo(myMap);
    marker.on("moveend", (e)=> { document.getElementById("mappp").setAttribute("data-value", [e.target._latlng.lat, e.target._latlng.lng ]);
        
    });
    myMap.doubleClickZoom.disable();
    }

    mapa(resultList);

    document.getElementById('addresOrder').addEventListener('change', () => {
        const pais= document.getElementById('countryOrder').value.split("_")[0];
        const city= document.getElementById('cityOrder').value;
        const adres= document.getElementById('addresOrder').value;
        const query = pais + ", " + city + ", " + adres;

        fetch('https://nominatim.openstreetmap.org/search?format=json&polygon=1&addressdetails=1&q=' + query)
            .then(result => result.json())
            .then(parsedResult => {
                resultList=[ parseFloat(parsedResult[0].lat) , parseFloat( parsedResult[0].lon)];
                mapa(resultList);
                switAlert("success", "Puedes mover el marcador para una mejor localizacion", null, null, 1500);
            }).catch(error => switAlert("error", "Algun campo esta mal, intenta corregirlo para colocar tu direccion en el mapa...", null,null,null )
            );
    });
}

if( window.location == "http://wesharp.com/acount&my-store" ||
    window.location == "http://wesharp.com/acount&my-store#vendor-store" ||
    window.location == "http://wesharp.com/acount&my-store?product=new#vendor-store" ||
    window.location == "http://wesharp.com/acount&my-store?product=edit#vendor-store"||
    window.location == "http://wesharp.com/acount&my-store?product=new" ||
    window.location == "http://wesharp.com/acount&my-store?product=edit" ||
    window.location == "http://wesharp.com/acount&my-store&orders" ||
    window.location == "http://wesharp.com/acount&my-store&disputes" ||
    window.location == "http://wesharp.com/acount&my-store&messages"
    ){

    let resultList =  document.getElementById('mappp').dataset.value;
    if(resultList !== null || resultList !== undefined || resultList !== "" || resultList !== "undefined"){
        resultList = JSON.parse(resultList);
        const title = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
        let myMap=0;

        function mapa(resultList){

            if(myMap!=0){
                myMap.remove();
            }

            let finalMap= document.getElementById("mappp");
            finalMap.setAttribute("data-value", resultList);

            myMap= L.map('myMap').setView(resultList, 25);

            L.tileLayer(title,{
                maxZoom: 18,
            }).addTo(myMap);

            let iconMarker = L.icon({
                iconUrl:'img/mark.png',
                iconSize:[40,40],
                iconAnchor: [20,20]
            });

            let marker=  L.marker(resultList, {
                icon: iconMarker,
            }).addTo(myMap);
            myMap.doubleClickZoom.disable();
        }

        mapa(resultList);
    }
}