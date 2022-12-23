<?php
$url = CurlController::api() . "categories?orderBy=views_category&orderMode=DESC&startAt=0&endAt=6&select=name_category,id_category,url_category";
$method = "GET";
$field = array();
$header = array();

$bestcategory = CurlController::request($url, $method, $field, $header)->result;
?>

<div class="container-fluid preloadTrue">
    <div class="ph-item">
        <div class="ph-col-2">
            <div class="ph-row">
                <div class="ph-col-12 big"></div>
                <div class="ph-col-12 empty"></div>
                <div class="ph-col-12 empty"></div>
                <div class="ph-col-8"></div>
                <div class="ph-col-4 empty"></div>
                <div class="ph-col-12 empty"></div>
                <div class="ph-col-12"></div>
                <div class="ph-col-12 empty"></div>
                <div class="ph-col-12"></div>
                <div class="ph-col-12 empty"></div>
                <div class="ph-col-12"></div>
                <div class="ph-col-12 empty"></div>
                <div class="ph-col-12"></div>
                <div class="ph-col-12 empty"></div>
                <div class="ph-col-12"></div>
            </div>
        </div>
        <div class="ph-col-2">
        <div class="ph-picture" style="height:500px"></div>
        </div>
        <div class="ph-col-8">
        <div class="ph-picture" style="height:500px"></div>
        </div>
    </div>
</div>

<div class="ps-section--gray preloadFalse">

    <div class="container">

        <!--=====================================
        Products of category
        ======================================-->

        <?php foreach ($bestcategory as $key => $value) : ?>
            <div class="ps-block--products-of-category">

                <!--=====================================
                Menu subcategory
                ======================================-->

                <div class="ps-block__categories">

                    <h3><?php echo $value->name_category; ?></h3>

                    <ul>

                        <?php
                        $url = CurlController::api() . "subcategories?linkTo=id_category_subcategory&equalTo=" . $value->id_category . "&select=url_subcategory,name_subcategory";
                        $method = "GET";
                        $field = array();
                        $header = array();

                        $subcategoryAll = CurlController::request($url, $method, $field, $header)->result;

                        foreach ($subcategoryAll as $key2 => $value2) :
                        ?>
                            <li><a href="<?php echo $path . $value2->url_subcategory; ?>"><?php echo $value2->name_subcategory; ?></a></li>
                        <?php endforeach; ?>
                    </ul>

                    <a class="ps-block__more-link" href="<?php echo $path . $value->url_category; ?>">Ver todo</a>

                </div>

                <!--=====================================
                Vertical Slider Category
                ======================================-->
                <?php
                $url = CurlController::api() . "products?linkTo=id_category_product&equalTo=" . $value->id_category . "&orderBy=views_product&orderMode=DESC&startAt=0&endAt=6&select=url_product,vertical_slider_product,name_product,image_product,offer_product,reviews_product,stock_product,price_product";
                $method = "GET";
                $field = array();
                $header = array();

                $bestProduct = CurlController::request($url, $method, $field, $header)->result;
                ?>
                <div class="ps-block__slider">

                    <div class="ps-carousel--product-box owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="7000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="500" data-owl-mousedrag="off">

                        <?php foreach ($bestProduct as $key3 => $value3) :
                        ?>
                            <a href="<?php echo $path . $value3->url_product; ?>">
                                <img src="img/products/<?php echo $value->url_category; ?>/vertical/<?php echo $value3->vertical_slider_product; ?>" alt="<?php echo $value3->name_product; ?>">
                            </a>
                        <?php endforeach; ?>

                    </div>

                </div>

                <!--=====================================
                Block Product Box
                ======================================-->

                <div class="ps-block__product-box">

                    <!--=====================================
                    Product Simple
                    ======================================-->

                    <?php foreach ($bestProduct as $key3 => $value3) : ?>
                        <div class="ps-product ps-product--simple">

                            <div class="ps-product__thumbnail">

                                <a href="<?php echo $path . $value3->url_product; ?>">
                                    <img src="img/products/<?php echo $value->url_category; ?>/<?php echo $value3->image_product; ?>" alt="<?php echo $value3->name_product; ?>">
                                </a>

                                <?php if ($value3->stock_product != 0) : ?>
                                    <?php if ($value3->offer_product != null) : ?>

                                        <div class="ps-product__badge">-<?php echo TemplateController::percentOffer($value3->price_product, json_decode($value3->offer_product, true)[1], json_decode($value3->offer_product, true)[0]); ?>%</div>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <div class="ps-product__badge out-stock">Fuera de Stock</div>
                                <?php endif; ?>

                            </div>

                            <div class="ps-product__container">

                                <div class="ps-product__content" data-mh="clothing">

                                    <a class="ps-product__title" href="<?php echo $path . $value3->url_product; ?>"><?php echo $value3->name_product; ?></a>

                                    <div class="ps-product__rating">

                                        <?php $reviews = TemplateController::calificationStars(json_decode($value3->reviews_product, true));
                                        ?>

                                        <select class="ps-rating" data-read-only="true">

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

                                        <span>(<?php
                                                if ($value3->reviews_product != null) {
                                                    echo count(json_decode($value3->reviews_product, true));
                                                } else {
                                                    echo "0";
                                                }
                                                ?> reseñas)</span>

                                    </div>
                                    <?php if ($value3->offer_product != null) : ?>
                                        <p class="ps-product__price sale">$<?php echo TemplateController::offerPrice($value3->price_product, json_decode($value3->offer_product, true)[1], json_decode($value3->offer_product, true)[0]); ?> <del>$<?php echo $value3->price_product; ?></del></p>
                                    <?php else : ?>
                                        <p class="ps-product__price">$<?php echo $value3->price_product; ?></p>
                                    <?php endif; ?>
                                </div>

                            </div>

                        </div> <!-- End Product Simple -->
                    <?php endforeach; ?>

                </div><!-- End Block Product Box -->

            </div><!-- End Products of category -->
        <?php endforeach; ?>

    </div><!-- End Container-->

</div><!-- End Section Gray-->