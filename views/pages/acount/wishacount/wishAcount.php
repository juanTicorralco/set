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
        $select="url_product,url_category,name_product,image_product,price_product,offer_product,stock_product";
        $products= array();
        foreach($wishlist as $key => $value){  
            $url= CurlController::api()."relations?rel=products,categories&type=product,category&linkTo=url_product&equalTo=".$value."&select=".$select;
            $method= "GET";
            $header= array();
            $filds= array();
            $response= CurlController::request($url, $method, $header, $filds);
            array_push($products, $response->result[0]);
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
                    <li class="active"><a href="<?php echo $path; ?>acount&wishAcount">My Wishlist</a></li>
                    <li ><a href="<?php echo $path; ?>acount&my-shopping">My Shopping</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-store">My Store</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-sales">My Sales</a></li>
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
                                        <?php if ($value->offer_product != null) : ?>
                                            <p class="ps-product__price sale text-success">$<?php echo TemplateController::offerPrice($value->price_product, json_decode($value->offer_product, true)[1], json_decode($value->offer_product, true)[0]); ?> <del class="text-danger">$<?php echo $value->price_product; ?></del></p>
                                        <?php else : ?>
                                            <p class="ps-product__price text-dark">$<?php echo $value->price_product; ?></p>
                                        <?php endif; ?> 
                                    </td>

                                    <td><span class="ps-tag ps-tag--in-stock">
                                        <?php                                     
                                        if (intval($value->stock_product) != 0) : ?>
                                        <?php if ($value->offer_product != null) : ?>

                                        <div class="ps-product__badge out-stock text-success">Hay en bodega</div>
                                        <?php else : ?>
                                            <div class="ps-product__badge out-stock text-success">Hay en bodega</div>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <div class="ps-product__badge out-stock text-danger">Agotado</div>
                                        <?php endif; ?></span></td>

                                    <td>
                                        <a class="ps-btn" 
                                        onclick="addBagCard('<?php echo $value->url_product; ?>', '<?php echo $value->url_category; ?>', '<?php echo $value->image_product; ?>', '<?php echo $value->name_product; ?>', '<?php echo $value->price_product; ?>', '<?php echo $path ?>', '<?php echo CurlController::api(); ?>', this)"
                                        detailSC 
                                        quantitySC
                                        >Add to cart</a>
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