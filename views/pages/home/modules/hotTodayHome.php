<?php
/* bring all the products */
$today = date("Y-m-d");
$url = CurlController::api() . "relations?rel=products,categories&type=product,category&select=offer_product,stock_product,gallery_product,url_category,name_category,price_product,url_product,reviews_product,name_product";
$method = "GET";
$field = array();
$header = array();

$promotionToday = CurlController::request($url, $method, $field, $header)->result;
$salesProduct = $promotionToday;

foreach ($promotionToday as $key => $value) {
    /* we ask if the product bring offer and stock */
    if ($value->offer_product == null || $value->stock_product == 0) {
        unset($promotionToday[$key]);
    }

    /* We ask if the offer date has not expired */
    if ($value->offer_product != null) {
        if ($today > json_decode($value->offer_product, true)[2]) {
            unset($promotionToday[$key]);
        }
    }
}
/* if more than 10 products come to be displayed */
if (count($promotionToday) > 10) {
    $random = rand(0, (count($promotionToday) - 10));
    $promotionToday = array_slice($promotionToday, $random, 10);
}
?>

<div class="ps-deal-hot">

    <div class="container">

        <div class="row">

            <!--=====================================
            Column Deal Hot
            ======================================-->

            <div class="col-xl-9 col-12 ">

                <div class="container-fluid preloadTrue">
                    <div class="ph-item">
                        <div class="ph-col-6">
                            <div class="ph-item border-0">
                                <div class="ph-col-2">
                                    <div class="ph-picture" style="height:300px"></div>
                                </div>
                                <div class="ph-col-10">
                                    <div class="ph-picture" style="height:300px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="ph-col-6">
                            <div class="ph-row mt-5">
                                <div class="ph-col-4 big"></div>
                                <div class="ph-col-8 empty"></div>

                                <div class="ph-col-6 big"></div>
                                <div class="ph-col-8 empty"></div>

                                <div class="ph-col-8"></div>
                                <div class="ph-col-4 empty"></div>

                                <div class="ph-col-12 big"></div>

                                <div class="ph-col-6 big" style="height:70px"></div>
                                <div class="ph-col-6 empty"></div>

                                <div class="ph-col-8 big"></div>
                                <div class="ph-col-4 empty"></div>

                                <div class="ph-col-12"></div>

                                <div class="ph-col-8"></div>
                                <div class="ph-col-4 empty"></div>

                                <div class="ph-col-12 big"></div>

                                <div class="ph-col-12" style="height:70px"></div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="ps-block--deal-hot preloadFalse" data-mh="dealhot">

                    <div class="ps-block__header">

                        <h3>Ofertas del dia</h3>

                        <div class="ps-block__navigation">
                            <a class="ps-carousel__prev" href=".ps-carousel--deal-hot">
                                <i class="icon-chevron-left"></i>
                            </a>
                            <a class="ps-carousel__next" href=".ps-carousel--deal-hot">
                                <i class="icon-chevron-right"></i>
                            </a>
                        </div>

                    </div>

                    <div class="ps-product__content">

                        <div class="ps-carousel--deal-hot ps-carousel--deal-hot owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">

                            <!--=====================================
                            Product Deal Home
                            ======================================-->

                            <?php if( count( $promotionToday) > 1 ): ?>
                            <?php foreach ($promotionToday as $key => $value) :
                            ?>

                                <div class="ps-product--detail ps-product--hot-deal">

                                    <div class="ps-product__header">

                                        <div class="ps-product__thumbnail" data-vertical="true">

                                            <figure>

                                                <div class="ps-wrapper">

                                                    <div class="ps-product__gallery" data-arrow="true">
                                                        <?php
                                                        $galeriProducts = json_decode($value->gallery_product);

                                                        foreach ($galeriProducts as $key2 => $value2) :
                                                        ?>
                                                            <div class="item">
                                                                <a href="img/products/<?php echo $value->url_category; ?>/gallery/<?php echo $value2; ?>">
                                                                    <img src="img/products/<?php echo $value->url_category; ?>/gallery/<?php echo $value2; ?>" alt="<?php echo $value->name_category; ?>">
                                                                </a>
                                                            </div>

                                                        <?php endforeach; ?>

                                                    </div>

                                                    <!-- offer of product -->
                                                    <?php $offer = json_decode($value->offer_product); ?>

                                                </div>

                                            </figure>

                                            <div class="ps-product__variants" data-item="4" data-md="3" data-sm="3" data-arrow="false">
                                                <?php
                                                foreach ($galeriProducts as $key3 => $value3) :
                                                ?>
                                                    <div class="item">
                                                        <img src="img/products/<?php echo $value->url_category; ?>/gallery/<?php echo $value3; ?>" alt="<?php echo $value->name_category; ?>">
                                                    </div>
                                                <?php endforeach; ?>

                                            </div>


                                        </div>


                                        <div class="ps-product__info">

                                            <h5><?php echo $value->name_category; ?></h5>

                                            <h3 class="ps-product__name">
                                                <a href="<?php echo $path . $value->url_product; ?>">
                                                    <strong><?php echo $value->name_product; ?></strong>
                                                </a>
                                            </h3>

                                            <div class="ps-product__meta">

                                                <h4 class="ps-product__price sale">$<?php echo TemplateController::offerPrice($value->price_product, $offer[1], $offer[0]); ?> <del> <?php echo $value->price_product; ?></del></h4>

                                                <div class="ps-product__rating">

                                                    <?php $reviews = TemplateController::calificationStars(json_decode($value->reviews_product, true));
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
                                                            if ($value->reviews_product != null) {
                                                                echo count(json_decode($value->reviews_product, true));
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?> reseñas)
                                                    </span>

                                                </div>

                                                <div class="ps-product__specification">

                                                    <p>Status:<strong class="in-stock"> Disponible</strong></p>

                                                </div>

                                            </div>

                                            <div class="ps-product__expires">

                                                <p>Expira en</p>

                                                <ul class="ps-countdown" data-time="<?php echo $offer[2]; ?>">

                                                    <li><span class="days"></span>
                                                        <p>Dias</p>
                                                    </li>

                                                    <li><span class="hours"></span>
                                                        <p>Horas</p>
                                                    </li>

                                                    <li><span class="minutes"></span>
                                                        <p>Minutos</p>
                                                    </li>

                                                    <li><span class="seconds"></span>
                                                        <p>Segundos</p>
                                                    </li>

                                                </ul>

                                            </div>

                                            <div class="ps-product__processs-bar">

                                                <div class="ps-progress" data-value="<?php echo $value->stock_product; ?>">
                                                    <span class="ps-progress__value"></span>
                                                </div>

                                                <p><strong><?php echo $value->stock_product; ?>/100</strong> Vendidos</p>

                                            </div>

                                            <div class="ps-product__badge">
                                                <span>Ahorra <br> $<?php echo TemplateController::SavePrice($value->price_product, $offer[1], $offer[0]); ?></span>
                                            </div>

                                        </div>

                                    </div>

                                </div><!-- End Product Deal Hot -->
                            <?php endforeach; ?>
                            <?php else: ?>
                                <h3 class="ps-product__name">
                                 No hay ofertas el dia de hoy              
                                </h3>
                                <h3 class="ps-product__name">
                                 No hay ofertas el dia de hoy              
                                </h3>
                            <?php endif; ?>


                        </div><!-- End carousel Deal Hot -->

                    </div><!-- End product content Deal Hot -->

                </div><!-- End deal hot -->

            </div><!-- End Columns -->

            <!--=====================================
            Column Top 20 Best Seller
            ======================================-->

            <?php
            $url = CurlController::api() . "relations?rel=products,categories&type=product,category&orderBy=sales_product&orderMode=DESC&startAt=0&endAt=20&select=image_product,url_product,url_category,name_product,price_product,offer_product";
            $methos = "GET";
            $field = array();
            $header = array();

            $bestSales = CurlController::request($url, $method, $field, $header)->result;
            $topSales = array();

            /* organized blocks of 5 products */
            for ($i = 0; $i < ceil(count($bestSales) / 4); $i++) {
                array_push($topSales, array_slice($bestSales, $i * 4, 4));
            }
            ?>

            <div class="col-xl-3 col-12 ">

                <aside class="widget widget_best-sale" data-mh="dealhot">

                    <h3 class="widget-title">Top 20 Mas Vendidos</h3>

                    <div class="widget__content">

                        <!-- preload  -->
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

                            <!-- preload  -->

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

                            <!-- preload  -->

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

                            <!-- preload  -->

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

                        <div class="owl-slider preloadFalse" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">

                            <?php foreach ($topSales as $key => $value) : ?>
                                <div class="ps-product-group">

                                    <!--=====================================
                                Product
                                ======================================-->
                                    <?php foreach ($value as $key2 => $value2) :?>
                                        <div class="ps-product--horizontal">

                                            <div class="ps-product__thumbnail">

                                                <a href="<?php echo $path . $value2->url_product; ?>">
                                                    <img src="img/products/<?php echo $value2->url_category; ?>/<?php echo $value2->image_product; ?>" alt="">
                                                </a>

                                            </div>

                                            <div class="ps-product__content">

                                                <a class="ps-product__title" href="<?php echo $path . $value2->url_product; ?>"><?php echo $value2->name_product; ?></a>
                                                <?php if ($value2->offer_product != null) : ?>
                                                    <p class="ps-product__price sale">$<?php echo TemplateController::offerPrice($value2->price_product, json_decode($value2->offer_product, true)[1], json_decode($value2->offer_product, true)[0]); ?> <del>$<?php echo $value2->price_product; ?></del></p>
                                                <?php else : ?>
                                                    <p class="ps-product__price">$<?php echo $value2->price_product; ?></p>
                                                <?php endif; ?>
                                            </div>

                                        </div><!-- End Product -->
                                    <?php endforeach; ?>
                                </div><!-- End Product Group -->
                            <?php endforeach; ?>
                        </div>
                    </div>
                </aside><!-- End Aside -->
            </div><!-- End Columns -->
        </div>

    </div>

</div><!-- End Home Deal Hot -->