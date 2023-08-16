<?php
$aleatorProduct = rand(0, ($totalProducts - 4));
$url = CurlController::api()."relations?rel=products,categories&type=product,category&orderBy=Id_product&orderMode=ASC&startAt=$aleatorProduct&endAt=2&select=url_product,default_banner_product,name_product,url_category";
$method = "GET";
$field = array();
$header = array();

$productBanner = CurlController::request($url, $method, $field, $header)->result;
?>

<div class="container-fluid preloadTrue">
    <div class="ph-item border-0">
        <div class="ph-col-6">
            <div class="ph-picture"></div>
        </div>

        <div class="ph-col-6">
            <div class="ph-picture"></div>
        </div>
    </div>
</div>


<div class="ps-promotions magin-tope preloadFalse">

    <div class="container">

        <div class="row">

            <?php foreach ($productBanner as $key => $value) : ?>
                <div class="col-md-6 col-12 ">
                    <a class="ps-collection" href="<?php echo $path . $value->url_product; ?>">
                        <img src="img/products/<?php echo $value->url_category; ?>/default/<?php echo $value->default_banner_product; ?>" alt="<?php echo $value->name_product; ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

</div><!-- End Home Promotions-->