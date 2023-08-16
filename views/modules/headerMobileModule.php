<header class="header header--mobile" data-sticky="true">

    <div class="header__top">

        <div class="header__left">

            <ul class="d-flex justify-content-center">
                <li><a href="#" target="_blank"><i class="fab fa-facebook-f mr-4"></i></a></li>
                <li><a href="#" target="_blank"><i class="fab fa-instagram mr-4"></i></a></li>
                <li><a href="#" target="_blank"><i class="fab fa-twitter mr-4"></i></a></li>
                <li><a href="#" target="_blank"><i class="fab fa-youtube mr-4"></i></a></li>
            </ul>
        </div>

        <div class="header__right">

            <ul class="navigation__extra">

                <li><a href="/become-vendor">Sell on MarketPlace</a></li>
                <li><a href="/store-list">Store List</a></li>
                <li><i class="icon-telephone"></i> Hotline:<strong> 55-77-67-36-44</strong></li>

                <!-- <li>

                    <div class="ps-dropdown language"><a href="#"><img src="img/template/en.png" alt="">English</a>

                        <ul class="ps-dropdown-menu">

                            <li><a href="#"><img src="img/template/es.png" alt=""> Español</a></li>

                        </ul>

                    </div>

                </li> -->

            </ul>

        </div>

    </div>

    <div class="navigation--mobile">

        <div class="navigation__left">

            <!--=====================================
				Menu Mobile
				======================================-->

            

            <a class="ps-logo" href="/">
                <img src="img/template/logo_light.png"  alt="">
            </a>

        </div>

        <div class="navigation__right">

            <div class="header__actions">

                <!--=====================================
				Cart
				======================================-->

                <?php
                         $totalPriceSC= 0;
                         $ValorPrecioEnvio=0;
                         $preceProduct=0;
                         if (isset($_COOKIE["listSC"]) && isset($_SESSION["user"])) {
                             $shopinCard = json_decode($_COOKIE["listSC"], true);
                             if(is_array($shopinCard) && $shopinCard != NULL){
                                 foreach ($shopinCard as $key => $value) {
                                     if(is_integer($value["quantity"]) && $value["quantity"] > 0 && is_string($value["product"])){
                                         $totalSC = count($shopinCard);
                                     }else{
                                         $totalSC = 0;
                                     }
                                 }
                             }else{
                                 $totalSC = 0;
                             }
                         } else {
                             $totalSC = 0;
                         }
                    ?>

                    <?php if( is_integer($totalSC) ): ?>
                    <div class="ps-cart--mini">

                        <a class="header__extra" class="btn">
                            <i class="icon-bag2"></i><span><i class="totalWishBag"><?php echo $totalSC; ?></i></span>
                        </a>

                        <div class="ps-cart__content">

                                <div class="ps-cart__items" id="bagTok">
                                <?php if ($totalSC > 0 && isset($_SESSION["user"])) : ?>
                                    <?php foreach ($shopinCard as $key => $value) :
                                        if(is_integer($value["quantity"]) && $value["quantity"] > 0 && is_string($value["product"])):
                                            // traer productos al carrito
                                            $select = "url_product,url_category,name_product,image_product,price_product,offer_product,shipping_product,stars_product";
                                            $url = CurlController::api() . "relations?rel=products,categories&type=product,category&linkTo=url_product&equalTo=" . $value["product"] . "&select=" . $select;
                                            $method = "GET";
                                            $fields = array();
                                            $header = array();

                                            $result = CurlController::request($url, $method, $fields, $header)->result[0];

                                            $estrella="";
                                            $precioProdStar=0;
                                            $count=0;
                                            $numero = array();
                                            $EsStar = json_decode($result->stars_product);
                                            foreach($EsStar as $key2 => $value2){
                                                if($value2->idUser == $_SESSION["user"]->id_user && $value2->pagado != "pagado"){
                                                    $precioProdStar = $precioProdStar + $value2->precio;
                                                    $estrella .=  $value2->numero . ", ";
                                                    array_push($numero, $value2->numero);
                                                    $count++;
                                                }else{
                                                    array_push($numero, 0);
                                                }
                                            }
                                            $numero = json_encode($numero);
                                            if($count == 0 && isset($_COOKIE['listSC'])){
                                                echo '
                                                    <script>
                                                    let myCookie = document.cookie;
                                                    let listCookie = myCookie.split(";");
                                                    let count = 0;
                                                
                                                    for (let i in listCookie) {
                                                        var list = listCookie[i].search("listSC");
                                                        // si list es mayor a -1 es por qu se ncontro la cooki
                                                        if (list > -1) {
                                                        document.cookie = "listSC" + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
                                                        } 
                                                    }
                                                    window.location="' . TemplateController::path() . $result->url_product .'";
                                                    </script>'; 
                                                    return;
                                            }
                                    ?>

                                        <div class="ps-product--cart-mobile">

                                            <div class="ps-product__thumbnail mb-0">
                                                <a class="m-0" href="<?php echo $path . $result->url_product; ?>">
                                                    <img src="img/products/<?php echo $result->url_category; ?>/<?php echo $result->image_product; ?>" alt="<?php echo $result->name_product; ?>">
                                                </a>
                                            </div>

                                            <div class="ps-product__content m-0">
                                                <a class="ps-product__remove text-danger btn" onclick="removeBagSC('<?php echo $result->url_product; ?>','<?php echo TemplateController::path().$_SERVER['REQUEST_URI']; ?>','<?php echo $_SESSION['user']->id_user; ?>','<?php echo $numero;?>','<?php echo CurlController::api(); ?>')">
                                                <i class="fas fa-trash-alt"></i>
                                                </a>
                                                <a class="m-0" href="<?php echo $path . $result->url_product; ?>"><?php echo $result->name_product; ?></a>
                                                <p class="m-0"><strong></strong> Seture</p>
                                                <div class="small text-secondary">

                                                    <?php
                                                    // if ($value["details"] != "") {
                                                    //     echo  "<p class='mb-0'> <strong> Detalles por defecto:</strong></p>";
                                                    //     foreach (json_decode($value["details"], true) as $key => $detalle) {
                                                    //         foreach (array_keys($detalle) as $key => $list) {
                                                    //             echo '<div class="mb-0">' . $list . ': ' . array_values($detalle)[$key] . '</div>';
                                                    //         }
                                                    //     }
                                                    // }
                                                    ?>
                                                </div>
                                                <p class="m-0"><strong>Estrella: </strong><span class="envibagcl"><?php 
                                                    // if($value["quantity"] >= 3 || $totalSC >= 3 || ($value["quantity"] >= 3 && $totalSC >= 3)){
                                                    //     $ValorPrecioEnvio=0;
                                                    //     echo $ValorPrecioEnvio;
                                                    // }else{
                                                    //     $ValorPrecioEnvio= ($result->shipping_product * 1.5 )/ $value["quantity"];
                                                    //     echo $ValorPrecioEnvio;
                                                    // }
                                                    echo($estrella);
                                                ?></span></p>
                                                <small> <strong>Cantidad: </strong> <span class="<?php echo $value["product"]; ?>"><?php echo $value["quantity"]; ?></span> <strong>Precio:</strong> $
                                                    <?php
                                                        echo($precioProdStar);
                                                        $totalPriceSC += $precioProdStar;
                                                    ?>   
                                                    <?php //if ($result->offer_product != null) : ?>
                                                        <?php
                                                            //$preceProduct= TemplateController::offerPrice($result->price_product, json_decode($result->offer_product, true)[1], json_decode($result->offer_product, true)[0]); 
                                                            //echo $preceProduct; ?>
                                                    <?php //else : ?>
                                                        <?php 
                                                            //$preceProduct= $result->price_product;
                                                            //echo $preceProduct; ?>
                                                    <?php //endif; ?>

                                                    <?php 
                                                        // if(strpos($preceProduct, ",") != false){
                                                        //     $preceProduct = explode(",", $preceProduct);

                                                        //     if (!empty(array_filter($preceProduct)[1])) {
                                                        //         $priceuno = ($preceProduct[0]*1000) + $preceProduct[1] ;
                                                        //     }else{
                                                        //         $priceuno =$preceProduct;
                                                        //     }
                                                        // }else{
                                                        //     $priceuno =$preceProduct;
                                                        // }
                                                    ?>
                                                    
                                                    <?php //$totalPriceSC += $ValorPrecioEnvio + ($priceuno * $value["quantity"]); ?>
                                                </small>
                                            </div>

                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                   
                                    <?php endif; ?>
                                </div>
                            
                                <div class="ps-cart__footer" id="viewCardBag">

                                    <h3>Total:<strong>$<span class="tobagtal"> <?php echo $totalPriceSC; ?></span> </strong></h3>
                                    <figure>
                                        <a class="ps-btn" href="<?php echo $path; ?>shopingBag">Ver carrito</a>
                                        <?php if(isset($_COOKIE["listSC"]) && $_COOKIE["listSC"] != []): ?>
                                        <a class="ps-btn" href="<?php echo $path; ?>checkout">Pagar</a>
                                        <?php endif; ?>
                                    </figure>

                                </div>
                           

                        </div>

                    </div>
                    <?php endif; ?>
                <!--=====================================
                Login and Register dentro
                ======================================-->
                <?php if (isset($_SESSION["user"])) : ?>
                    <div class="ps-cart--mini">
                      		<?php if ($_SESSION["user"]->method_user == "direct" || $_SESSION["user"]->method_user == "administer" || $_SESSION["user"]->method_user == "globalAdminister") : ?>
                                <?php if ($_SESSION["user"]->picture_user == "" || $_SESSION["user"]->picture_user == "NULL") : ?>
                                    <img class="rounded-circle" style="max-width: 40px;" src="img/users/default/default.png" alt="<?php echo $_SESSION["user"]->name_user; ?>">
                                <?php else : ?>
                                    <img class="rounded-circle" style="max-width: 40px;" src="img/users/<?php echo $_SESSION["user"]->id_user; ?>/<?php echo $_SESSION["user"]->picture_user; ?>" alt="<?php echo $_SESSION["user"]->username_user; ?>">
                                <?php endif; ?>
                            <?php endif; ?>
                        <div class="ps-cart__content slidernew" style="max-width: 250px !important; right: 0 !important;">
                                <div class="ps-cart__items" id="bagTok">
								     <div class="ps-product--cart-mobile">
                                            <div class="ps-product__content m-0"> 
                                               <p>Cuenta: <a class="m-0" href="<?php echo $path; if ($_SESSION['user']->method_user == 'direct')echo 'acount&wishAcount';if ($_SESSION['user']->method_user == 'administer')echo 'acount&list-vendor';if ($_SESSION['user']->method_user == 'globalAdminister')echo 'acount&my-store';?>"><?php echo $_SESSION["user"]->displayname_user; ?></a></p>
                            					<p>Logout: <a class="m-0" href="<?php echo $path ?>acount&logout">Salir</a></p>
                                            </div>
                                        </div>          
                                </div>
                        </div>
                    </div>
                <?php else : ?>
                <!--=====================================
                Login and Register fuera
                ======================================-->

                    <div class="ps-block--user-header">
                        <div class="ps-block__left">
                        <a href="<?php echo $path ?>acount&login"><i class="icon-user"></i></a>
                        </div>
                        <div class="ps-block__right">
                            <a href="<?php echo $path ?>acount&login">Mi cuenta</a>
                            <a href="<?php echo $path ?>acount&enrollment">Registrarse</a>
                        </div>
                    </div>
                <?php endif; ?>


            </div>

        </div>

    </div>

    <!--=====================================
	Search
	======================================-->

    

</header>