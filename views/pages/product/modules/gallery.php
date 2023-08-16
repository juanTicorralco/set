<div class="ps-product__thumbnail col-lg-5 col-12 " data-vertical="true">

    <figure>

        <div class="ps-wrapper">

            <div class="ps-product__gallery" data-arrow="true">
                <?php
                $galeriProducter = json_decode($producter->gallery_product);
                foreach ($galeriProducter as $key2 => $value2) :
                ?>
                    <div class="item">
                        <a href="img/products/<?php echo $producter->url_category; ?>/gallery/<?php echo $value2; ?>">
                            <img class="imgborder" src="img/products/<?php echo $producter->url_category; ?>/gallery/<?php echo $value2; ?>" alt="<?php echo $producter->name_category; ?>">
                        </a>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>

        <!-- video del producto  -->
        <?php if ($producter->video_product != null) : ?>
            <?php $video = json_decode($producter->video_product, true); ?>
            <?php if ($video[0] == "youtube") : ?>
                <iframe class="videoclas imgborder" src="https://www.youtube.com/embed/<?php echo $video[1]; ?>?rel=0&autoplay=0" height='360' frameborder='0' allowfullscreen></iframe>
            <?php else : ?>
                <iframe class="videoclas" src="https://player.vimeo.com/video/<?php echo $video[1]; ?>" height="360" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>
        <?php endif; ?>

    </figure>

    <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4" data-arrow="false">

        <?php
        foreach ($galeriProducter as $key3 => $value3) :
        ?>
            <div class="item">
                <img class="imgborder" src="img/products/<?php echo $producter->url_category; ?>/gallery/<?php echo $value3; ?>" alt="<?php echo $producter->name_category; ?>">
            </div>
        <?php endforeach; ?>

    </div>

</div><!-- End Gallery -->