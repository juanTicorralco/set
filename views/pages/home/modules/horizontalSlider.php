<?php
$aleatorProduct = rand(0, ($totalProducts - 5));
$url = CurlController::api()."relations?rel=products,categories&type=product,category&orderBy=Id_product&orderMode=ASC&startAt=$aleatorProduct&endAt=5&select=horizontal_slider_product,url_category,name_product,url_product";
$method = "GET";
$field = array();
$header = array();

$productsHSlider = CurlController::request($url, $method, $field, $header)->result;
?>
<div class="container-fluid preloadTrue">


    <div class="ph-item border-0">
        <div class="ph-col-4">
            <div class="ph-row">
                <div class="ph-col-10"></div>
                <div class="ph-col-10 big"></div>
                <div class="ph-col-6 big"></div>
                <div class="ph-col-6 empty"></div>
                <div class="ph-col-6 big"></div>
            </div>
        </div>
        <div class="ph-col-8">
            <div class="ph-picture"></div>
        </div>

    </div>

</div>

<div class="ps-home-banner preloadFalse">
    <div class="ps-carousel--nav-inside owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-animate-in="fadeIn" data-owl-animate-out="fadeOut">

        <?php foreach ($productsHSlider as $key => $value) :
            $horizontalSlider = json_decode($value->horizontal_slider_product, true);
        ?>

            <div class="ps-banner--market-4" data-background="img/products/<?php echo $value->url_category; ?>/horizontal/<?php echo $horizontalSlider["IMG tag"]; ?>">
                <img src="img/products/<?php echo $value->url_category; ?>/horizontal/<?php echo $horizontalSlider["IMG tag"]; ?>" alt="<?php echo $value->name_product; ?>">
                <div class="ps-banner__content">
                    <h4> <?php echo $horizontalSlider["H4 tag"]; ?> </h4>
                    <h3> <?php echo $horizontalSlider["H3-1 tag"]; ?> <br />
                        <?php echo $horizontalSlider["H3-2 tag"]; ?> <br />
                        <p> <?php echo $horizontalSlider["H3-3 tag"]; ?> <strong> <?php echo $horizontalSlider["H3-4s tag"]; ?> </strong></p>
                    </h3>
                    <a class="ps-btn" href="<?php echo $path . $value->url_product; ?>"> <?php echo $horizontalSlider["Button tag"]; ?> </a>
                </div>
            </div>
        <?php

        endforeach;
        ?>
    </div>

</div><!-- End Home Banner-->