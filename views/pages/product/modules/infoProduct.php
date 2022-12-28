<div class="ps-product__info">

    <div class="plantilla-principal1">
                            
        <div class="quedan-estos" id="quedn"><?php echo $producter->starEnd_product - $producter->starStart_product ?></div>
        <h1 class="principal-h1">Participa y GANA!!!</h1>
        <a href="<?php echo $path . $producter->url_category; ?>">
            <h4 class="p-color"><?php echo $producter->name_category; ?></h4>
        </a>
        <div class="plantilla-secundaria">
            <div class="mr-5 ml-5"> 
                <h2 class="principal-h1"><?php echo $producter->name_product; ?></h2>
                <div class="ps-product__meta colorcute">
                    <p class="colorcute">Seture: Te Deseamos Mucha Suerte</p>

                    <div class="ps-product__rating">

                        <?php $reviews = TemplateController::calificationStars(json_decode($producter->reviews_product, true)); ?>

                        <span class="colorcute"><?php
                                if ($producter->sales_product != null) {
                                    echo $producter->sales_product;
                                } else {
                                    echo "0";
                                }
                                ?> Rascados
                        </span>

                    </div>

                </div>
            </div>
            
        </div>
        <div class="plantilla-bolas">
            <div class="item-bola">
                <p class="p-bolas">1</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola">
                <p class="p-bolas">2</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola">    
                <p class="p-bolas">3</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola">
                <p class="p-bolas">4</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola">
                <p class="p-bolas">5</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola"> 
                <p class="p-bolas">6</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola">
                <p class="p-bolas">7</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola">
                <p class="p-bolas">8</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola">
                <p class="p-bolas">9</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
            <div class="item-bola">
                <p class="p-bolas">10</p>
                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
            </div>
        </div>
    </div> 

    <div class="ps-product__shopping botonses">
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
                <a   class="btn text-danger ml-3" id="visibl-cor" onclick="addWishList('<?php echo $producter->url_product; ?>', '<?php echo CurlController::api(); ?>')">
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

   

   

</div> <!-- End Product Info -->