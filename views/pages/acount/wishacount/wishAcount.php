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
        $select="url_product,url_category,name_product,image_product,price_product,offer_product,stock_product,stars_product";
        $products= array();
        foreach($wishlist as $key => $value){  
            $url= CurlController::api()."relations?rel=products,categories&type=product,category&linkTo=url_product&equalTo=".$value."&select=".$select;
            $method= "GET";
            $header= array();
            $filds= array();
            $response= CurlController::request($url, $method, $header, $filds);
            if($response->status == 200){
                array_push($products, $response->result[0]);
            }
        }
    }
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
                    <li class="active"><a href="<?php echo $path; ?>acount&wishAcount">My Wishlist</a></li>
                    <li ><a href="<?php echo $path; ?>acount&my-shopping">My Shopping</a></li>
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

                <div class="table-responsive ">

                    <table class="table ps-table--whishlist dt-responsive dt-client pr-5">

                        <thead>

                            <tr>

                                <th>Nombre Producto</th>

                                <th>Precio</th>

                                <th>Stock</th>

                                <th></th>

                                <th></th>

                            </tr>

                        </thead>

                        <tbody>

                            <!-- Product -->

                            <?php
                           foreach ($products as $key => $value):?>

                                <tr >

                                    <td>
                                        <div class="ps-product--cart">
                                            <div class="ps-product__thumbnail">
                                                <a href="<?php echo $path . $value->url_product; ?>">
                                                    <img src="img/products/<?php echo $value->url_category; ?>/<?php echo $value->image_product; ?>" alt="<?php echo $value->name_product; ?>">
                                                </a>
                                            </div>
                                            <div class="ps-product__content"><a href="<?php echo $path . $value->url_product; ?>"><?php echo $value->name_product; ?></a></div>
                                        </div>
                                    </td>

                                    <td>  
                                        <!-- precio  -->
                                        <?php $priceProduct = json_decode($value->price_product);?>
                                        <p class="PresioPlantilla text-success">De: $<?php echo $priceProduct->Presio_alt; ?> - A: $<?php echo $priceProduct->Presio_baj; ?></p>
                                    </td>

                                    <td><span class="ps-tag ps-tag--in-stock">
                                    <?php 
                                    $quedannum = 0;
                                    foreach(json_decode($value->stars_product) as $key2 => $value2){
                                        $quedannum = $quedannum + 1;
                                        if($value2->idUser != "" || $value2->idUser != NULL){
                                            $quedannum = $quedannum -1;
                                        }  
                                    }
                                    ?>
                                        <?php                                     
                                        if ($quedannum > 0) : ?>
                                            <div class="ps-product__badge out-stock text-success"><?php echo $quedannum; ?> Sin rascar</div>
                                        <?php else : ?>
                                            <div class="ps-product__badge out-stock text-danger">Agotado</div>
                                        <?php endif; ?></span></td>

                                    <td>
                                        <a class="ps-btn" 
                                        href="<?php echo $path . $value->url_product; ?>"
                                        >Rascar</a>
                                    </td>
                                    <td>
                                        <a  class="text-danger btn basura-wislist" onclick="removeWishlist('<?php echo $value->url_product; ?>', '<?php echo CurlController::api(); ?>', '<?php echo $path; ?>' )"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                            
                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>

</div>