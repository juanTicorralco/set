<header class="header header--product header--sticky" data-sticky="true">

    <nav class="navigation">

        <div class="container">

            <article class="ps-product--header-sticky">

                <div class="ps-product__thumbnail">
                    <!-- imagen del producto -->
                    <img src="img/products/<?php echo $producter->url_category; ?>/<?php echo $producter->image_product; ?>" alt="<?php echo $producter->name_product ?>">

                </div>

                <div class="ps-product__wrapper">

                    <div class="ps-product__content">

                        <a class="ps-product__title" href="#"><?php echo $producter->name_product ?></a>

                    </div>

                    <div class="ps-product__shopping">

                        <!-- precio  -->
                        <?php if ($producter->offer_product != null) : ?>
                            <p class="ps-product__price sale text-success">$<?php echo TemplateController::offerPrice($producter->price_product, json_decode($producter->offer_product, true)[1], json_decode($producter->offer_product, true)[0]); ?> <del>$<?php echo $producter->price_product; ?></del></p>
                        <?php else : ?>
                            <p class="ps-product__price">$<?php echo $producter->price_product; ?></p>
                        <?php endif; ?>

                        <a class="ps-btn btn" 
                            onclick="addBagCard('<?php echo $producter->url_product; ?>', '<?php echo $producter->url_category; ?>', '<?php echo $producter->image_product; ?>', '<?php echo $producter->name_product; ?>', '<?php echo $producter->price_product; ?>', '<?php echo $path ?>', '<?php echo CurlController::api(); ?>', this)"
                            detailSC 
                            quantitySC
                        > Add to Cart</a>
                    </div>

                </div>

            </article>

        </div>

    </nav>

</header>