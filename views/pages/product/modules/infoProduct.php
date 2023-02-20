<?php $timestart=array();?>
<div class="ps-product__info">
    
        <div class="plantilla-principal1">
            <?php 
            $quedannum = 0;
            $rascnum = 0;
            foreach(json_decode($producter->stars_product) as $key => $value){
                $quedannum = $quedannum + 1;  
                $rascnum = $rascnum + 1; 
                if($value->idUser != "" || $value->idUser != NULL){
                    $quedannum = $quedannum -1;
                }  
            }
            $rascnum = $rascnum - $quedannum;
            $verify = 0;
            ?>
            <div class="quedan-estos" id="quedn"><?php echo $quedannum ?></div>
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

                            <span class="colorcute"><?php echo $rascnum;?> Rascados
                            </span>

                        </div>
                    </div>
                </div>
                
            </div>
            <?php if($producter->win_product != null ):  ?>
                <div class="plantilla-winer">
                    <div class="item-bola">
                    <img class="numero-winer" src="/views/img/fuegos1.gif" alt="star">
                    </div>
                    <div class="item-bola">
                        <h1 class="p-winer"><?php echo $producter->win_product ;?></h1>
                        <div class="contestrella">
                            <img class="numero-winer" src="/views/img/winer.png" alt="star">
                            <p class="numeroDesc">
                                <?php
                                5
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="item-bola">
                    <img class="numero-winer" src="/views/img/fuegos4.gif" alt="star">
                    </div>
                </div>
            <?php else: ?>
            <div class="plantilla-bolas">
                <?php foreach(json_decode($producter->stars_product) as $key => $value):?>
                    <div class="item-bola">
                        <p class="p-bolas"><?php echo $value->numero;?></p>
                        <?php if($value->check == "checkin"):?>
                            <form  method="POST" class="needs-validation" novalidate>
                                <input type="hidden" name="idStar" value="<?php echo $value->numero;?>">
                                <input type="hidden" name="idprod" value="<?php echo $producter->id_product;?>">
                                <input type="hidden" name="idtipe" value="checkout">
                                <input type="hidden" name="pagado" value="<?php echo $value->pagado;?>">
                                <button class="butonInter" type="submit">
                                    <div class="contestrella">
                                        <img class="numero-pedido" src="/views/img/starendsas.png" alt="star">
                                        <p class="numeroDesc">
                                            <?php
                                            if (isset($_SESSION['user'])){
                                                if($_SESSION['user']->id_user == $value->idUser){ 
                                                    array_push($timestart,$value->time);
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
                            <input type="hidden" name="pagado" value="<?php echo $value->pagado;?>">
                            <button class="butonInter" type="submit">
                                <div class="numero-pedido"><img src="/views/img/star.png" alt="star"></div>
                            </button>
                            <?php
                                $verify = new ControllerUser();
                                $verify = $verify -> verifistar();
                                $question = new ControllerUser();
                                $question -> starcheck();
                            ?>
                        </form>
                        <?php endif ?>
                    </div>
                <?php endforeach;?>
            </div>
            <?php endif; ?>
        </div> 

    <div class="ps-product__shopping botonses">
    <?php if($producter->win_product != null ):  ?>

 |  <?php else: ?>
        <?php if(isset($_SESSION['user'])): ?>
        <?php
        date_default_timezone_set('UTC');
        date_default_timezone_set("America/Mexico_City");
        $fechacount =0;
        $conterfech = 0;
        $hol = 0;
        $fechadeHoy = date("d-m-Y H:i:s");
        $fechHoy= strtotime($fechadeHoy);
        if($timestart != null || $timestart != ""){
            foreach($timestart as $key => $value){
                $tstart = strtotime($value);
                if($tstart > $fechHoy){
                    // $timestart = $value;
                    $hol = $value;
                    $fechacount++;
                }else{
                    $timestart = $value;
                }
            }
            $timestart = $hol;
            
            
            if($timestart != 0){
                $timestart = explode(" ", $timestart);
                if (!empty(array_filter($timestart)[1])) {
                    $timestart = array($timestart[1]);
                }
                $timestarter = explode(":", $timestart[0]);            
                if($timestarter[0] != null){
                    if ($timestarter[1]<10) {
                        $sumtime=60;
                    }else{
                        $sumtime=0;
                    }
                }else{
                    $sumtime=0;
                }
            }else{
                $conterfech = 1;
            }
        }
    
        $url=CurlController::api();
        $idUser=$_SESSION['user']->id_user;
        $idProduct = $producter->id_product;
        $check="checkout";
        $tokenput = $_SESSION["user"]->token_user;
        $numero = array();
        foreach(json_decode($producter->stars_product) as $key => $value){   
            array_push($numero, $value->numero);


        }
        $numero = json_encode($numero);
        $routeurl = explode("/", $_SERVER['REQUEST_URI']);
        if (!empty(array_filter($routeurl)[1])) {
            $routeurl = array($routeurl[1]);
        }
        $routeurls = TemplateController::path() . $routeurl[0];
        ?>
        <?php if($fechacount >0): ?>
            <a class="ps-btn" title="Solo podemos apartar tu estrella 5 minutos, despues de eso tu estrella volvera a estar libre.">
                Tiempo: 
                <span>0</span><span id="minutes"></span> : <span id="seconds"></span>
            </a>
            <?php
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
                        hor = (t1.getMinutes() + $sumtime) - t2.getMinutes()-1;
                        if(hor >= 60 && t2.getMinutes()<10 ){
                            hor = hor-60;
                        }

                        min= 59-t2.getSeconds();
                        
                        if(hor <= 0 && min <= 5){
                            SPAN_MINUTES.textContent = 0;
                            SPAN_SECONDS.textContent = '00';
                            let cont=0, idUser = $idUser, idProduct=$idProduct, check='checkout', numero=$numero;
                            let url = '$url'+'products?linkTo=id_product&equalTo=$idProduct&select=stars_product';
                            
                            let settings = {
                                url: url,
                                metod: 'GET',
                                timeaot: 0,
                            };
                         
                            $.ajax(settings).done(function (response) {
                                if (response.status == 200) {
                                    let stars = JSON.parse(response.result[0].stars_product);
                                   
                                    if (stars != null && stars.length > 0) {
                                        stars.forEach((list,i) => {
                                            if(numero[i] != '' || numero[i] != NULL){
                                                if(numero[i] == list.numero){
                                                    if((list.check == 'checkin') && (list.pagado != 'pagado') && (list.idUser == idUser )){
                                                        list.idUser= '';
                                                        list.check= check;
                                                        list.emailUser= '';
                                                        list.time= '';
                                                        cont++;
                                                    }   
                                                }
                                            }
                                        });
                                    }
                                    
                                    let settings = {
                                        'url': '$url' + 'products?id=$idProduct&nameId=id_product&token=$tokenput',
                                        'method': 'PUT',
                                        'timeaot': 0,
                                        'headers': {
                                          'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        'data': {
                                          'stars_product': JSON.stringify(stars),
                                        },
                                    };
                          
                                    $.ajax(settings).done(function (response) {
                                    if (response.status == 200) {
                                        switAlert('error', 'Se eliminaron tus estrellas!', null, null, 1500);
                                        window.location='$routeurls' ;
                                        return;
                                    }
                                    });
                                }
                            }); 
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
        <?php endif ?>
        <?php 
        if($verify != 1){
            if($fechacount <= 0){
                $question = new ControllerUser();
                $question -> endcheck($idUser, $idProduct, $numero); 
            }
        }
        ?>
        <?php if($fechacount >0): ?>
        <a class="ps-btn" 
        href="<?php echo $path; ?>checkout"
        detailSC 
        quantitySC
        >Buy Now</a>
        <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

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