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
        color: "#716add",
        background: "#fff url(img/users/default/fondo.jpg)",
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