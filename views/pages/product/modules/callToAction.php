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

                        <a class="ps-product__title"><?php echo $producter->name_product ?></a>

                    </div>

                    <div class="ps-product__shopping">

                        <!-- precio  -->
                        <p class="ps-product__price sale text-success PresioPlantilla">De: $<?php echo $priceProduct->Presio_alt; ?> - A: $<?php echo $priceProduct->Presio_baj; ?></p>

                        <a class="ps-btn btn" 
                            onclick="addBagCard('<?php echo $producter->url_product; ?>', '<?php echo $producter->url_category; ?>', '<?php echo $producter->image_product; ?>', '<?php echo $producter->name_product; ?>', '<?php echo $producter->price_product; ?>', '<?php echo $path ?>', '<?php echo CurlController::api(); ?>', this)"
                            detailSC 
                            quantitySC
                        > Compra</a>
                    </div>

                </div>

            </article>

        </div>

    </nav>

</header>