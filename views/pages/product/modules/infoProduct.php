<div class="ps-product__info">

    <h1><?php echo $producter->name_product; ?></h1>



    <div class="ps-product__meta">

        <p>Por: <a href="shop-default.html">WeSharp</a></p>

        <div class="ps-product__rating">

            <?php $reviews = TemplateController::calificationStars(json_decode($producter->reviews_product, true)); ?>

            <select class="ps-rating" data-read-only="true">

                <!-- reseñas en estrellas -->
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

            <!-- numero de reviciones -->
            <span>(<?php
                    if ($producter->reviews_product != null) {
                        echo count(json_decode($producter->reviews_product, true));
                    } else {
                        echo "0";
                    }
                    ?> reseñas)
            </span>

            <span><?php
                    if ($producter->sales_product != null) {
                        echo $producter->sales_product;
                    } else {
                        echo "0";
                    }
                    ?> Vendidos
            </span>

        </div>

    </div>

    <!-- precio  -->
    <?php if ($producter->offer_product != null) : ?>
        <h2 class="ps-product__price sale text-success">$<?php echo TemplateController::offerPrice($producter->price_product, json_decode($producter->offer_product, true)[1], json_decode($producter->offer_product, true)[0]); ?> <del>$<?php echo $producter->price_product; ?></del></h2>
    <?php else : ?>
        <p class="ps-product__price">$<?php echo $producter->price_product; ?></p>
    <?php endif; ?>

    <div class="ps-product__desc">

        <p>

            Sold By:<a class="mr-20" href="<?php echo $path . $producter->url_store; ?>"><strong> <?php echo $producter->name_store; ?></strong></a>

            <!-- preguntr si hay stock  -->

            Status:<a><strong class="ps-tag--in-stock">
                    <?php if ($producter->stock_product > 0) : ?>
                        En stock
                    <?php else : ?>
                        Fuera de stock
                    <?php endif; ?>
                </strong></a>

        </p>

        <!-- resumen del producto  -->
        <ul class="ps-list--dot">
            <?php foreach (json_decode($producter->summary_product) as $key2 => $value2) : ?>
                <li> <?php echo $value2; ?> </li>
            <?php endforeach; ?>
        </ul>

        <!-- video del producto  -->
        <?php if ($producter->video_product != null) : ?>
            <?php $video = json_decode($producter->video_product, true); ?>
            <?php if ($video[0] == "youtube") : ?>
                <iframe src="https://www.youtube.com/embed/<?php echo $video[1]; ?>?rel=0&autoplay=0" height='360' frameborder='0' allowfullscreen></iframe>
            <?php else : ?>
                <iframe src="https://player.vimeo.com/video/<?php echo $video[1]; ?>" height="360" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    <div class="ps-product__variations">
        <!-- especificaciones del producto -->
        <?php if($producter->specifications_product != null): ?>
        <?php $spect = json_decode($producter->specifications_product, true); ?>

        <?php foreach ($spect as $key => $value) : ?>
            <?php if (!empty(array_keys($value)[0])) : ?>
                <figure>

                    <figcaption>Elige: <strong><?php echo array_keys($value)[0]; ?></strong></figcaption>
                </figure>
                    <?php endif; ?>
                    <?php foreach ($value as $key3 => $value3) : ?>
                        <?php foreach ($value3 as $key4 => $value4) : ?>
                            <?php if (array_keys($value)[0] == "Color") : ?>
                                <div class="ps-variant round-circle mr-3 details <?php echo array_keys($value)[0]; ?>" 
                                datailType= "<?php echo array_keys($value)[0]; ?>"
                                detailValue= "<?php echo $value4; ?>"
                                style="background-color:<?php echo $value4; ?>;
                                    width:30px;
                                    height:30px;
                                    cursor:pointer;
                                    border:1px solid #bbb;">
                                    <span class="ps-variant__tooltip"><?php echo $value4; ?></span>
                                </div>
                            <?php else : ?>
                                <div class="ps-variant ps-variant--size details <?php echo array_keys($value)[0]; ?>"
                                datailType= "<?php echo array_keys($value)[0]; ?>"
                                detailValue= "<?php echo $value4; ?>">
                                    <span class="ps-variant__tooltip"><?php echo $value4; ?></span>
                                    <span class="ps-variant__size"><?php echo substr($value4, 0, 3); ?></span>
                                </div>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                
            
        <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <!-- validar el tablero de ofertas -->
    <?php
    $today = date("Y-m-d");
    if ($producter->offer_product != null && $producter->stock_product != 0 && $today < date(json_decode($producter->offer_product, true)[2])) : ?>
        <div class="ps-product__countdown">

            <figure>

                <figcaption> ¡No te lo pierdas! Esta promoción caducará en</figcaption>

                <ul class="ps-countdown" data-time="<?php echo json_decode($producter->offer_product, true)[2]; ?>">

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

            </figure>

            <figure>

                <figcaption>Productos vendidos</figcaption>

                <div class="ps-product__progress-bar ps-progress" data-value="<?php echo $producter->stock_product; ?>">

                    <div class="ps-progress__value"><span></span></div>

                    <p><b><?php echo $producter->stock_product; ?>/100</b> Vendidas</p>

                </div>

            </figure>

        </div>
    <?php endif; ?>



    <div class="ps-product__shopping">

        <figure>
            <!-- controles para odificar la cantidad  de compra del carrito -->
            <figcaption>Quantity</figcaption>

            <div class="form-group--number quantity">

                <button class="up" 
                onclick="changeQualyty($('#quant0').val(), 'up', <?php echo $producter->stock_product ?>, 0)">
                    <i class="fa fa-plus"></i>
                </button>

                <button class="down" 
                onclick="changeQualyty($('#quant0').val(), 'down', <?php echo $producter->stock_product ?>, 0)">
                    <i class="fa fa-minus"></i>
                </button>

                <input 
                id="quant0"
                class="form-control" type="text" value="1" readonly>

            </div>

        </figure>

        <a class="ps-btn ps-btn--black" onclick="addBagCard('<?php echo $producter->url_product; ?>', '<?php echo $producter->url_category; ?>', '<?php echo $producter->image_product; ?>', '<?php echo $producter->name_product; ?>', '<?php echo $producter->price_product; ?>', '<?php echo $path ?>', '<?php echo CurlController::api(); ?>', this)"
        detailSC
        quantitySC
        >Add to cart</a>

        <a class="ps-btn" 
        onclick="addBagCard('<?php echo $producter->url_product; ?>', '<?php echo $producter->url_category; ?>', '<?php echo $producter->image_product; ?>', '<?php echo $producter->name_product; ?>', '<?php echo $producter->price_product; ?>', '<?php echo $path ?>', '<?php echo CurlController::api(); ?>', this), bagCkeck()"
        detailSC 
        quantitySC
        >Buy Now</a>

        <div class="ps-product__actions">

            <?php
                if (in_array($producter->url_product, $wishlist)): ?>
            <a href="<?php echo $path ?>acount&wishAcount"  class="text-danger">
            <i class="fas fa-heart"></i>
            </a>

               <?php else: ?>
                <a   class="btn text-danger" id="visibl-cor" onclick="addWishList('<?php echo $producter->url_product; ?>', '<?php echo CurlController::api(); ?>')">
                    <i class="icon-heart txt"></i>
                    </a>
               <?php endif; ?>

               <div class="invisibleCorazon <?php echo $producter->url_product; ?>">
               <a href="<?php echo $path ?>acount&wishAcount"  class="text-danger">
            <i class="fas fa-heart"></i>
            </a>
            </div>
            

        </div>

    </div>

    <div class="ps-product__specification">

        <a class="report" href="#">Report Abuse</a>

        <p><strong>SKU:</strong> SF1133569600-1</p>

        <p class="categories">

            <strong> Categories:</strong>

            <a href="<?php echo $path . $producter->url_category; ?>"><?php echo $producter->name_category; ?></a>,
            <a href="<?php echo $path . $producter->url_subcategory; ?>"><?php echo $producter->name_subcategory; ?></a>,
            <a href="<?php echo $path . $producter->title_list_product; ?>"><?php echo $producter->title_list_product; ?></a>

        </p>

        <p class="tags"><strong> Tags</strong>
            <?php
            $tags = json_decode($producter->tags_product, true);
            foreach ($tags as $key => $value) :  ?>

                <a href="<?php echo $path . $value; ?>"><?php echo $value; ?></a>
            <?php endforeach; ?>
        </p>

    </div>

    <div class="ps-product__sharing">

        <a class="facebook social-share" data-share="facebook" href="#">
            <i class="fab fa-facebook"></i>
        </a>

        <a class="twitter social-share" data-share="twitter" href="#">
            <i class="fab fa-twitter"></i>
        </a>


        <a class="linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $path.$producter->url_product ?>" target="_blank">
            <i class="fab fa-linkedin"></i>
        </a>

    </div>

</div> <!-- End Product Info -->