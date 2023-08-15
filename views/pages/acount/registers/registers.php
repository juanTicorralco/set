<?php
if (!isset($_SESSION['user'])) {
    echo '<script>
            window.location="' . $path . 'acount&login";
    </script>';
    return;
}else{
    $time= time();
    if($_SESSION["user"]->token_exp_user < $time){
        echo '<script>
        switAlert("error", "Para proteger tus datos, si no hay actividad en tu cuenta, se cierra automaticamente. Vuelve a logearte!", "' . $path . 'acount&logout","");
            
    </script>';
    return;
    }else{
        // traer la lista de deseos
        $products= array();
        $select="id_order,url_product,pago_prev_order,url_category,image_product,hour_order,name_product,name_buyer_order,phone_order,stacion_order,day_order,spesifications_order,status_order,price_order,follow_order,whats_link_order,name_product,color_stock,size_stock,color_hexa_stock,stock_out_order";
        $method= "GET";
        $header= array();
        $filds= array();
        if(isset($_GET["entregados"])){
            $url= CurlController::api()."relations?rel=orders,products,categories,stocks&type=order,product,category,stock&linkTo=status_order&equalTo=Finalizado&orderBy=day_order&orderMode=DESC&select=".$select."&token=".$_SESSION["user"]->token_user;
            $response= CurlController::request($url, $method, $header, $filds);
            if($response->status == 200){
                array_push($products, $response->result);
            }
        }else if(isset($_GET["cancelados"])){
            $url= CurlController::api()."relations?rel=orders,products,categories,stocks&type=order,product,category,stock&linkTo=status_order&equalTo=cancelado&orderBy=day_order&orderMode=DESC&select=".$select."&token=".$_SESSION["user"]->token_user;
            $response= CurlController::request($url, $method, $header, $filds);
            if($response->status == 200){
                array_push($products, $response->result);
            }
        }else{
            date_default_timezone_set('UTC');
            date_default_timezone_set("America/Mexico_City");
            $date = date("Y-m-d");
            $between1 =  date("Y-m-d",strtotime($date."- 10 days"));
            $between2 = date("Y-m-d",strtotime($date."+ 10 days"));
            $url= CurlController::api()."relations?rel=orders,products,categories,stocks&type=order,product,category,stock&linkTo=day_order&between1=".$between1."&between2=".$between2."&filterTo=status_order&inTo=Cancelado,Finalizado&not=not&select=".$select."&token=".$_SESSION["user"]->token_user;
            $response= CurlController::request($url, $method, $header, $filds);
            if($response->status == 200){
                array_push($products, $response->result);
            }
        }
    }
    //  echo '<pre>'; print_r($products); echo '</pre>'; 
    //                                      return;
}
?>
<!--=====================================
My Account Content
======================================-->
<div class="ps-vendor-dashboard pro">
    <div class="container">
        <div class="ps-section__header mt-0">
            <!--=====================================
            Profile
            ======================================-->
            <?php include "views/pages/acount/profile/profile.php"; ?>
            <!--=====================================
            Nav Account
            ======================================-->
            <div class="ps-section__content">
                <ul class="ps-section__links">
                    <?php if($_SESSION["user"]->method_user == "direct"): ?>
                    <li><a href="<?php echo $path; ?>acount&orders">Ordenes</a></li>
                    <li class="active"><a href="<?php echo $path; ?>acount&registers">Registros</a></li>
                    <li><a href="<?php echo $path; ?>acount&wishAcount">My Wishlist</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-shopping">My Shopping</a></li>
                    <?php endif; ?>
                    <?php if($_SESSION["user"]->method_user == "administer"): ?>
                    <li ><a href="<?php echo $path; ?>acount&my-shopping">My Shopping</a></li>
                    <li><a href="<?php echo $path; ?>acount&list-vendor">Lista vendidos</a></li>
                    <?php endif; ?>
                    <?php if($_SESSION["user"]->method_user == "globalAdminister"): ?>
                    <li><a href="<?php echo $path; ?>acount&my-store">My Store</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-sales">My Sales</a></li>
                    <?php endif; ?>
                </ul>

                <!--=====================================
                Wishlist
                ======================================-->
                <button class="btn btn-dark btn-lg m-3" data-toggle="modal" data-target="#registerNew">Nuevo</button>
                <a href="http://bersani.com/acount&registers?entregados" type="button" class="btn btn-success btn-lg m-3">Entregados</a>
                <a href="http://bersani.com/acount&registers?cancelados" type="button" class="btn btn-danger btn-lg m-3">Cancelados</a>
                <div class="table-responsive ">
                    <table class="table ps-table--whishlist dt-responsive dt-client pr-5">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre producto</th>
                                <th>Nombre cliente</th>
                                <th>Estacion</th>
                                <th>Hora</th>
                                <th>Color</th>
                                <th>Talla</th>
                                <th>Peso</th>
                                <th>Altura</th>
                                <th>Status</th>
                                <th>Acciones</th>
                                <th>Precio</th>
                                <th>Pago previo</th>
                                <th>Messenger</th>
                                <th>Telefono</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Product -->
                            <?php
                            if(count($products) >0):
                            foreach ($products[0] as $key => $value):?>
                                <tr >
                                    <?php
                                        if($value->stock_out_order == 0){
                                            $colorStock = "danger";
                                        }else if($value->stock_out_order == 1){
                                            $colorStock = "success";
                                        }
                                    ?>
                                    <td class="bg-<?php echo $colorStock; ?>">
                                        <div class="ps-product--cart">
                                            <div class="ps-product__thumbnail">
                                                <a href="<?php echo $path . $value->url_product; ?>">
                                                    <img src="img/products/<?php echo $value->url_category; ?>/<?php echo $value->image_product; ?>" alt="<?php echo $value->name_product; ?>">
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><div class="ps-product__content"><a href="<?php echo $path . $value->url_product; ?>"><?php echo $value->name_product; ?></a></div></td>
                                    <td><div class="ps-product__content"><?php echo $value->name_buyer_order; ?></div></td>
                                    <td><div class="ps-product__content"><?php echo $value->stacion_order; ?></div></td>
                                    <?php $hour_order= date("g:i a",strtotime($value->hour_order));?>
                                    <td><div class="ps-product__content"><?php echo $hour_order; ?></div></td>
                                    <?php $spesificationsProduct = json_decode($value->spesifications_order);
                                    if($value->color_hexa_stock == "000000"){
                                        $textColor= "#FFF";
                                    }else{
                                        $textColor= "#000";
                                    }
                                    ?>
                                    <td style="background-color: #<?php echo $value->color_hexa_stock; ?>;color: <?php echo $textColor; ?>;"><div class="ps-product__content"><?php echo $value->color_stock; ?></div></td>
                                    <td><div class="ps-product__content"><?php echo $value->size_stock; ?></div></td>
                                    <td><div class="ps-product__content"><?php echo $spesificationsProduct[0]->peso[0];?></div></td>
                                    <td><div class="ps-product__content"><?php echo $spesificationsProduct[0]->altura[0];?></div></td>
                                    <td><div class="ps-product__content"><?php echo $value->status_order; ?></div></td>
                                    <td><a href="https://wa.me/<?php //echo $value->whats_link_order ?>" target="_blank" class="btn btn-success rounded-circle mr-2"><i class='fa  fa-check-square'></i></a>
                                        <a href="https://wa.me/<?php //echo $value->whats_link_order ?>" target="_blank" class="btn btn-info rounded-circle mr-2"><i class='fa fa-pencil-alt'></i></a>
                                        <a href="https://wa.me/<?php //echo $value->whats_link_order ?>" target="_blank" class="btn btn-danger rounded-circle mr-2"><i class='fa fa-trash'></i></a>
                                    </td>
                                    <td><div class="ps-product__content"><?php echo '$'. $value->price_order; ?></div></td>
                                    <td><div class="ps-product__content"><?php echo $value->pago_prev_order; ?></div></td>
                                    <td><a href="https://www.facebook.com/messages/t/<?php echo $value->follow_order; ?>" target='_blank' class='btn btn-info rounded-circle mr-2'><i class='fa fa-eye'></i></a></td>
                                    <td><div class="ps-product__content"><?php echo $value->phone_order; ?></div></td>
                                    <?php $fecha = date("d/m", strtotime($value->day_order));  ?>
                                    <td><div class="ps-product__content"><?php echo $fecha; ?></div></td>
                                </tr>
                            <?php endforeach;  endif;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div