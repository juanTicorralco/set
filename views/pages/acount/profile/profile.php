<?php
$idStores="";
$select = "id_store";
$url = CurlController::api()."stores?linkTo=id_user_store&equalTo=".$_SESSION["user"]->id_user."&select=".$select;
$method = "GET";
$fields = array();
$headers = array();
$store = CurlController::request($url,$method,$fields,$headers);
$totalOrders=0;
$totalProducts = 0;
$totalMessages = 0;
$totalDisputes = 0;

if($store->status == 200){
    $idStores = $store->result[0]->id_store;

    $url = CurlController::api()."orders?linkTo=id_store_order,status_order&equalTo=".$idStores.",pending&select=id_order&token=".$_SESSION["user"]->token_user;
    $ordersid = CurlController::request($url,$method,$fields,$headers);
    if($ordersid->status == 200){
        
        $totalOrders = $ordersid->total;
    }

    $url = CurlController::api()."products?linkTo=id_store_product&equalTo=".$idStores."&select=id_product";
    $productsid = CurlController::request($url,$method,$fields,$headers);
    if($productsid->status == 200){
        $totalProducts = $productsid->total;
    }

    $url = CurlController::api()."disputes?linkTo=id_store_dispute&equalTo=".$idStores."&select=answer_dispute&token=".$_SESSION["user"]->token_user;
    $disputesid = CurlController::request($url,$method,$fields,$headers);
    if($disputesid->status == 200){
        foreach($disputesid->result as $key => $value){
            if($value->answer_dispute == null){
                $totalDisputes++;
            }
        }
    }

    $url = CurlController::api()."messages?linkTo=id_store_message&equalTo=".$idStores."&select=answer_message&token=".$_SESSION["user"]->token_user;
    $messagesId = CurlController::request($url,$method,$fields,$headers);
    if($messagesId->status == 200){
        foreach($messagesId->result as $key => $value){
            if($value->answer_message == null){
                $totalMessages++;
            }
        }
    }
}

?>
<aside class="ps-block--store-banner">

    <div class="ps-block__user">

        <div class="ps-block__user-avatar">

            <?php if ($_SESSION["user"]->method_user == "direct") : ?>
                <?php if ($_SESSION["user"]->image_user == "" || $_SESSION["user"]->image_user == "NULL") : ?>
                    <img src="img/users/default/default.png" alt="<?php echo $_SESSION["user"]->name_user; ?>">
                <?php else : ?>
                    <img src="img/users/<?php echo $_SESSION["user"]->id_user; ?>/<?php echo $_SESSION["user"]->image_user; ?>" alt="<?php echo $_SESSION["user"]->name_user; ?>">
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($_SESSION["user"]->method_user == "administer") : ?>
                <?php if ($_SESSION["user"]->image_user == "" || $_SESSION["user"]->image_user == "NULL") : ?>
                    <img src="img/users/default/default.png" alt="<?php echo $_SESSION["user"]->name_user; ?>">
                <?php else : ?>
                    <img src="img/users/<?php echo $_SESSION["user"]->id_user; ?>/<?php echo $_SESSION["user"]->image_user; ?>" alt="<?php echo $_SESSION["user"]->name_user; ?>">
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($_SESSION["user"]->method_user == "globalAdminister") : ?>
                <?php if ($_SESSION["user"]->image_user == "" || $_SESSION["user"]->image_user == "NULL") : ?>
                    <img src="img/users/default/default.png" alt="<?php echo $_SESSION["user"]->name_user; ?>">
                <?php else : ?>
                    <img src="img/users/<?php echo $_SESSION["user"]->id_user; ?>/<?php echo $_SESSION["user"]->image_user; ?>" alt="<?php echo $_SESSION["user"]->name_user; ?>">
                <?php endif; ?>
            <?php endif; ?>
            <div class="br-wrapper">

                <button class="btn btn-primary btn-lg rounded-circle" data-toggle="modal" data-target="#changePhoto"><i class="fas fa-pencil-alt"></i></button>

            </div>

        </div>

        <div class="ps-block__user-content text-center text-lg-left">

            <h2 class="text-white"><?php echo $_SESSION["user"]->name_user; ?></h2>

            <p><i class="fas fa-user"></i> <?php echo $_SESSION["user"]->name_user; ?></p>

            <p><i class="fas fa-envelope"></i> <?php echo $_SESSION["user"]->email_user; ?></p>

            <?php if ($_SESSION["user"]->method_user == "direct") : ?>
                <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#changePassword">Cambiar Password</button>
            <?php endif; ?>
            <?php if ($_SESSION["user"]->method_user == "administer") : ?>
                <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#changePassword">Cambiar Password</button>
            <?php endif; ?>
            <?php if ($_SESSION["user"]->method_user == "globalAdminister") : ?>
                <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#changePassword">Cambiar Password</button>
            <?php endif; ?>

        </div>

        <?php if($_SESSION["user"]->method_user == "globalAdminister"): ?>
        <div class="row ml-lg-auto pt-5">

            <div class="col-lg-3 col-6">
                <div class="text-center">
                    <a href="<?php echo TemplateController::path(); ?>acount&my-store&orders">
                        <h1><i class="fas fa-shopping-cart text-white"></i></h1>
                        <h4 class="text-white">Orders <span class="badge badge-secondary rounded-circle"><?php echo $totalOrders; ?></span></h4>
                    </a>
                </div>
            </div><!-- box /-->

            <div class="col-lg-3 col-6">
                <div class="text-center">
                    <a href="<?php echo TemplateController::path(); ?>acount&my-store">
                        <h1><i class="fas fa-shopping-bag text-white"></i></h1>
                        <h4 class="text-white">Products <span class="badge badge-secondary rounded-circle"><?php echo $totalProducts; ?></span></h4>
                    </a>
                </div>
            </div><!-- box /-->

            <div class="col-lg-3 col-6">
                <div class="text-center">
                    <a href="<?php echo TemplateController::path(); ?>acount&my-store&disputes">
                        <h1><i class="fas fa-bell text-white"></i></h1>
                        <h4 class="text-white">Disputes <span class="badge badge-secondary rounded-circle"><?php echo  $totalDisputes; ?></span></h4>
                    </a>
                </div>
            </div><!-- box /-->

            <div class="col-lg-3 col-6">
                <div class="text-center">
                    <a href="<?php echo TemplateController::path(); ?>acount&my-store&messages">
                        <h1><i class="fas fa-comments text-white"></i></h1>
                        <h4 class="text-white">Messages <span class="badge badge-secondary rounded-circle"><?php echo $totalMessages; ?></span></h4>
                    </a>
                </div>
            </div><!-- box /-->
        </div>
        <?php endif; ?>

    </div>

</aside><!-- s -->

<!-- ventana modal -->
<!-- The Modal -->
<div class="modal" id="changePassword">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nueva Contraseña</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form class="ps-form--account ps-tab-root needs-validation" novalidate method="post">
                    <div class="form-group form-forgot">
                        <input class="form-control" type="password" id="createPassword" name="newPassword" placeholder="Nuevo Password..." required pattern="[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}" onchange="validatejs(event, 'pass')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">El nuevo password es requerido</div>
                    </div>

                    <div class="form-group ">

                        <input class="form-control" type="password" id="passRep" name="repeatPassword" placeholder="Repeat Password..." required onchange="validatejs(event, 'repeatPass')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">El password es requerido</div>

                    </div>

                    <div class="form-group submtit">

                        <?php
                        $newPass = new ControllerUser();
                        $newPass->actualiarContraseña();
                        ?>

                        <button type="submit" class="ps-btn ps-btn--fullwidth">Actualizar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Photo-->
<div class="modal" id="changePhoto">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nueva Foto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form class="ps-form--account ps-tab-root needs-validation" novalidate method="post" enctype="multipart/form-data">
                    <small class="helsmall-block small">Dimensiones: 200px x 200px | Tamaño: 2MB | Formato: JPG o PNG</small>
                  
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile"  accept="image/*" maxSize="2000000" name="changePhoto" onchange="validateImageJs(event, 'changePhoto')" required>
                        <label for="customFile" class="custom-file-label">Buscar archivo</label>
                    </div>
                    <figure class="text-center py-3">
                        <img src="" class="img-fluid rounded-circle changePhoto" style="max-width: 150px;">
                    </figure>

                    <div class="form-group submtit">

                        <?php
                        $newphoto= new ControllerUser();
                        $newphoto->CambiarPhoto();
                        ?>

                        <button type="submit" class="ps-btn ps-btn--fullwidth">Actualizar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="registerNew">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nuevo Registro</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form class="ps-form--account ps-tab-root needs-validation" novalidate method="post">
                <input type="hidden" value="<?php echo CurlController::api();?>" id="urlApi">
                <input type="hidden" value="<?php 
                 if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                    $url = "https://"; 
                  }else{
                    $url = "http://"; 
                  }
                  echo $url . $_SERVER['HTTP_HOST']."/";
                ?>" id="urlLocal">
                    <!-- Product -->
                    <div class="form-group">
                        <label>Producto<sup class="text-danger">*</sup></label>
                        <?php
                            $url = CurlController::api()."relations?rel=products,categories&type=product,category&select=id_product,name_product,url_product,id_category";
                            $method= "GET";
                            $header= array();
                            $fields= array();
                            
                            $produts= CurlController::request($url, $method, $header, $fields)->result;
                        ?>
                        <div class="form-group__content">
                            <select 
                            class="form-control"
                            name="SelectProduct"
                            onchange="changeProduct(event)"
                            required>
                                <option value="">Seleccionar producto</option>
                                <?php foreach($produts as $key => $value):?>
                                    <option value="<?php echo $value->id_category."_".$value->id_product."_".$value->name_product; ?>"><?php echo $value->name_product; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">El nombre es requerido</div>
                        </div>
                        <figure id="imageProduct">
                        </figure>
                        <div id="stokeorderProduct" ></div>
                        <input type="hidden" name="stockApro" id="stockApro">
                    </div>
                    <div class="form-group">
                        <label>ESPESIFICACIONES ORDEN<sup class="text-danger">*</sup></label>
                        <div class="row mb-5">
                            <!-- Color -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3 ColorProduct" style="display: none ;">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Color:
                                    </span>
                                </div>
                                <select 
                                class="form-control"
                                name="ColorProduct"
                                required>
                                <option value="">Select Color</option>
                                </select>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">El nombre es requerido</div>
                            </div>
                            <!-- talla -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3 TallaProduct" style="display: none ;">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Talla:
                                    </span>
                                </div>
                                <select 
                                class="form-control"
                                name="TallaProduct"
                                onchange="changeTalla(event)"
                                required>
                                <option value="">Select Talla</option>
                                </select>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">El nombre es requerido</div>
                            </div>
                            <!-- Peso -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Peso:
                                    </span>
                                </div>
                                <input 
                                type="text"
                                class="form-control"
                                placeholder="Peso"
                                name="PesoProduct"
                                maxlength="50"
                                required
                                pattern = "[.\\,\\0-9]{1,}"
                                onchange="validatejs(event, 'numbers')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <!-- Altura -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Altura:
                                    </span>
                                </div>
                                <input 
                                type="text"
                                class="form-control"
                                placeholder="Altura"
                                name="AlturaProduct"
                                maxlength="50"
                                required
                                pattern = "[.\\,\\0-9]{1,}"
                                onchange="validatejs(event, 'numbers')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <!-- Precio -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Precio:
                                    </span>
                                </div>
                                <input 
                                type="text"
                                class="form-control precioProduct"
                                placeholder="Precio"
                                name="precioProduct"
                                maxlength="50"
                                required
                                pattern = '[.\\,\\0-9]{1,}'
                                onchange="validatejs(event, 'numbers')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <!-- Pago Previo -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Pago Prev:
                                    </span>
                                </div>
                                <input 
                                type="text"
                                class="form-control"
                                placeholder="Pago previo"
                                name="pagoPrevProduct"
                                maxlength="50"
                                value="0"
                                required
                                pattern = '[.\\,\\0-9]{1,}'
                                onchange="validatejs(event, 'numbers')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <!-- Envio -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        ENVIO:
                                    </span>
                                </div>
                                <input class="form-control" name="envioProduct" type="checkbox">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>ESPESIFICACIONES ENTREGA<sup class="text-danger">*</sup></label>                
                        <div class="row mb-5">
                            <!-- Dia -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Dia:
                                    </span>
                                </div>
                                <input 
                                type="date"
                                class="form-control"
                                placeholder="Dia"
                                name="diaProduct"
                                maxlength="50"
                                required
                                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validatejs(event, 'parrafo')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <!-- Hora -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Hora:
                                    </span>
                                </div>
                                <input 
                                type="time"
                                class="form-control"
                                placeholder="Hora"
                                name="horaProduct"
                                maxlength="50"
                                required
                                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validatejs(event, 'parrafo')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <!-- Linea -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Linea:
                                    </span>
                                </div>
                                <?php
                                    $data = file_get_contents("views/json/metro.json");
                                    $metro= json_decode($data, true);
                                ?>
                                <select 
                                class="form-control"
                                name="SelectLinea"
                                onchange="changeLinea(event)"
                                required>
                                    <option value="">Seleccionar Linea</option>
                                    <?php foreach($metro as $key => $value): print_r($value['_id']);  ?>
                                        <?php if(key($value)=="nombre"): ?>
                                        <option value="<?php echo $value['_id']['v']."_".$value['nombre']; ?>"><?php echo $value["nombre"]; ?></option>
                                            <?php endif ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">El nombre es requerido</div>
                            </div>
                            <!-- Estacion -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3 EstacionProduct" style="display: none ;">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Estacion:
                                    </span>
                                </div>
                                <select 
                                    class="form-control"
                                    name="EstacionProduct"
                                    required>
                                    <option value="">Select Color</option>
                                </select>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">El nombre es requerido</div>
                            </div>
                            <!-- Nombre -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        nombre:
                                    </span>
                                </div>
                                <input 
                                type="text"
                                class="form-control"
                                placeholder="Nombre cliente"
                                name="nombreProduct"
                                maxlength="50"
                                required
                                pattern = '[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validatejs(event, 'text')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <!-- Telefono -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Telefono:
                                    </span>
                                </div>
                                <input 
                                type="text"
                                class="form-control"
                                placeholder="Telefono cliente"
                                name="telefonoProduct"
                                maxlength="50"
                                required
                                pattern = '[-\\(\\)\\0-9 ]{1,}'
                                onchange="validatejs(event, 'phone')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <!-- Messenguer -->
                            <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Messenger:
                                    </span>
                                </div>
                                <input 
                                type="text"
                                class="form-control"
                                placeholder="Id messenger"
                                name="messengerProduct"
                                maxlength="50"
                                required
                                pattern = '[.\\,\\0-9]{1,}'
                                onchange="validatejs(event, 'numbers')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group submtit">

                        <?php
                        $newPass = new ControllerUser();
                        $newPass->AgregarNewRegister();
                        ?>

                        <button type="submit" class="ps-btn ps-btn--fullwidth">Registrar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>