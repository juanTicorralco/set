<?php
$url = CurlController::api() . "subcategories?orderBy=views_subcategory&orderMode=DESC&startAt=0&endAt=6&select=url_subcategory,image_subcategory,name_subcategory";
$method = "GET";
$field = array();
$header = array();

$bestSubcategory = CurlController::request($url, $method, $field, $header)->result;
?>
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
<div class="ps-top-categories preloadFalse">

    <div class="container">

        <h3>Top Subcategorias del mes</h3>

        <div class="row">

            <?php foreach ($bestSubcategory as $key => $value) : ?>
                <div class="col-xl-2 col-lg-3 col-sm-4 col-6 ">
                    <div class="ps-block--category">
                        <a class="ps-block__overlay" href="<?php echo $path . $value->url_subcategory; ?>"></a>
                        <img src="img/subcategories/<?php echo $value->url_subcategory; ?>/<?php echo $value->image_subcategory; ?>" alt="<?php echo $path . $value->name_subcategory; ?>">
                        <p><?php echo $value->name_subcategory; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

</div><!-- End Top Categories -->