<div class="ps-section--default">

    <div class="ps-section__header">

        <h3>Productos Relacionados</h3>

    </div>

    <div class="container-fluid preloadTrue">
        <div class="row">
            <div class="clo-xl-2 col-lg-3 clo-sm-4 col-6">
                <div class="ph-item">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                    </div>

                    <div class="ph-col-12">
                        <div class="ph-row">
                            <div class="ph-col-12 big"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clo-xl-2 col-lg-3 clo-sm-4 col-6">
                <div class="ph-item">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                    </div>

                    <div class="ph-col-12">
                        <div class="ph-row">
                            <div class="ph-col-12 big"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clo-xl-2 col-lg-3 clo-sm-4 col-6">
                <div class="ph-item">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                    </div>

                    <div class="ph-col-12">
                        <div class="ph-row">
                            <div class="ph-col-12 big"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clo-xl-2 col-lg-3 clo-sm-4 col-6">
                <div class="ph-item">
                    <div class="ph-col-12">
                        <div class="ph-picture"></div>
                    </div>

                    <div class="ph-col-12">
                        <div class="ph-row">
                            <div class="ph-col-12 big"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="ps-section__content preloadFalse">

        <div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">

            <?php foreach ($newProduct as $key => $value) : ?>
                <div class="ps-product">

                    <div class="ps-product__thumbnail">

                        <a href="<?php echo $path . $value->url_product; ?>">
                            <!-- imagen del producto -->
                            <img src="img/products/<?php echo $value->url_category; ?>/<?php echo $value->image_product; ?>" alt="<?php echo $value->name_product ?>">

                        </a>

                        <!-- porcentaje -->
                        <?php if ($value->stock_product != 0) : ?>
                            <?php if ($value->offer_product != null) : ?>

                                <div class="ps-product__badge">-<?php echo TemplateController::percentOffer($value->price_product, json_decode($value->offer_product, true)[1], json_decode($value->offer_product, true)[0]); ?>%</div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="ps-product__badge out-stock">Out Of Stock</div>
                        <?php endif; ?>

                        <?php
                                            if (in_array($value->url_product, $wishlist)) {
                                                echo '  <p mb-5></p>  <div class="ps-product__badge bg-danger mt-5 "><i class="fas fa-heart"></i></div>';
                                            }
                                            ?>

                                                <div class="invisibleCorazon <?php echo $value->url_product; ?>">
                                                <p mb-5></p>  <div class="ps-product__badge bg-danger mt-5 "><i class="fas fa-heart"></i></div>
                                                </div>

                        <ul class="ps-product__actions">

                            <li><a
                            class="btn" 
                            onclick="addBagCard('<?php echo $value->url_product; ?>', '<?php echo $value->url_category; ?>', '<?php echo $value->image_product; ?>', '<?php echo $value->name_product; ?>', '<?php echo $value->price_product; ?>', '<?php echo $path ?>', '<?php echo CurlController::api(); ?>', this)"
                            detailSC 
                            quantitySC
                            data-toggle="tooltip" data-placement="top" title="Agregar al carrito"><i class="icon-bag2"></i></a></li>
                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Quick View"><i class="icon-eye"></i></a></li>
                            <li>
                            <a class="btn" onclick="addWishList('<?php echo $value->url_product; ?>', '<?php echo CurlController::api(); ?>')" data-toggle="tooltip" data-placement="top" title="Lo deseo">
                                                <i class="icon-heart"></i>
                                            </a>
                            </li>

                        </ul>

                    </div>

                    <div class="ps-product__container"><a class="ps-product__vendor" href="<?php echo $path . $value->url_store; ?>"><?php echo $value->name_store; ?></a>
                        <div class="ps-product__content"><a class="ps-product__title" href="<?php echo $path . $value->url_product; ?>"><?php echo $value->name_product; ?></a>
                            <select class="ps-rating" data-read-only="true">

                                <!-- reseñas en estrellas -->
                                <?php $reviews = TemplateController::calificationStars(json_decode($value->reviews_product, true)); ?>
                                <?php
                                if ($reviews > 0) {
                                    for ($i = 0; $i < 5; $i++) {
                                        if ($reviews < ($i + 1)) {
                                            echo '<option value="1">' . $i + 1 . '</option>';
                                        } else {
                                            echo '<option value="2">' . $i + 1 . '</option>';
                                        }
                                    }
                                } else {
                                    echo '<option value="0">0</option>';
                                    for ($i = 0; $i < 5; $i++) {
                                        echo '<option value="1">' . $i + 1 . '</option>';
                                    }
                                }
                                ?>

                            </select>

                            <!-- precio  -->
                            <?php if ($value->offer_product != null) : ?>
                                <h2 class="ps-product__price sale text-success">$<?php echo TemplateController::offerPrice($value->price_product, json_decode($value->offer_product, true)[1], json_decode($value->offer_product, true)[0]); ?> <del>$<?php echo $value->price_product; ?></del></h2>
                            <?php else : ?>
                                <p class="ps-product__price">$<?php echo $value->price_product; ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="ps-product__content hover"><a class="ps-product__title" href="<?php echo $path . $value->url_product; ?>"><?php echo $value->name_product; ?></a>
                            <!-- precio  -->
                            <?php if ($value->offer_product != null) : ?>
                                <h2 class="ps-product__price sale text-success">$<?php echo TemplateController::offerPrice($value->price_product, json_decode($value->offer_product, true)[1], json_decode($value->offer_product, true)[0]); ?> <del>$<?php echo $value->price_product; ?></del></h2>
                            <?php else : ?>
                                <p class="ps-product__price">$<?php echo $value->price_product; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>



        </div>
    </div>
</div> <!-- End Related products -->