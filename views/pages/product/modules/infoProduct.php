<?php $timestart=array();?>
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
                    <!-- precio  -->
                    <?php $priceProduct = json_decode($producter->price_product);?>
                    <p class="PresioPlantilla">De: $<?php echo $priceProduct->Presio_alt; ?> - A: $<?php echo $priceProduct->Presio_baj; ?></p>
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
            <?php foreach(json_decode($producter->stars_product) as $key => $value):?>
                <div class="item-bola">
                    <p class="p-bolas"><?php echo $value->numero;?></p>
                    <?php if($value->check == "checkin"):
                        array_push($timestart,$value->time);?>
                        <form  method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="idStar" value="<?php echo $value->numero;?>">
                            <input type="hidden" name="idprod" value="<?php echo $producter->id_product;?>">
                            <input type="hidden" name="idtipe" value="checkout">
                            <button class="butonInter" type="submit">
                                <div class="contestrella">
                                    <img class="numero-pedido" src="/views/img/starendsas.png" alt="star">
                                    <p class="numeroDesc">
                                        <?php
                                        if (isset($_SESSION['user'])){
                                            if($_SESSION['user']->id_user == $value->idUser){ 
                                                echo "$".$value->precio;
                                            }else{
                                                echo "X";
                                            }
                                        }else{
                                            echo "X";
                                        }
                                        ?>
                                    </p>
                                </div>
                            </button>
                            <?php
                                $question = new ControllerUser();
                                $question -> starcheck();
                            ?>
                        </form>
                    <?php else:?>
                        <form  method="POST" class="needs-validation nome" novalidate>
                        <input type="hidden" name="idStar" value="<?php echo $value->numero;?>">
                        <input type="hidden" name="idprod" value="<?php echo $producter->id_product;?>">
                        <input type="hidden" name="idtipe" value="checkin">
                        <button class="butonInter" type="submit">
                            <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
                        </button>
                        <?php
                            $question = new ControllerUser();
                            $question -> starcheck();
                        ?>
                    </form>
                    <?php endif ?>
                </div>
            <?php endforeach;?>
        </div>
    </div> 

    <div class="ps-product__shopping botonses">
        <?php
        date_default_timezone_set('UTC');
        date_default_timezone_set("America/Mexico_City");
        $fechacount =0;
        $fechadeHoy = date("d-m-Y H:i:s");
        $fechHoy= strtotime($fechadeHoy);
        foreach($timestart as $key => $value){
            $tstart = strtotime($value);
            if($tstart > $fechHoy){
                $timestart = $value;
                $fechacount++;
            }
         }
        ?>
        <?php if($fechacount >0): ?>
            <a class="ps-btn" title="Solo podemos apartar tu estrella 5 minutos, despues de eso tu estrella volvera a estar libre.">
                Tiempo: 
                <span>0</span><span id="minutes"></span> : <span id="seconds"></span>
            </a>
            <?php
                $timestart = explode(" ", $timestart);
                if (!empty(array_filter($timestart)[1])) {
                    $timestart = array($timestart[1]);
                }
                echo "
                <script>
                    const SPAN_MINUTES = document.querySelector('span#minutes');
                    const SPAN_SECONDS = document.querySelector('span#seconds');
                    const MILLISECONDS_OF_A_SECOND = 1000;
                
                    function updateCountdown() {
                        var hora1 = ('$timestart[0]').split(':'),
                        t1 = new Date(),
                        t2 = new Date(),
                        hor=0, min=0;
                    
                        t1.setHours(hora1[0], hora1[1], hora1[2]);
                        hor = t1.getMinutes()-t2.getMinutes()-1;
                        min= 60-t2.getSeconds();
                        if(hor < 0 ){
                            SPAN_MINUTES.textContent = 0;
                            SPAN_SECONDS.textContent = '00';
                        }else{
                            SPAN_MINUTES.textContent = hor;
                            SPAN_SECONDS.textContent = min;
                        }
                    }

                    updateCountdown();
                    setInterval(updateCountdown, MILLISECONDS_OF_A_SECOND);
                </script>
                ";    
            ?>
        <?php endif; ?>
        
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