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
                    $url = CurlController::api() . "products?linkTo=id_category_product&equalTo=" . $value->id_category . "&orderBy=views_product&orderMode=DESC&startAt=0&endAt=6&select=url_product,vertical_slider_product,name_product,image_product,offer_product,reviews_product,stock_product,price_product,description_product,starEnd_product,starStart_product,stars_product";
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

               

                    <!--=====================================
                    Product Simple
                    ======================================-->
                    <?php $bestProduct2= $bestProduct[0]; ?>
                    <?php 
                        $quedannum = 0;
                        foreach(json_decode($bestProduct2->stars_product) as $key4 => $value4){
                            $quedannum = $quedannum + 1;  
                            if($value4->idUser != "" || $value4->idUser != NULL){
                                $quedannum = $quedannum -1;
                            }  
                        }
                    ?>
                    <div class="plantilla-principal">
                            
                        <div class="quedan-estos" id="quedn"><?php echo $quedannum ?></div>
                        <h1 class="principal-h1">Participa y GANA!!!</h1>
                        <a href="<?php echo $path . $value->url_category; ?>">
                            <h4 class="p-color"><?php echo $value->name_category; ?></h4>
                        </a>
                        <div class="plantilla-secundaria">
                            <div class="mr-5 ml-5"> 
                                <a href="<?php echo $path . $bestProduct2->url_product; ?>">
                                    <h2 class="principal-h1"><?php echo $bestProduct2->name_product; ?></h2>
                                </a>
                                <p class="p-color"><?php echo $bestProduct2->description_product; ?></p>
                            </div>
                            <div class="mr-5 ml-5">
                                <a href="<?php echo $path . $bestProduct2->url_product; ?>">
                                    <img class="imagen-baja" src="img/products/<?php echo $value->url_category; ?>/<?php echo $bestProduct2->image_product; ?>" alt="<?php echo $bestProduct2->name_product; ?>">
                                </a>
                            </div>
                        </div>
                        <div class="plantilla-bolas">
                        <?php foreach(json_decode($bestProduct2->stars_product) as $key5 => $value5):?>
                        
                                <?php if($value5->check == "checkin"):?>
                                    <div class="item-bola">
                                        <p class="p-bolas"><?php echo $value5->numero;?></p>
                                        <div class="contestrella">
                                            <div class="numero-pedido"><img src="/views/img/starendsas.png" alt="star"></div>
                                            <p class="numeroDesc">X</p>
                                        </div>
                                    </div>
                                <?php else:?>
                                <div class="item-bola">
                                    <p class="p-bolas"><?php echo $value5->numero;?></p>
                                    <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
                                </div>
                                <?php endif ?>t
                           
                        <?php endforeach; ?>
                        </div>
                    </div> 
                    
                    <!-- End Product Simple -->

            </div><!-- End Products of category -->
        <?php endforeach; ?>

    </div><!-- End Container-->

</div><!-- End Section Gray-->