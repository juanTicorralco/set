let urlMaster = window.location.href;
if(localStorage.getItem("token_user")){
  let myCookie = document.cookie;
     let listCookie = myCookie.split(";");
     let count = 0;

     for (let i in listCookie) {
       var list = listCookie[i].search("UrlPage");
       // si list es mayor a -1 es por qu se ncontro la cooki
       if (list > -1) {
        document.cookie = "UrlPage" + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
       } 
     }
}
if(urlMaster != "http://wesharp.com/acount&login" && urlMaster != "http://wesharp.com/acount&enrollment" && !localStorage.getItem("token_user")){
  setCookie("UrlPage", urlMaster, 1);
}
/* funcion para resetear url de los filtros */
function sortProduct(event) {
  let url = event.target.value.split("+")[0];
  let sort = event.target.value.split("+")[1];
  let endUrl = url.split("&")[0];
  window.location = endUrl + "&1&" + sort + "#showCase";
}
/* funcion para cear una cooky para la vitrina */
function setCookie(name, value, exp) {
  let now = new Date();
  now.setTime(now.getTime() + exp * 24 * 60 * 60 * 1000);

  let expDate = "expires=" + now.toUTCString();
  document.cookie = name + "=" + value + "; " + expDate;
}

/* fucion para almacenar en cookies la vitrina */
$(document).on("click", ".ps-tab-list li", function () {
  setCookie("tab", $(this).attr("type"), 1);
});

/* funcion para el buscador */
$(document).on("click", ".btnSearch", function (e) {
  e.preventDefault();
  let path = $(this).attr("path");
  let search = $(this).parent().children(".inputSearch").val().toLowerCase();
  let match = /^[a-z0-9ñÑáéíóú ]*$/;

  if (match.test(search)) {
    let searchTest = search.replace(/[ ]/g, "_");
    searchTest = searchTest.replace(/[ñ]/g, "n");
    searchTest = searchTest.replace(/[á]/g, "a");
    searchTest = searchTest.replace(/[é]/g, "e");
    searchTest = searchTest.replace(/[í]/g, "i");
    searchTest = searchTest.replace(/[ó]/g, "o");
    searchTest = searchTest.replace(/[ú]/g, "u");

    window.location = path + searchTest;
  } else {
    $(this).parent().children(".inputSearch").val("");
  }
});

/* funcion para buscador con enter */
let inputSearch = $(".inputSearch");
let btnSearch = $(".btnSearch");

for (let i = 0; i < inputSearch.length; i++) {
  $(inputSearch[i]).keyup(function (e) {
    e.preventDefault();
    if (e.keyCode == 13 && $(inputSearch[i]).val() != "") {
      let path = $(btnSearch[i]).attr("path");
      let search = $(this).val().toLowerCase();
      let match = /^[a-z0-9ñÑáéíóú ]*$/;

      if (match.test(search)) {
        let searchTest = search.replace(/[ ]/g, "_");
        searchTest = searchTest.replace(/[ñ]/g, "n");
        searchTest = searchTest.replace(/[á]/g, "a");
        searchTest = searchTest.replace(/[é]/g, "e");
        searchTest = searchTest.replace(/[í]/g, "i");
        searchTest = searchTest.replace(/[ó]/g, "o");
        searchTest = searchTest.replace(/[ú]/g, "u");

        window.location = path + searchTest;
      } else {
        $(this).val("");
      }
    }
  });
}

/* funcion para cambiar la cantidad del carrito */
function changeQualyty(quantity, move, stock, index) {
  let number = 1;
  if (Number(quantity) > stock - 1) {
    quantity = stock - 1;
  }
  if (move == "up") {
    number = Number(quantity) + 1;
  }
  if (move == "down" && Number(quantity) > 1) {
    number = Number(quantity) - 1;
  }

  $("#quant"+index).val(number);
  $("[quantitySC]").attr("quantitySC", number);
  totalp(index);
}

if(window.location == "http://wesharp.com/acount&enrollment"){
  window.onload = function() {
    var myInput = document.getElementById('passRep');
    myInput.onpaste = function(e) {
      e.preventDefault();
    }
    myInput.oncopy = function(e) {
      e.preventDefault();
    }
  }
}
/* funcion para validar un formiulario */
function validatejs(e, tipo) {
  if (tipo == "text") {
    let pattern = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;
    if (!pattern.test(e.target.value)) {
      $(e.target).parent().addClass("was-validated");
      $(e.target)
        .parent()
        .children(".invalid-feedback")
        .html("No uses numeros ni caracteres especiales");
      return;
    }
  } 
  if (tipo == "text&number") {
    let pattern = /^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;
    if (!pattern.test(e.target.value)) {
      $(e.target).parent().addClass("was-validated");
      $(e.target).parent().children(".invalid-feedback").html("No uses caracteres especiales");
      return;
    }
  } 
  if (tipo == "email") {
    let pattern = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
    if (!pattern.test(e.target.value)) {
      $(e.target).parent().addClass("was-validated");
      $(e.target)
        .parent()
        .children(".invalid-feedback")
        .html("Solo se acepta un formato email");
      return;
    }
  } 
  if (tipo == "pass") {
    let pattern = /^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/;
    if (!pattern.test(e.target.value)) {
      $(e.target).parent().addClass("was-validated");
      $(e.target)
        .parent()
        .children(".invalid-feedback")
        .html(
          "No se admiten espacios ni tampoco algunos caracteres especiales"
        );
      e.target.value = "";
      return;
    }
    if(e.target.value.length < 9){
      $(e.target).parent().addClass("was-validated");
      $(e.target)
        .parent()
        .children(".invalid-feedback")
        .html(
          "La contraseña debe tener almenos 8 caracteres"
        );
        e.target.value = "";
      return;
    }
  } 
  if (tipo == "passEnt") {
    let pattern = /^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/;
    if (!pattern.test(e.target.value)) {
      $(e.target).parent().addClass("was-validated");
      $(e.target)
        .parent()
        .children(".invalid-feedback")
        .html(
          "No se admiten espacios ni tampoco algunos caracteres especiales"
        );
      e.target.value = "";
      return;
    }
  }
  if(tipo=="phone"){
    let  pattern = /^[-\\(\\)\\0-9 ]{1,}$/; 
    if (!pattern.test(e.target.value)) {
      $(e.target).parent().addClass("was-validated");
        $(e.target)
          .parent()
          .children(".invalid-feedback")
          .html("Solo se aceptan numeros");
      return;
    }
  }
  if(tipo=="parrafo"){
    let  pattern = /^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/; 
    if (!pattern.test(e.target.value)) {
      $(e.target).parent().addClass("was-validated");
        $(e.target)
          .parent()
          .children(".invalid-feedback")
          .html("Algun caracter que estas usando no es valido");
      return;
    }
  }
  if(tipo=="numbers"){
    let  pattern = /^[.\\,\\0-9]{1,}$/; 
    if (!pattern.test(e.target.value)) {
      $(e.target).parent().addClass("was-validated");
        $(e.target)
          .parent()
          .children(".invalid-feedback")
          .html("Solo se aceptan numeros");
      return;
    }
  }
  if(tipo == "repeatPass"){

    let validar = e.target;
    let valor = $("#createPassword").val();
    if(validar.value !== valor){
      $(validar).parent().addClass("was-validated");
      $(validar).parent().children(".invalid-feedback").html("Las contraseñas no coinciden");
      validar.value = "";
      return;
    }
  }
}

function validateImageJs(e, input){
    let image = e.target.files[0];
    if (image["type"] !== "image/jpeg" && image["type"] !== "image/png") {
      switAlert("error", "La imagen tiene que ser PNG  JPEG", null, null);
      return;
    } else if (image["size"] > 2000000) {
      switAlert("error", "La imagen tiene que ser menor a 2MB", null, null);
      return;
    } else {
      var data = new FileReader();
      data.readAsDataURL(image);

      $(data).on("load", function (event) {
        let path = event.target.result;
        $("."+input).attr("src", path);
      });
    }
}

/* funcion para validar un formiulario */
function dataRepeat(e, type){
  let table = "";
  let linkTo = "";
  let select = ""

  if(type == "email"){
     table = "users";
     linkTo = "email_user";
     select = "email_user"
  }

  if(type == "store"){
     table = "stores";
     linkTo = "name_store";
     select = "name_store"
  }

  if(type == "product"){
    table = "products";
    linkTo = "name_product";
    select = "name_product"
 }

  let settings = {
    url:$("#urlApi").val() + table+"?equalTo=" + e.target.value +"&linkTo="+linkTo+"&select="+select,
    metod: "GET",
    timeaot: 0,
  };

  $.ajax(settings).error(function (response) {
    if (response.responseJSON.status == 404) {
      if(type == "email"){
        validatejs(e, "email");
      }

      if(type == "store"){
        validatejs(e, "text&number");
        urlCreate(e,"urlStore");
      }

      if(type == "product"){
        validatejs(e, "text&number");
        urlCreate(e,"urlProduct");
      }
    }
  });

  $.ajax(settings).done(function (response) {
    if (response.status == 200) {
      
      $(e.target).parent().addClass("was-validated");

      if(type == "email"){
        $(e.target).parent().children(".invalid-feedback").html("Este email ya esta registrado");
      }

      if(type == "store" || type == "product"){
        $(e.target).parent().children(".invalid-feedback").html("El nombre "+  e.target.value +" ya esta ocupado");
      }
      
      e.target.value = "";
      return;
    }
  }); 
}

// funcion para agregar producto a la list de deseos
function addWishList(urlProducto, urlApi) {
  // valdar que es token exista

  if (localStorage.getItem("token_user") != null) {
    // validar que el token sea el mismo que en la bd
    let token = localStorage.getItem("token_user");
    let settings = {
      url:
        urlApi + "users?equalTo=" + token + "&linkTo=token_user&select=id_user,wishlist_user",
      method: "GET",
      timeaot: 0,
    };

    //   respuesta incorrecta
    $.ajax(settings).error(function (response) {
      if (response.responseJSON.status == 404) {
        switAlert("error", "Ocurrio un error... por favor vuelve a logearte", null, null, 3000);
        return;
      }
    });

    // respuesta correcta
    $.ajax(settings).done(function (response) {
      if (response.status == 200) {
        let id = response.result[0].id_user;
        let wishlist = JSON.parse(response.result[0].wishlist_user);
        let noRepeat = 0;
        // preguntar si hay articulos en la lista de deseos 
        if (wishlist != null && wishlist.length > 0) {
          wishlist.forEach(list => {
            if (list == urlProducto) {
              noRepeat--;
            } else {
              noRepeat++;
            }
          });


          // preguntamos si ya esta en la lista de deseos
          if (wishlist.length != noRepeat) {
            switAlert("error", "El producto ya se agrego a tu lista de deseos", null, null, 2000);
          } else {

            wishlist.push(urlProducto);
            // Cuando no exista la lista de deseos inicialmente
            let settings = {
              "url": urlApi + "users?id=" + id + "&nameId=id_user&token=" + token + "&select=id_user",
              "method": "PUT",
              "timeaot": 0,
              "headers": {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              "data": {
                "wishlist_user": JSON.stringify(wishlist),
              },
            };

            $.ajax(settings).done(function (response) {
              if (response.status == 200) {

                let totalWishlist = Number($(".totalWishList").html());
                $(".totalWishList").html(totalWishlist + 1);
                $(`.${urlProducto}`).removeClass("invisibleCorazon");
                $(`#visibl-cor`).remove();
                switAlert("success", "El producto se añadio a la lista de deseos", null, null, 1500);
              }
            });
          }
        } else {

          // Cuando no exista la lista de deseos inicialmente
          let settings = {
            "url": urlApi + "users?id=" + id + "&nameId=id_user&token=" + token + "&select=id_user",
            "method": "PUT",
            "timeaot": 0,
            "headers": {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            "data": {
              "wishlist_user": '["' + urlProducto + '"]',
            },
          };

          $.ajax(settings).done(function (response) {
            if (response.status == 200) {

              let totalWishlist = Number($(".totalWishList").html());
              $(".totalWishList").html(totalWishlist + 1);
              $(`.${urlProducto}`).removeClass("invisibleCorazon");
              switAlert("success", "El producto se añadio a la lista de deseos", null, null, 1500);
            }
          });
        }
      }
    });
  } else {
    switAlert("error", "Para agregar a la lista de deseos debes estar logeado", null, null, 3000);
  }
}

// AGREGAR DOS PROductos a la lista de deseos 

function addWishListDos(urlProducto, urlApi, urlProductoDos) {
  addWishList(urlProducto, urlApi);
  setTimeout(() => {
    addWishList(urlProductoDos, urlApi);
  }, 1000);
}

// funcion para eliminar elementos a la lista de deseos
function removeWishlist(urlProduct, urlApi) {
  switAlert("confirm", "Esta seguro de eliminar de la lista de deseos?", null, null, null).then(resp => {

    if (resp == true) {
      // revisar que el token coincida con la bd
      let token = localStorage.getItem("token_user");
      let settings = {
        url:
          urlApi + "users?equalTo=" + token + "&linkTo=token_user&select=id_user,wishlist_user",
        method: "GET",
        timeaot: 0,
      };
      $.ajax(settings).done(function (response) {
        if (response.status == 200) {
          let id = response.result[0].id_user;
          let wishlist = JSON.parse(response.result[0].wishlist_user);
          wishlist.forEach((list, index) => {
            if (list == urlProduct) {
              wishlist.splice(index, 1);
              $(`.${urlProduct}`).remove();
            }
          });

          // Cuando no se quite de la lista 
          let settings = {
            "url": urlApi + "users?id=" + id + "&nameId=id_user&token=" + token,
            "method": "PUT",
            "timeaot": 0,
            "headers": {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            "data": {
              "wishlist_user": JSON.stringify(wishlist),
            },
          };

          $.ajax(settings).done(function (response) {
            if (response.status == 200) {

              let totalWishlist = Number($(".totalWishList").html());
              $(".totalWishList").html(totalWishlist - 1);

              switAlert("success", "El producto se elimino de la lista de deseos", null, null, 1500);

            }
          });

        }
      })
    }
  });
}

// funcion que remueve de bag
function removeBagSC(urlProduct, urlPagina){
  switAlert("confirm", "Esta seguro de eliminar del carrito de compras?", urlPagina, null, null).then(resp => {
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
          arrayList.forEach((list, index)=>{
            if(list.product == urlProduct){
              arrayList.splice(index,1);
            }
          });

          setCookie("listSC", JSON.stringify(arrayList), 1);
          urlPagina = window.location.href;
          switAlert("success", "El producto se elimino de el carrito", urlPagina, null, 1500);
        }
      }
  });
}

//Agredamos articulos al carrito de compras
function addBagCard(urlProduct, category, image, name, price, path, urlApi, tag) {
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

      if (response.result[0].stock_product == 0) {
        switAlert("error", "Por el momento no tenemos en stock este producto", null, null, 3000);
        return;
      }

      // Creamos la estructura detalles, vaidamos existencia de detalles
      if(tag.getAttribute("detailSC") != ""){
        var detalleProduct = tag.getAttribute("detailSC");  
      }else{
        var detalleProduct = "";
      }

      // validamos la existecia de cantidad 
      if(tag.getAttribute("quantitySC") != ""){
        var quantity = tag.getAttribute("quantitySC");  
      }else{
        var quantity = 1;
      }

      //preguntamos si detalles viene bacio
      if(detalleProduct === ""){
        if (response.result[0].specifications_product != "" ) {
          if(response.result[0].specifications_product != null){
          let DetProd = JSON.parse(response.result[0].specifications_product);
          detalleProduct = '[{';
          for (const i in DetProd) {
            let propiety = Object.keys(DetProd[i]).toString();
            detalleProduct += '"' + propiety + '":"' + DetProd[i][propiety][0] + '",';
          }
          detalleProduct = detalleProduct.slice(0, -1);
          detalleProduct += '}]';
        }
      }
      }else{
        let newDetail= JSON.parse(detalleProduct);

        if (response.result[0].specifications_product != null) {
          let DetProd = JSON.parse(response.result[0].specifications_product);
          detalleProduct = '[{';
          for (const i in DetProd) {
            let propiety = Object.keys(DetProd[i]).toString();
            detalleProduct += '"' + propiety + '":"' + DetProd[i][propiety][0] + '",';
          }
          detalleProduct = detalleProduct.slice(0, -1);
          detalleProduct += '}]';
        }

        for(const i in JSON.parse(detalleProduct)[0]){
          if(newDetail[0][i] == undefined){
            Object.assign(newDetail[0], {[i]: JSON.parse(detalleProduct)[0][i]})
          }
        }

        detalleProduct= JSON.stringify(newDetail);
      }

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
              "details": detalleProduct,
              "quantity": parseInt(quantity)
            });
          } else {
            arrayList[index].quantity += parseInt( quantity);
          }

          // creamos una cookie
          setCookie("listSC", JSON.stringify(arrayList), 1);
          switAlert("success", "El producto se agrego al carrito", null, null, 1500);

          // precio
          function priceFun(offer, price) {
            if (offer != null) {
              if (offer[0] == "Discount") {
                let offerPrice = price - (price * offer[1]) / 100;
                offerPrice = offerPrice.toFixed(2)
                return offerPrice;
              } else if (offer[0] == "Fixed") {
                let offerPrice = offer[1];
                return offerPrice;
              }
            } else {
              return price;
            }
          }

          // lista
          function listFun(lisArray) {
            let lista2 = JSON.parse(lisArray[0]["details"]);
            // html`<p class='mb-0'> <strong> Detalles por defecto:</strong></p>`;
            let newlist = [];
            for (let prop in lista2[0]) {
              newlist += prop + " : " + lista2[0][prop] + `<br>`;
            }

            return newlist;
          }

          function priceTotalFun(varer, varer2, varer3) {

            
            if (varer3 == null) {
              let priceSum;

              priceSum = varer + (varer2);
              priceSum = priceSum.toFixed(2)
              return priceSum;
            }else {
              let priceSum;

              priceSum = (varer * varer3);
              priceSum = priceSum.toFixed(2)
              return priceSum;
            }

          }

          function resetFinishEnv(varer, varer2, varer3, varer4){
           if(varer==0){
              let priceSum;

              priceSum = (varer3 * varer4);
              priceSum = priceSum.toFixed(2)
              return priceSum;
            }else{
              let priceSum;

              priceSum = varer2 + (varer4);
              priceSum = priceSum.toFixed(2)
              return priceSum;
            }
          }

          function resetenvio(var1, var2) {
            if (var1 > 2) {
              return 0;
            } else {

              return var2* 1.5;
            }
          }

          if (arrayList[index] == undefined) {
    
            $("#bagTok").after(`
              <div class="ps-product--cart-mobile bg-white p-3">
                <div class="ps-product__thumbnail">
                    <a class="m-0" href="${path + urlProduct}">
                    <img src="img/products/${category}/${image}" alt="${name}">
                    </a>
                </div>
  
                <div class="ps-product__content">
                <a class="ps-product__remove text-danger btn" onclick="removeBagSC('${urlProduct}', '${location.reload()}')">
                <i class="fas fa-trash-alt"></i>
                </a>
                    <a class="m-0" href="${path + urlProduct}">${name}</a>
                    <p class="m-0"><strong></strong> WeSharp</p>
                    <div class="small text-secondary">
                    <p class='mb-0'> <strong> Detalles por defecto:</strong></p>
                    <div class="mb-0">${listFun(arrayList)}</div>                         
                    </div>
                    <p class="m-0"><strong>Envio: </strong> $<span class="envibagcl">${JSON.parse(response.result[0].shipping_product) * 1.5}</span></p>
                    <small> <spam class="${urlProduct}">1</spam> x $
                    ${priceFun(JSON.parse(response.result[0].offer_product), price)}
                    </small>
                </div>
              </div>`
            );

            let var1 = parseFloat(priceFun(JSON.parse(response.result[0].offer_product), price));
            let var2 = parseInt(JSON.parse(response.result[0].shipping_product));
            let var5= arrayList.length - 1 ;

            let envios = JSON.parse(response.result[0].shipping_product);
            let var4 = resetenvio(var5, envios);

            $(".envibagcl").html(var4);

            let tobagtal = Number($('.tobagtal').html());
            $(".tobagtal").html(tobagtal + parseFloat(priceTotalFun(var1, var2, null)));

            let totalbager = Number($('.totalWishBag').html());
            $('.totalWishBag').html(totalbager + 1);
          } else {
           
            let var1 = parseFloat(priceFun(JSON.parse(response.result[0].offer_product), price));
            let var3 = Number($(`.${urlProduct}`).html());
            $(`.${urlProduct}`).html(var3 + 1);
            let envios = JSON.parse(response.result[0].shipping_product);
            let var4 = resetenvio(var3, envios);
            let tobagtal = Number($('.tobagtal').html());
    
            var3 = Number($(`.${urlProduct}`).html());
            $(".envibagcl").html(var4);
            var4 = Number($(".envibagcl").html());

            // parseFloat(priceTotalFun(resetenvio(var3, envios), var2, var3))
            $(".tobagtal").html(resetFinishEnv(var4, tobagtal, var3, var1));           
          }
        }
      } else {
        // creamos una cookie
        var arrayList = [];
        arrayList.push({
          "product": urlProduct,
          "details": detalleProduct,
          "quantity": 1
        });

        setCookie("listSC", JSON.stringify(arrayList), 1);
        switAlert("success", "El producto se agrego a la lista de deseos", null, null, 1500);

        // precio
        function priceFun(offer, price) {
          if (offer != null) {
            if (offer[0] == "Discount") {
              let offerPrice = price - (price * offer[1]) / 100;
              offerPrice = offerPrice.toFixed(2)
              return offerPrice;
            } else if (offer[0] == "Fixed") {
              let offerPrice = offer[1];
              return offerPrice;
            }
          } else {
            return price;
          }
        }

        // lista
        function listFun(lisArray) {
          let lista2 = JSON.parse(lisArray[0]["details"]);
          // html`<p class='mb-0'> <strong> Detalles por defecto:</strong></p>`;
          let newlist = [];
          for (let prop in lista2[0]) {
            newlist += prop + " : " + lista2[0][prop] + `<br>`;
          }

          return newlist;
        }

        function priceTotalFun(varer, varer2) {

          let priceSum;

          return priceSum = varer + (varer2 * 1.5);

        }

        $("#bagTok").after(`
        <div class="ps-product--cart-mobile bg-white p-3">
          <div class="ps-product__thumbnail">
              <a class="m-0" href="${path + urlProduct}">
              <img src="img/products/${category}/${image}" alt="${name}">
              </a>
          </div>

          <div class="ps-product__content">
          <a class="ps-product__remove text-danger btn" onclick="removeBagSC('${urlProduct}', '${location.reload()}')">
          <i class="fas fa-trash-alt"></i>
          </a>
              <a class="m-0" href="${path + urlProduct}">${name}</a>
              <p class="m-0"><strong></strong> WeSharp</p>
              <div class="small text-secondary">
              <p class='mb-0'> <strong> Detalles por defecto:</strong></p>
              <div class="mb-0">${listFun(arrayList)}</div>                         
              </div>
              <p class="m-0"><strong>Envio: </strong> $ <span class="envibagcl">${JSON.parse(response.result[0].shipping_product) * 1.5}</span></p>
              <small> <spam class="${urlProduct}">${1}</spam> x $
               ${priceFun(JSON.parse(response.result[0].offer_product), price)}
              </small>
          </div>
        </div>`
        );

        let var1 = parseFloat(priceFun(JSON.parse(response.result[0].offer_product), price));
        let var2 = parseInt(JSON.parse(response.result[0].shipping_product));

        $("#viewCardBag").html(` 
        <h3>Total: <strong>$ <span class="tobagtal">${priceTotalFun(var1, var2)}</span </strong></h3>
        <figure>
            <a class="ps-btn" href="shopping-cart.html">View Cart</a>
            <a class="ps-btn" href="checkout.html">Checkout</a>
        </figure>`);
        
        let totalbager = Number($('.totalWishBag').html());
        $('.totalWishBag').html(totalbager + 1);
      }
    }
  });
}

function bagCkeck(){
  window.location = "http://wesharp.com/checkout";
}

// seleccionar detalles al producto
$(document).on("click", ".details", function(){
  let details = $(this).attr("datailType");
  let value = $(this).attr("detailValue");
  let detailsLenth= $(".details."+ details);

  for(let i=0; i<detailsLenth.length; i++){
    $(detailsLenth[i]).css({"border":"1px solid #bbb"});
  }
  $(this).css({"border":"5px solid #80F"});

  // preguntar si se agregaron detalles
  if($("[detailSC]").attr("detailSC") != ""){
    
    let detailsSC = JSON.parse($("[detailSC]").attr("detailSC"));
    for(const i in detailsSC){
      detailsSC[i][details]= value;
      $("[detailSC]").attr("detailSC", JSON.stringify(detailsSC));
    }

  }else{
    $("[detailSC]").attr("detailSC", '[{\"'+details+'\":\"'+value+'\"}]')
  }
})

// AGREGAR DOS PROductos al carrito
function addBagCardDos(urlProduct, category, image, name, price, path, urlApi, tag, urlProductoDos) {
  addBagCard(urlProduct, category, image, name, price, path, urlApi, tag);
  setTimeout(() => {
    addBagCard(urlProductoDos, category, image, name, price, path, urlApi, tag);
  }, 1000);
}

// definir el subtotal y total del carrito de compras
let price = $(".price span");
let quantity= $(".quantity input");
let envio= $(".shopingcantidad span");
let subtotal= $(".subtotal");
let totalPrice= $(".totalPrice span");
let listtSC= $(".listtSC");

function totalp(index){
  let totalPri= 0;
  let arrayListSC= [];

  if(price.length>0){
    price.each(function(i){
    
      if(index != null){

        if($(quantity[index]).val() >= 3 || i >= 3 || index >= 3 || ($(quantity[index]).val() >= 3 && index >3) ){
        $(envio[index]).html(0);
        }else{
          $(envio[index]).html((5 * 1.5 )/ $(quantity[index]).val());
        }
          
      }

      let priceSub = $(price[i]).html().trim();

      if(priceSub.lastIndexOf(",", 1) >= 0){
        let re = new RegExp ("(^.*?),(.*)$");
         priceSub = re.exec(priceSub);
          if (priceSub.length > 0) {
            priceSub = ( parseFloat( priceSub[1]*1000)) + parseFloat(priceSub[2]) ;
          }else{
            priceSub =priceSub;
          }
      }else{
        priceSub = priceSub;
       
      }
   
      let subt= parseFloat((priceSub*$(quantity[i]).val()) + parseFloat( $(envio[i]).html()));
      totalPri += subt;
      $(subtotal[i]).html(`$${subt.toFixed(2)}`);

      // coocar la cookie 
      arrayListSC.push({
        "product": $(listtSC[i]).attr("url"),
        "details": $(listtSC[i]).attr("details"),
        "quantity": parseInt($(quantity[i]).val()) 
      });
    });
    $(totalPrice).html(totalPri.toFixed(2));

    // actualizar cookie
    setCookie("listSC", JSON.stringify(arrayListSC), 1);
  }
}

totalp(null);

function changeContry(event){
  $(".dialCode").html(event.target.value.split("_")[1]);
}

var metodpay= $('[name="payment-method"]').val()
function changemetodpay(event){
  metodpay = event.target.value;
}
// variable del total 
let total = $(".totalOrder").attr("total");

function checkout(){
  let forms = document.getElementsByClassName('needs-validation');
  var validation = Array.prototype.filter.call(forms, function(form) {
    if(form.checkValidity()){
      return [""];
    }
  })
  if(validation.length > 0){
    // pagar con paypal
    if(metodpay == "paypal"){
      switAlert("html", '<div id="paypal-button-container"></div>', null, null,null);
      paypal.Buttons({
         createOrder: function(data, actions){
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: total
              }
            }]
          });
        },

        onApprove: function(data, actions){
          return actions.order.capture().then(function(details){
            if(details.status == 'COMPLETED'){
               newOrden("paypal","pending", details.id,total);
            }
            return false;
          })
        },

        onCancel: function(data){
          switAlert("error", "La transaccion a sido cancelada", null,null,null );
          return false;
        },

        onError: function(err){
          switAlert("error", "Ocurrio un error al hacer la transaccion", null,null,null );
          return false;
        }
    }).render('#paypal-button-container');

    }
    // pagar con payu
    if(metodpay== "payu"){
      newOrden("payu","test", null,total);
    }
    // pagar con mercado pago
    if(metodpay=="mercado-pago"){

      let settings = {
        "url":"https://free.currconv.com/api/v7/convert?q=USD_MXN&compact=ultra&apiKey=d30bf7aea983c90e05fe",
        "method":"GET",
        "timeout": 0
      };

      $.ajax(settings).error(function(response){
        if(response.status == 400){
          switAlert("error", "Ocurrio un error al hacer la cnversion", null,null,null );
          return;
        }
      })


      $.ajax(settings).done(function(response){
        let newTotal = Math.round( Number(response["USD_MXN"])*Number(total));
        
        const mp = new MercadoPago("TEST-bc5703df-47d0-418c-ad63-3ac657df2e02");
        let formMP = `
                    <style>
                      #form-checkout {
                        display: flex;
                        flex-direction: column;
                        max-width: 600px;
                      }
                  
                      .container {
                        display: inline-block;
                        border: 1px solid rgb(118, 118, 118);
                        border-radius: 2px;
                        padding: 1px 2px;
                      }
                    </style>
                    <img src="img/payment-method/mercadopagoLogo.png" class="m-3" style="width:100px"/>
                    <form id="form-checkout">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">  
                          <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                        </div>
                        <div id="form-checkout__cardNumber" class="container form-control input-group-text"></div>
                      </div>
                      <div class="form-row">
                        <div class="col">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">  
                              <span class="input-group-text">FECHA</span>
                            </div>
                            <div id="form-checkout__expirationDate" class="container form-control"></div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">  
                              <span class="input-group-text">CVV/CVC</span>
                              </div>
                              <div id="form-checkout__securityCode" class="container form-control"></div>
                            </div>
                        </div>
                      </div>
  
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">  
                          <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                        </div>
                      <input class="form-control" type="text" id="form-checkout__cardholderName" />
                      </div>
  
                      <select class="form-control mb-3" id="form-checkout__issuer"></select>
                      <select class="form-control mb-3" id="form-checkout__installments"></select>
                      <select class="form-control mb-3" id="form-checkout__identificationType"></select>
  
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">  
                          <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                        </div>
                        <input class="form-control" type="text" id="form-checkout__identificationNumber" />
                      </div>
  
                      <div class="input-group mb-3">
                      <div class="input-group-prepend">  
                        <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                      </div>
                       <input class="form-control" type="email" id="form-checkout__cardholderEmail" />
                      </div>
                  
                      <button type="submit" class="btn btn-primary btn-lg btn-block" id="form-checkout__submit">Pagar</button>
                      <progress value="0" class="mt-3 w-100 progress-bar">Carregando...</progress>
                    </form>
        `;
  
        switAlert("html", formMP, null, null,null);
        const cardForm = mp.cardForm({
          amount: newTotal.toString(),
          iframe: true,
          form: {
            id: "form-checkout",
            cardNumber: {
              id: "form-checkout__cardNumber",
              placeholder: "Numero de tarjeta",
            },
            expirationDate: {
              id: "form-checkout__expirationDate",
              placeholder: "MM/YY",
            },
            securityCode: {
              id: "form-checkout__securityCode",
              placeholder: "Código de seguridad",
            },
            cardholderName: {
              id: "form-checkout__cardholderName",
              placeholder: "Titular de la tarjeta",
            },
            issuer: {
              id: "form-checkout__issuer",
              placeholder: "Banco emisor",
            },
            installments: {
              id: "form-checkout__installments",
              placeholder: "Cuotas",
            },        
            identificationType: {
              id: "form-checkout__identificationType",
              placeholder: "Tipo de documento",
            },
            identificationNumber: {
              id: "form-checkout__identificationNumber",
              placeholder: "Número del documento",
            },
            cardholderEmail: {
              id: "form-checkout__cardholderEmail",
              placeholder: "E-mail",
            },
          },
          callbacks: {
            onFormMounted: error => {
              if (error) return console.warn("Form Mounted handling error: ", error);
              console.log("Form mounted");
            },
            onSubmit: event => {
              event.preventDefault();
    
              const {
                paymentMethodId: payment_method_id,
                issuerId: issuer_id,
                cardholderEmail: email,
                amount,
                token,
                installments,
                identificationNumber,
                identificationType,
              } = cardForm.getCardFormData();
  
              let response = {
                token,
                issuer_id,
                payment_method_id,
                transaction_amount: Number(amount),
                installments: Number(installments),
                type: identificationType,
                number: identificationNumber,
              }
              response["total"]= newTotal;  
              newOrden("mercado-pago","test", null, response);
            },
            onFetching: (resource) => {
              console.log("Fetching resource: ", resource);
    
              // Animate progress bar
              const progressBar = document.querySelector(".progress-bar");
              progressBar.removeAttribute("value");
    
              return () => {
                progressBar.setAttribute("value", "0");
              };
            }
          },
        });  
      })
    }
    return false;
  }else{
    return false;
  }
}

function formatFecha(fecha){
  let day = fecha.getDate();
  let Mes=fecha.getMonth()+1;
  let año=fecha.getFullYear();

  return año + '-' + Mes + '-' + day;
}

  // cantidad de productos
  let envioOrderClass= $(".envioOrder");
  let envioOrder =[];

  envioOrderClass.each(i=>{
  envioOrder.push( parseFloat( $(envioOrderClass[i]).html()));
  });

  let quantityOrderClass= $(".quantityOrder");
  let quantityOrder =[];

  quantityOrderClass.each(i=>{
    quantityOrder.push($(quantityOrderClass[i]).html());
  });

  // precio de cada producto 
  let priceProductClass= $(".priceProd");
  let priceProduct =[];

  priceProductClass.each(i=>{
    priceProduct.push(($(priceProductClass[i]).html().replace(/\s+/gi,'')* quantityOrder[i]) + envioOrder[i]);
  });

// crear orden
function newOrden(metodo,status,id,totals){
  // id tienda
  let idStoreClass= $(".idStore");
  let idStore =[];

  idStoreClass.each(i=>{
    idStore.push($(idStoreClass[i]).val());
  });

  // url store
  let urlStoreClass= $(".urlStore");
  let urlStore =[];

  urlStoreClass.each(i=>{
    urlStore.push($(urlStoreClass[i]).val());
  });

  // id usuario
  let idUser = $("#idUser").val();

  // id producto
  let idProductClass= $(".idProduct");
  let idProduct =[];

  idProductClass.each(i=>{
    idProduct.push($(idProductClass[i]).val());
  });

  let stockProductClass= $(".stockProduct");
  let stockProduct =[];

  stockProductClass.each(i=>{
    stockProduct.push($(stockProductClass[i]).val());
  });

  let salesProductClass= $(".salesProduct");
  let salesProduct =[];

  salesProductClass.each(i=>{
    salesProduct.push($(salesProductClass[i]).val());
  });

  // detalles
  let detailOrderClass= $(".detailsOrder");
  let detailsOrder =[];

  detailOrderClass.each(i=>{
    detailsOrder.push($(detailOrderClass[i]).html().replace(/\s+/gi,''));
  });


  // Inforacion del usuario
  let emailOrder = $("#emailOrder").val();
  let countryOrder = $("#countryOrder").val().split("_")[0];
  let cityOrder = $("#cityOrder").val();
  let phoneOrder = $("#countryOrder").val().split("_")[1]+"_"+ $("#phoneOrder").val();
  let addresOrder = $("#addresOrder").val();
  let infoOrder = $("#infoOrder").val();
  let mapOrder = [document.getElementById('mappp').dataset.value.split(",")[0], document.getElementById('mappp').dataset.value.split(",")[1]];

  // tiempo de entrega
  let delytimeClass= $(".deliverytime");
  let deliveryTime =[];

  delytimeClass.each(i=>{
    deliveryTime.push($(delytimeClass[i]).val());
  });

  // preguntamos is la cookie ya existe
  let myCookie = document.cookie;
  let listCookie = myCookie.split(";");
  var arrayCoupon = "";

  for (const i in listCookie) {
    let list = listCookie[i].search("cuponMP");
    // si list es mayor a -1 es por qu se ncontro la cooki
    if (list > -1) {
      arrayCoupon = listCookie[i].split("=")[1]
      arrayCoupon = JSON.parse(decodeURIComponent(arrayCoupon));
    } 
  }

  // preguntar si el usuario quiere guardar su direccion
  let saveAdres= $("#create-account")[0].checked;
  if(saveAdres){
  
    let settings = {
      "url": $("#urlApi").val()+"users?id="+idUser+"&nameId=id_user&token=" + localStorage.getItem("token_user"),
      "method": "PUT",
      "timeaot": 0,
      "headers": {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      "data": {
        "country_user": countryOrder,
        "city_user": cityOrder,
        "phone_user": phoneOrder,
        "address_user": addresOrder,
        "map_user": JSON.stringify(mapOrder)
      },
    };

    $.ajax(settings).done(function (response) {});
  }

  let nameProduct= $(".name_producto");
  let descriptions="";
  let nameProducter =[];

  nameProduct.each(i=>{
    nameProducter.push($(nameProduct[i]).html());
  });

  nameProduct.each(i => {
    descriptions += $(nameProduct[i]).html() + " x " +quantityOrder[i] + ", ";
  });

  descriptions=descriptions.slice(0,-2);

  let foreachend = 0;
  let idOrder=[];
  let idSale=[];
  idProduct.forEach((value,i) => {

    let moment= Math.ceil(Number(deliveryTime[i]/2));
    let sendDate = new Date();
    sendDate.setDate(sendDate.getDate()+moment);

    let delyvereDate= new Date();
    delyvereDate.setDate(delyvereDate.getDate()+Number(deliveryTime[i]));

    let procesOrder=[
      {"stage":"reviewed",
      "status":"ok",
      "comment":"We have received your order, we start delivery process",
      "date":formatFecha(new Date())},

      {"stage":"sent",
      "status":"pending",
      "comment":"",
      "date":formatFecha(sendDate)},
      
      {"stage":"delivered",
      "status":"pending",
      "comment":"",
      "date":formatFecha(delyvereDate)}
    ];

   
    // guardar orden
    let settings = {
      "url": $("#urlApi").val() + "orders?token=" + localStorage.getItem("token_user"),
      "method": "POST",
      "timeaot": 0,
      "headers": {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      "data": {
        "id_store_order": idStore[i],
        "id_user_order": idUser,
        "id_product_order": value,
        "details_order": JSON.stringify(detailsOrder[i]),
        "quantity_order": quantityOrder[i],
        "price_order": priceProduct[i],
        "email_order": emailOrder,
        "country_order": countryOrder,
        "city_order": cityOrder,
        "phone_order": phoneOrder,
        "address_order": addresOrder,
        "notes_order": infoOrder,
        "process_order": JSON.stringify(procesOrder),
        "status_order": status,
        "date_created_order": formatFecha(new Date())  
      },
    };

    $.ajax(settings).done(function (response) {
      idOrder.push(response.result.idlast);
      if (response.status == 200) {
        // Crear comision
        let unitPrice = 0;
        let commissionPrice = 0;
        let count = 0;
        idOrder.push(response.result.idlast);

        if(arrayCoupon.length > 0){
          arrayCoupon.forEach(value2=> {
            if(value2 == urlStore[i]){
              count--;
            }else{
              count++;
            }
          });
        }
        if(arrayCoupon.length == count){
          // comision organica
          unitPrice= (Number(priceProduct[i])*0.75).toFixed(2);
          commissionPrice=(Number(priceProduct[i])*0.25).toFixed(2);
        }else{
          // comision por cupon
          unitPrice= (Number(priceProduct[i])*0.95).toFixed(2);
          commissionPrice=(Number(priceProduct[i])*0.05).toFixed(2);
        }
        
        // crear venta
        let settings = {
          "url": $("#urlApi").val() + "sales?token=" + localStorage.getItem("token_user"),
          "method": "POST",
          "timeaot": 0,
          "headers": {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          "data": {
            "id_order_sale": response.result.idlast,
            "id_store_sale": idStore[i],
            "name_product_sale": nameProducter[i],
            "unit_price_sale": unitPrice,
            "commission_sale": commissionPrice,
            "payment_method_sale": metodo,
            "id_payment_sale": id,
            "status_sale": status,
            "date_created_sale": formatFecha(new Date())  
          },
        };
        
        $.ajax(settings).done(function (response) {
          idSale.push(response.result.idlast);
          if(response.status==200){
            if(metodo == "paypal"){
               // contruir venta y stock
               let settings2 = {
                "url": $("#urlApi").val()+"products?id="+value+"&nameId=id_product&token=" + localStorage.getItem("token_user"),
                "method": "PUT",
                "timeaot": 0,
                "headers": {
                  "Content-Type": "application/x-www-form-urlencoded",
                },
                "data": {
                  "stock_product": Number(stockProduct[i])-Number(quantityOrder[i]),
                  "sales_product": Number(salesProduct[i])+Number(quantityOrder[i])
                },
              };
              $.ajax(settings2).done(function (response) {});
            }
            foreachend++;
            if(foreachend == idProduct.length){
              if(metodo == "paypal"){
                document.cookie = "listSC=; max-age=0";
                switAlert("success", "El pago se realizo correctamente...", $('#url').val() + "acount&my-shopping", null, 1500); 
                window.location = $("#url").val()+"acount&my-shopping";    
                return;
              }
              if(metodo == "payu"){

                let action= "https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/";
                let merchantId= 508029;
                let accountId=512324;
                let referenceCode= Math.ceil(Math.random()*1000000);
                let apiKey= "4Vj8eK4rloUd272L48hsrarnUA";
                let signature = hex_md5(apiKey+"~"+merchantId+"~"+referenceCode+"~"+totals+"~MXN");
                let test=1;
                let url =$("#url").val()+"checkout";
                let formPayu = ` 
                                  <img src="img/payment-method/PAYULogo.png" style="width:100px"/>
                                  <form method="post" action="`+action+`">
                                    <input name="merchantId"      type="hidden"  value="`+merchantId+`"   >
                                    <input name="accountId"       type="hidden"  value="`+accountId+`" >
                                    <input name="description"     type="hidden"  value="`+descriptions+`"  >
                                    <input name="referenceCode"   type="hidden"  value="`+referenceCode+`" >
                                    <input name="amount"          type="hidden"  value="`+totals+`"   >
                                    <input name="tax"             type="hidden"  value="0"  >
                                    <input name="taxReturnBase"   type="hidden"  value="0" >
                                    <input name="currency"        type="hidden"  value="MXN" >
                                    <input name="signature"       type="hidden"  value="`+signature+`"  >
                                    <input name="test"            type="hidden"  value="`+test+`" >
                                    <input name="buyerEmail"      type="hidden"  value="`+emailOrder+`" >
                                    <input name="responseUrl"     type="hidden"  value="`+url+`" >
                                    <input name="confirmationUrl" type="hidden"  value="`+url+`" >
                                    <input name="Submit" class="ps-btn p-0 px-5" type="submit"  value="Pagar" >
                                  </form>`;
                switAlert("html", formPayu, null, null,null);
                setCookie("idProduct", JSON.stringify(idProduct),1);
                setCookie("quantityOrder", JSON.stringify(quantityOrder),1);
                setCookie("idOrder", JSON.stringify(idOrder),1);
                setCookie("idSale", JSON.stringify(idSale),1);
              }
              if(metodo == "mercado-pago"){

                totals["description"]=descriptions;
                totals["email"]=emailOrder;
                setCookie("idProduct", JSON.stringify(idProduct),1);
                setCookie("quantityOrder", JSON.stringify(quantityOrder),1);
                setCookie("idOrder", JSON.stringify(idOrder),1);
                setCookie("idSale", JSON.stringify(idSale),1);
                setCookie("mp", JSON.stringify(totals),1);

                window.location = $("#url").val()+"checkout";
              }
            }
          }
        });
      }
    });
  });
  
}


function goTermins(){
  $("html, body").animate({
    scrollTop: $("#tabContent").offset().top-50 
  });
}

function aceptTermins(event){
  if(event.target.checked){
    $("#crearStore").tab("show");
    $(".btnCreateStore").removeClass("disabled");
    $("html, body").animate({
      scrollTop: $("#crearStore").offset().top-100 
    });
  }else{
    $("#crearStore").removeClass("active");
    $(".btnCreateStore").addClass("disabled");
  }
}

function urlCreate(e,urlStore){
  var value = e.target.value;

  value = value.toLowerCase();
  value = value.replace(/[ ]/g, "-");
  value = value.replace(/[á]/g, "a");
  value = value.replace(/[é]/g, "e");
  value = value.replace(/[í]/g, "i");
  value = value.replace(/[ó]/g, "o");
  value = value.replace(/[ú]/g, "u");

  if(urlStore == "urlStore"){

    $('[name="'+urlStore+'"]').val(value);
    
    //mapa
    let resultList =  document.getElementById('mappp').value;

    console.log(resultList);

    if(resultList == undefined || resultList == null || resultList == "" ){
        resultList = [19.42847,-99.12766];
    }else{
      resultList = JSON.parse( resultList);
    }

    const title = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
    let myMap=0;

    function mapa(resultList){

      if(myMap!=0){
        myMap.remove();
      }

    let finalMap= document.getElementById("mappp");
    finalMap.setAttribute("value", resultList);

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
    marker.on("moveend", (e)=> { 
      document.getElementById("mappp").setAttribute("value", [e.target._latlng.lat, e.target._latlng.lng ]);  
    });
    myMap.doubleClickZoom.disable();
    }

    mapa(resultList);

    document.getElementById('addresStore').addEventListener('change', () => {
        const pais= document.getElementById('countryStore').value.split("_")[0];
        const city= document.getElementById('cityStore').value;
        const adres= document.getElementById('addresStore').value;
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

  if(urlStore == "urlProduct"){
    $('[name="'+urlStore+'"]').val(value);
  }

}

function validarStore(){
  let formStore = $(".formStore");
  let error=0;
  formStore.each(i=>{
    if($(formStore[i]).val() == "" || $(formStore[i]).val() == undefined){
      error++;
      $(formStore[i]).parent().addClass("was-validated");
    }
  });
  if(error > 0){
    switAlert("error", "Algunos campos faltan o estan mal", null, null);
    return;
  }

  $("#crearProduct").tab("show");
  $(".btnCreateProduct").removeClass("disabled");

  $("html, body").animate({
    scrollTop: $("#crearProduct").offset().top-100 
  });
}

function changecategory(event){
  $(".subcategoryProduct").show();
  let idCategory = event.target.value.split("_")[0];
  let settings = {
    "url": $("#urlApi").val()+"subcategories?equalTo="+idCategory+"&linkTo=id_category_subcategory&select=id_subcategory,name_subcategory,title_list_subcategory",
    "method":"GET",
    "timeout":0,
  };

  $.ajax(settings).done(function(response){
    let limpiar= $(".optSubCategory");
    limpiar.each(i=>{
      $(limpiar[i]).remove();
    });
    response.result.forEach(item =>{
      $('[name="subcategoryProduct"]').append(`<option class="optSubCategory" value="`+item.id_subcategory+`_`+item.title_list_subcategory+`">`+item.name_subcategory+`</option>`);
    });
  });
}

function addInput(elem,type){
  let inputs = $("."+type);
  
  if(inputs.length < 5){
    if(type == "inputSummary"){
      $(elem).before(`
      <div class="form-group__content input-group mb-3 inputSummary">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <button type="button" class="btn btn-danger" onclick="removedInput(`+inputs.length+`,'inputSummary')">&times;</button>
                    </span>
                </div>
                <input 
                class="form-control"
                type="text"
                name="summaryProduct_`+inputs.length+`"
                required
                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                onchange="validatejs(event, 'parrafo')">
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Acompleta el campo</div>
            </div>
      `);
    }

    if(type == "inputDetails"){
      $(elem).before(`
          <div class="row mb-3 inputDetails">
          <div class="col-12 col-lg-6 form-group__content input-group">
              <div class="input-group-append">
                  <span class="input-group-text">
                      <button type="button" class="btn btn-danger" onclick="removedInput(`+inputs.length+`,'inputDetails')">&times;</button>
                  </span>
              </div>
              <div class="input-group-append">
                  <span class="input-group-text">
                      Title:
                  </span>
              </div>
              <input 
              class="form-control"
              type="text"
              name="detailsTitleProduct_`+inputs.length+`"
              required
              pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
              onchange="validatejs(event, 'parrafo')">
              <div class="valid-feedback"></div>
              <div class="invalid-feedback">Acompleta el campo</div>
          </div>
          <div class="col-12 col-lg-6 form-group__content input-group">
              <div class="input-group-append">
                  <span class="input-group-text">
                      Value:
                  </span>
              </div>
              <input 
              class="form-control"
              type="text"
              name="detailsValueProduct_`+inputs.length+`"
              required
              pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
              onchange="validatejs(event, 'parrafo')">
              <div class="valid-feedback"></div>
              <div class="invalid-feedback">Acompleta el campo</div>
          </div>
      </div>
      `);
  }

  if(type == "inputEspesifications"){
    $(elem).before(`
    <div class="row mb-3 inputEspesifications">
        <div class="col-12 col-lg-6 form-group__content input-group">
            <div class="input-group-append">
                <span class="input-group-text">
                    <button type="button" class="btn btn-danger" onclick="removedInput(`+inputs.length+`,'inputEspesifications')">&times;</button>
                </span>
            </div>
            <div class="input-group-append">
                <span class="input-group-text">
                    Type:
                </span>
            </div>
            <input 
            class="form-control"
            type="text"
            name="EspesificTypeProduct_`+inputs.length+`"
            required
            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
            onchange="validatejs(event, 'parrafo')">
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">Acompleta el campo</div>
        </div>
        <div class="col-12 col-lg-6 form-group__content input-group">
            <input 
            class="form-control tags-input"
            data-role="tagsinput"
            type="text"
            placeholder="Escribe y preciona enter" 
            name="EspesificValuesProduct_`+inputs.length+`"
            required
            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
            onchange="validatejs(event, 'parrafo')">
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">Acompleta el campo</div>
        </div>
    </div>
    `);
    fcnTagInput();
}
  $('[name="'+type+'"]').val(inputs.length+1);  
  }else{
    switAlert("error", "Solo puedes colocar 5 summarys", null, null);
    return;
  }
}

function removedInput(indice,type){
  let inputs = $("."+type);
  
  if(inputs.length > 1){
    inputs.each(i=>{
      if(i==indice){
        $(inputs[i]).remove();
      }
    });
    $('[name="'+type+'"]').val(inputs.length-1); 
  }else{
    switAlert("error", "Ya no puedes eliminar ninguno", null, null);
    return;
  }
}

function fcnTagInput(){
  let target = $('.tags-input');
  if(target.length > 0){
    $(target).tagsinput();
  }
}

fcnTagInput();

Dropzone.autoDiscover = false;
let arrayFiles=[];
let countrrayfiles= 0;

$(".dropzone").dropzone({
  url: "/",
  addRemoveLinks: true,
  acceptedFiles: "image/jpeg, image/png",
  maxFilesSize: 2,
  maxFiles:10,
  init: function(){
    this.on("addedfile", function(file){
      countrrayfiles++;
      setTimeout( function(){
        arrayFiles.push({
          "file":file.dataURL,
          "type":file.type,
          "width":file.width,
          "height":file.height
        });
        $("[name='galeryProduct']").val(JSON.stringify(arrayFiles));
      },1000*countrrayfiles);
    });
    this.on("removedfile", function(file){
      countrrayfiles++;
      setTimeout( function(){
        let index = arrayFiles.indexOf({
          "file":file.dataURL,
          "type":file.type,
          "width":file.width,
          "height":file.height
        });
        arrayFiles.splice(index,1);
        $("[name='galeryProduct']").val(JSON.stringify(arrayFiles));
      },1000*countrrayfiles);
    });
    myDropzone = this;
    $(".saveBtn").click(function(){
      if(arrayFiles.length >= 1 ){
        myDropzone.processQueue();
      }else{
        switAlert("error", "La galeria esta vacia", null, null);
      }
    });
  }
});


function changeOfer(type){
  if(type.target.value == "Discount"){
    $(".typeOffer").html("Percent %:");
  }
  if(type.target.value == "Fixed"){
    $(".typeOffer").html("Price $:");
  }
}

function dispararmapa(){

  setTimeout(() => {
    
  
  //mapa
  if(document.getElementById('mapppp')){
    let resultList =  document.getElementById('mapppp').value;
    
    if(resultList != ""){
      if(resultList == undefined){
          resultList = [19.42847,-99.12766];
      }else{
        resultList = JSON.parse( resultList);
      }

      const title = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
      let myMap=0;

      function mapa(resultList){

        if(myMap!=0){
          myMap.remove();
        }

      let finalMap= document.getElementById("mapppp");
      finalMap.setAttribute("value", resultList);

      myMap= L.map('myMapp').setView(resultList, 25);

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
      marker.on("moveend", (e)=> { 
        document.getElementById("mapppp").setAttribute("value", [e.target._latlng.lat, e.target._latlng.lng ]);  
      });
      myMap.doubleClickZoom.disable();
      }

      mapa(resultList);

      document.getElementById('addresStore').addEventListener('change', () => {
          const pais= document.getElementById('countryStore').value.split("_")[0];
          const city= document.getElementById('cityStore').value;
          const adres= document.getElementById('addresStore').value;
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
  }
}, 1000);
}

function stateCheck(event,idProduct,idview){
  let state = "";
  
  if(event.target.checked){
    state = "show"; 
  }else{
    state = "hidden";
  }
  
  let token = localStorage.getItem("token_user");
  let settings = {
    "url" : $("#urlApi").val()+"products?id="+idProduct+"&nameId=id_product&token="+token,
    "method": "PUT",
    "timeaot": 0,
    "headers": {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    "data": {
      "state_product": state,
    },
  };
  $.ajax(settings).done(function(response){
    if(response.status==200){}
  })
}

if($("[name='galeryProductOld']").length > 0 && $("[name='galeryProductOld']").val() != ''){
  var arrayFilesOld = JSON.parse($("[name='galeryProductOld']").val());
}
var arrayFilesDelete = Array();
function removeGallery(elem){
  $(elem).parent().remove();
  let index = arrayFilesOld.indexOf($(elem).attr("remove"));
  arrayFilesOld.splice(index, 1);
  $("[name='galeryProductOld']").val(JSON.stringify(arrayFilesOld));
  arrayFilesDelete.push($(elem).attr("remove"));
  $("[name='deleteGaleryProduct']").val(JSON.stringify(arrayFilesDelete));
}

function removesProducts(idProduct){
  switAlert("confirm", "Esta seguro de eliminar este producto?", null, null, null).then(resp => {
    if(resp){
      let data = new FormData();
      data.append("idProduct", idProduct);
      $.ajax({
        url : $("#path").val() + "ajax/productsDelete.php",
        method : "POST",
        data : data,
        contentType : false,
        cache : false,
        processData : false,
        success : function(response){
          let settings = {
            "url" : $("#urlApi").val()+"products?id="+idProduct+"&nameId=id_product&token="+localStorage.getItem("token_user"),
            "method" : "DELETE",
            "timeout" : 0,
            "headers" : {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          };

          $.ajax(settings).done(function(response){
            if(response.status == 200){
              switAlert("success", "El producto se añadio a la lista de deseos", null, null, 1500);
              setTimeout(() => {
                window.location = $("#path").val()+"acount&my-store";
              }, 1500);
            }
          });
        },
        error : function(jqXHR, textStatus, errorThrown){
          console.log(textStatus + " " + errorThrown);
        }
      });
    }

  })
}

$(document).on("click", ".nextProcess", function(){
  $(".orderBody").html("");
  let idStores = $(this).attr("idStores");
  let namessProduct = $(this).attr("namessProduct");
  let idOrder = $(this).attr("idOrder");
  let clientOrder = $(this).attr("clientOrder");
  let emailOrder = $(this).attr("emailOrder");
  let productOrder = $(this).attr("productOrder");
  let processOrder = JSON.parse(atob($(this).attr("processOrder")));

  $(".modal-title span").html("Order N. " + idOrder);

  if(processOrder[1].status == "pending"){
    processOrder.splice(2,1);
  }

  processOrder.forEach((value, index) => {
    let date = "";
    let status = "";
    let comment = "";

    if(value.status == "ok"){
      date = `
        <div class="col-10">
          <input 
          type="date" 
          class="form-control" 
          value="`+value.date+`" 
          readonly
          pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
          onchange="validatejs(event, 'parrafo')">
          <div class="valid-feedback"></div>
          <div class="invalid-feedback">El nombre es requerido</div>
        </div>
      `;
      status = `
        <div class="col-10 mt-3">
          <div class="text-uppercase">`+value.status+`</div>
        </div>
      `;
      comment = `
        <div class="col-10 mt-3">
          <textarea 
          class="form-control" 
          placeholder="Escribe un comentario" 
          readonly
          pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
          onchange="validatejs(event, 'parrafo')"
          >`+value.comment+`</textarea>
          <div class="valid-feedback"></div>
          <div class="invalid-feedback">El nombre es requerido</div>
        </div>
      `;
    }else{
      date = `
      <div class="col-10">
        <input 
        type="date" 
        class="form-control" 
        name="date" 
        value="`+value.date+`" 
        required
        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
        onchange="validatejs(event, 'parrafo')">
        <div class="valid-feedback"></div>
        <div class="invalid-feedback">El nombre es requerido</div>
      </div>
    `;
    status = `
        <div class="col-10 mt-3">
          <input type="hidden" name="stage" value="`+value.stage+`">
          <input type="hidden" name="processOrder" value="`+$(this).attr("processOrder")+`">
          <input type="hidden" name="idOrder" value="`+idOrder+`">
          <input type="hidden" name="namessProduct" value="`+namessProduct+`">
          <input type="hidden" name="idStores" value="`+idStores+`">
          <input type="hidden" name="clientOrder" value="`+clientOrder+`">
          <input type="hidden" name="emailOrder" value="`+emailOrder +`">
          <input type="hidden" name="productOrder" value="`+productOrder+`">
          
          <div class="custom-control custom-radio custom-control-inline">
            <input
              id="status-pending"
              type="radio"
              class="custom-control-input"
              value="pending"
              name="status"
              checked>
              <label class="custom-control-label" for="status-pending">Pending</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input
              id="status-ok"
              type="radio"
              class="custom-control-input"
              value="ok"
              name="status">
              <label class="custom-control-label" for="status-ok">OK</label>
          </div>
        </div>
      `;
      comment = `
      <div class="col-10 mt-3">
        <textarea 
        class="form-control" 
        placeholder="Escribe un comentario" 
        name="comment" 
        required
        value="`+value.date+`" required
        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
        onchange="validatejs(event, 'parrafo')">
        </textarea>
        <div class="valid-feedback"></div>
        <div class="invalid-feedback">El nombre es requerido</div>
      </div>
    `;
    }

    $(".orderBody").append(`
      <div class="card-header text-uppercase">`+value.stage+`</div>
      <div class="card-body">
        <div class="form-row">
          <div class="col-2 text-right">
            <label class="p-3 lead text-right">Date: </label>
          </div>
          `+date+`
        </div>
        <div class="form-row">
          <div class="col-2 text-right">
            <label class="p-3 lead">Status: </label>
          </div>
          `+status+`
        </div>
        <div class="form-row">
          <div class="col-2 text-right">
            <label class="p-3 lead">Comment: </label>
          </div>
          `+comment+`
        </div>
      </div>
    `);
  });
  $("#nextProcess").modal();
});

$(document).on("click", ".openDisputes", function(){
  $("[name='idOrder']").val($(this).attr("idOrder"));
  $("[name='idUser']").val($(this).attr("idUser"));
  $("[name='idStore']").val($(this).attr("idStore"));
  $("[name='emailStore']").val($(this).attr("emailStore"));
  $("[name='nameStore']").val($(this).attr("nameStore"));
  $("#newDispute").modal();
});

$(document).on("click", ".answerDiput", function(){
  $("[name='idDispute']").val($(this).attr("idDispute"));
  $("[name='clientDispute']").val($(this).attr("clientDispute"));
  $("[name='emailDispute']").val($(this).attr("emailDispute"));
  $("#answerDisput").modal();
});

$(document).on("click", ".answerMessage", function(){
  $("[name='idMessage']").val($(this).attr("idMessage"));
  $("[name='clientMessage']").val($(this).attr("clientMessage"));
  $("[name='emailMessage']").val($(this).attr("emailMessage"));
  $("[name='urlProduct']").val($(this).attr("urlProduct"));
  $("#answerMessage").modal();
});

$(document).on("click", ".CommentStars", function(){
  $("[name='idProduct']").val($(this).attr("idProduct"));
  $("[name='idUser']").val($(this).attr("idUser"));
  $("#newComment").modal();
});
