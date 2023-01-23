/* funcion para formatear las alertas */
function formatearAlertas() {
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
}

function notiAlert(type, text) {
  notie.alert({
    type: type,
    text: text,
    time: 10,
  });
}

function switAlert(type, text, url, icon, time) {
  switch (type) {
    // cuando ocurre un error
    case "error":
      if (url == null && icon == null) {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: text,
          showConfirmButton: false,
          timer: time,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: text,
        }).then((result) => {
          if (result.value) {
            window.open(url, "_top");
          }
        });
      }
      break;

    // cuando ocurre un successfull
    case "success":
      if (url == null && icon == null) {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: text,
          showConfirmButton: false,
          timer: time,
        });
      } else {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: text,
          showConfirmButton: false,
          timer: time,
        }).then((result) => {
          if (result.value) {
            window.open(url, "_top");
          }
        });
        window.location = url;
      }
      break;

    case "loading":
      Swal.fire({
        allowOutsideClick: false,
        title: text,
        width: 600,
        padding: "3em",
        color: "#fff",
        background: "#fff url(img/users/default/fondo.gif)",
        backdrop: `
            rgba(0,0,123,0.4)
            url("img/users/default/we4.gif")
            center top
            no-repeat
        `,
      });
      Swal.showLoading();
      break;

    case "close":
        Swal.close();
    break;

    // cnfiracion de eliminar
    case "confirm":
      
      return new Promise(resolve=>{
        Swal.fire({
          title: 'Estas seguro?',
          text: text,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then(function(result){
          resolve(result.value);
        });
      });

    break;

    // cnfiracion de pago
    case "html":

        Swal.fire({
          allowOutsideClick: false,
          title: 'Click para seguir con el pago',
          html: text,
          icon: 'info',
          showCancelButton: true,
          showConfirmButton:false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, pagar!'
        })
    break;
  }
}

/* funcion para cear una cooky para la vitrina */
function setCookie(name, value, exp) {
  let now = new Date();
  now.setTime(now.getTime() + exp * 24 * 60 * 60 * 1000);

  let expDate = "expires=" + now.toUTCString();
  document.cookie = name + "=" + value + "; " + expDate;
}

//funcion para recordar el email
function rememberme(e){
  
  if(e.target.checked){
    localStorage.setItem("emailRem", $('[name="logEmail"]').val());
    localStorage.setItem("checkRem", true);
  }else{
    localStorage.removeItem("emailRem");
    localStorage.removeItem("checkRem");
  }
}

//Agredamos articulos al carrito de compras
function addBagCard(urlProduct, category, image, name, price, path, urlApi) {
  // Traer informacion del producto 
  let select = "stock_product,specifications_product,shipping_product,offer_product";

  let settings = {
    url:
      urlApi + "products?linkTo=url_product&equalTo=" + urlProduct + "&select=" + select,
    method: "GET",
    timeaot: 0,
  };

  $.ajax(settings).done(function (response) {
    
    if (response.status == 200) {
      let quantity = 1;

      // preguntamos is la cookie ya existe
      let myCookie = document.cookie;
      let listCookie = myCookie.split(";");
      let count = 0;

      for (let i in listCookie) {
        var list = listCookie[i].search("listSC");
        // si list es mayor a -1 es por qu se ncontro la cooki
        if (list > -1) {
          count--;
          var arrayList = JSON.parse(listCookie[i].split("=")[1]);
        } else {
          count++;
        }
      }
      // trabajamos sobre la cookie que ya existe
      if (count != listCookie.length) {
        if (arrayList != undefined) {
          // Preguntar si el producto existe
          var count2 = 0;
          var index = null;
          for (let i in arrayList) {
            if (arrayList[i].product == urlProduct) {
              count2--;
              index = i;
            } else {
              count2++;
            }
          }
          
          if (count2 == arrayList.length) {
            arrayList.push({
              "product": urlProduct,
              // "details": detalleProduct,
               "quantity": parseInt(quantity)
            });
          } else {
            arrayList[index].quantity += parseInt( quantity);
          }
         
          // creamos una cookie
          setCookie("listSC", JSON.stringify(arrayList), 1);
          window.location= path +urlProduct;
        }
      } 
      else {
        // creamos una cookie
        var arrayList = [];
        arrayList.push({
          "product": urlProduct,
          // "details": detalleProduct,
          "quantity": parseInt(quantity)
        });

        setCookie("listSC", JSON.stringify(arrayList), 1);
        window.location= path +urlProduct;
      }
    }
  });
}