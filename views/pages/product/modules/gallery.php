<div class="ps-product__thumbnail col-lg-5 col-12 " data-vertical="true">

    <figure>

        <div class="ps-wrapper">
            <?php if ($producter->stock_product != 0) : ?>
                <?php if ($producter->offer_product != null) : ?>

                    <div class="ps-product__badge text-light p-2 rounded-pill font-weight-bold">-<?php echo TemplateController::percentOffer($producter->price_product, json_decode($producter->offer_product, true)[1], json_decode($producter->offer_product, true)[0]); ?>%</div>
                <?php endif; ?>
            <?php else : ?>
                <div class="ps-product__badge out-stock text-danger p-2 rounded-pill font-weight-bold">Fuera de stock</div>
            <?php endif; ?>

            <div class="ps-product__gallery" data-arrow="true">
                <?php
                $galeriProducter = json_decode($producter->gallery_product);
                foreach ($galeriProducter as $key2 => $value2) :
                ?>
                    <div class="item">
                        <a href="img/products/<?php echo $producter->url_category; ?>/gallery/<?php echo $value2; ?>">
                            <img src="img/products/<?php echo $producter->url_category; ?>/gallery/<?php echo $value2; ?>" alt="<?php echo $producter->name_category; ?>">
                        </a>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </figure>

    <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4" data-arrow="false">

        <?php
        foreach ($galeriProducter as $key3 => $value3) :
        ?>
            <div class="item">
                <img src="img/products/<?php echo $producter->url_category; ?>/gallery/<?php echo $value3; ?>" alt="<?php echo $producter->name_category; ?>">
            </div>
        <?php endforeach; ?>

    </div>

</div><!-- End Gallery -->