<?php
$url10 = CurlController::api() . "relations?rel=products,categories,subcategories,stores&type=product,category,subcategory,store&linkTo=title_list_product&equalTo=" . $producter->title_list_product . "&select=id_product,url_category,image_product,name_product,url_product,price_product,offer_product,stock_product,name_store,reviews_product";
$method10 = "GET";
$field10 = array();
$header10 = array();

$newProduct = CurlController::request($url10, $method10, $field10, $header10)->result;

?>
<?php if (count($newProduct) > 1) : ?>
    <div class="ps-block--bought-toggether">

        <h4>Frecuentemente se compran juntos</h4>

        <div class="container-fluid preloadTrue">
            <div class="ph-item border-0 p-0 mt-0">
                <div class="ph-col-6">
                    <div class="ph-picture" style="height:50px"></div>
                </div>
                <div class="ph-col-6">
                    <div class="ph-row">
                        <div class="ph-col-8"></div>
                        <div class="ph-col-4 empty"></div>

                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>

                        <div class="ph-col-6"></div>
                        <div class="ph-col-6 empty"></div>

                    </div>
                </div>
            </div>
        </div>

        <div class="ps-block__content preloadFalse">

            <div class="ps-block__items">

                <!-- producto actual -->
                <div class="ps-block__item">

                    <div class="ps-product ps-product--simple">

                        <div class="ps-product__thumbnail">

                            <!-- imagen del producto -->
                            <img src="img/products/<?php echo $producter->url_category; ?>/<?php echo $producter->image_product; ?>" alt="<?php echo $producter->name_product ?>">

                            <?php
                                if (in_array($producter->url_product, $wishlist)) {
                                    echo '  <p mb-5></p>  <div class="ps-product__badge bg-danger "><i class="fas fa-heart"></i></div>';
                                }
                                ?>

                                    <div class="invisibleCorazon <?php echo $producter->url_product; ?>">
                                    <p mb-5></p>  <div class="ps-product__badge bg-danger "><i class="fas fa-heart"></i></div>
                                    </div>

                        </div>

                        <div class="ps-product__container">

                            <div class="ps-product__content">
                                <a class="ps-product__title" href="<?php echo $path . $producter->url_product ?>"><?php echo $producter->name_product ?></a>

                                <!-- precio  -->
                                <?php if ($producter->offer_product != null) : ?>
                                    <p class="ps-product__price sale text-success">$<?php

                                                                                    $price1 = TemplateController::offerPrice($producter->price_product, json_decode($producter->offer_product, true)[1], json_decode($producter->offer_product, true)[0]);
                                                                                    echo $price1;
                                                                                    ?> <del>$<?php echo $producter->price_product; ?></del></p>
                                <?php else : ?>
                                    <p class="ps-product__price">$<?php
                                                                    $price1 = $producter->price_product;
                                                                    echo $price1; ?></p>
                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- producto nuevo -->

                <?php 
                foreach ($newProduct as $key => $value) : ?>
                    <?php if ($value->id_product != $producter->id_product) : ?>
                        <div class="ps-block__item">

                            <div class="ps-product ps-product--simple">

                                <div class="ps-product__thumbnail">

                                    <!-- imagen del producto -->
                                    <img src="img/products/<?php echo $value->url_category; ?>/<?php echo $value->image_product; ?>" alt="<?php echo $value->name_product ?>">
                                    <?php
                                        if (in_array($value->url_product, $wishlist)) {
                                            echo '  <p mb-5></p>  <div class="ps-product__badge bg-danger "><i class="fas fa-heart"></i></div>';
                                        }
                                        ?>

                                            <div class="invisibleCorazon <?php echo $value->url_product; ?>">
                                            <p mb-5></p>  <div class="ps-product__badge bg-danger "><i class="fas fa-heart"></i></div>
                                            </div>
                                </div>

                                <div class="ps-product__container">

                                    <div class="ps-product__content">

                                        <a class="ps-product__title" href="<?php echo $path . $value->url_product ?>"><?php echo $value->name_product ?></a>

                                        <!-- precio  -->
                                        <?php if ($value->offer_product != null) : ?>
                                            <p class="ps-product__price sale text-success">$<?php
                                                                                            $price2 = TemplateController::offerPrice($value->price_product, json_decode($value->offer_product, true)[1], json_decode($value->offer_product, true)[0]);
                                                                                            echo $price2;
                                                                                            ?> <del>$<?php echo $value->price_product; ?></del></p>
                                        <?php else : ?>
                                            <p class="ps-product__price">$<?php
                                                                            $price2 = $value->price_product;
                                                                            echo $price2; ?></p>
                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="ps-block__item ps-block__total">
                            <?php 
                            if(strpos($price1, ",") != false){
                                $price1 = explode(",", $price1);

                                if (!empty(array_filter($price1)[1])) {
                                    $priceuno = ($price1[0]*1000) + $price1[1] ;
                                }else{
                                    $priceuno =$price1;
                                }
                            }else{
                                $priceuno =$price1;
                            }
                            ?>
                            <p>Total Precio:<strong class="text-success"> $<?php echo  $priceuno + $price2 ?></strong></p>
                          
                            <a class="ps-btn"
                            onclick="addBagCardDos('<?php echo $producter->url_product; ?>', '<?php echo $producter->url_category; ?>', '<?php echo $producter->image_product; ?>', '<?php echo $producter->name_product; ?>', '<?php echo $producter->price_product; ?>', '<?php echo $path ?>', '<?php echo CurlController::api(); ?>', this, '<?php echo $value->url_product; ?>')"
                            detailSC 
                            quantitySC
                            >Add All to cart</a>
                            
                            <a class="ps-btn ps-btn--gray ps-btn--outline btn" onclick="addWishListDos('<?php echo $producter->url_product; ?>', '<?php echo CurlController::api(); ?>', '<?php echo $value->url_product; ?>')" >Add All to whishlist</a>

                            
                        </div>
                
            </div>

        </div>

    </div>
    <?php return; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>