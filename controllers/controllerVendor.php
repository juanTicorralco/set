<?php
class ControllerVendor{
    public function newVendor(){
        if(isset($_POST["nameStore"])){
            if(preg_match('/^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["nameStore"]) &&
                preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,10000}$/', $_POST["infoStore"] &&
                preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["cityStore"]) &&
                preg_match('/^[-\\(\\)\\0-9 ]{1,}$/', $_POST["phoneOrder"]) &&
                preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["addresStore"]))
            ){

                if(
                    isset($_FILES['logoStore']["tmp_name"]) &&
                    !empty($_FILES['logoStore']["tmp_name"]) &&
                    isset($_FILES['portStore']["tmp_name"]) &&
                    !empty($_FILES['portStore']["tmp_name"]) 
                    ){

                        $imageLogo = $_FILES['logoStore'];
                        $folderLogo = "img/stores";
                        $pathLogo = $_POST['urlStore'];
                        $widthLogo = 270;
                        $heigthLogo = 270;
                        $nameLogo = "logo";

                        $saveImageLogo = TemplateController::AlmacenPhoto($imageLogo, $folderLogo, $pathLogo, $widthLogo, $heigthLogo, $nameLogo);
                        if($saveImageLogo != 'error'){

                            $imagePort = $_FILES['portStore'];
                            $folderPort = "img/stores";
                            $pathPort = $_POST['urlStore'];
                            $widthPort = 1424;
                            $heigthPort = 768;
                            $namePort = "portada";

                            $saveImagePort = TemplateController::AlmacenPhoto($imagePort, $folderPort, $pathPort, $widthPort, $heigthPort, $namePort);
                            if($saveImagePort != 'error'){

                                $sosialNetwork=array();
                                $mapaStore=array();

                                if(isset($_POST["facebookStore"]) && !empty($_POST["facebookStore"])){
                                    array_push($sosialNetwork,["facebook" => "https://www.facebook.com/".$_POST["facebookStore"]]);
                                }
                                if(isset($_POST["youtubeStore"]) && !empty($_POST["youtubeStore"])){
                                    array_push($sosialNetwork,["youtube" => "https://www.youtube.com/".$_POST["youtubeStore"]]);
                                }
                                if(isset($_POST["instagramStore"]) && !empty($_POST["instagramStore"])){
                                    array_push($sosialNetwork,["instagram" => "https://www.instagram.com/".$_POST["instagramStore"]]);
                                }
                                if(isset($_POST["twitterStore"]) && !empty($_POST["twitterStore"])){
                                    array_push($sosialNetwork,["twitter" => "https://twitter.com/".$_POST["twitterStore"]]);
                                }

                                if($sosialNetwork > 0){
                                    $sosialNetwork = json_encode($sosialNetwork);
                                }else{
                                    $sosialNetwork = null;
                                }

                                if(isset($_POST["mapStore"])){
                                    array_push($mapaStore, explode(",", $_POST["mapStore"])[0] ,explode(",", $_POST["mapStore"])[1]);
                                }else{
                                    $mapaStore=null;
                                }

                                date_default_timezone_set('UTC');
                                date_default_timezone_set("America/Mexico_City");

                                $dateCreated = date("Y-m-d");
                                
                                $dataStore = array(
                                    "id_user_store" => $_SESSION["user"]->id_user,
                                    "name_store" => TemplateController::capitalize( $_POST["nameStore"]),
                                    "url_store" => $_POST["urlStore"],
                                    "logo_store" => $saveImageLogo,
                                    "cover_store" => $saveImagePort,
                                    "about_store" => $_POST["infoStore"],
                                    "abstract_store" => substr($_POST["infoStore"],0,100)."...",
                                    "email_store" => $_POST["emailStore"],
                                    "country_store" => explode("_", $_POST["countryStore"])[0],
                                    "city_store" => $_POST["cityStore"],
                                    "phone_store" => explode("_", $_POST["countryStore"])[1]."_".$_POST["phoneOrder"],
                                    "address_store" => $_POST["addresStore"],
                                    "map_store" =>  json_encode($mapaStore),
                                    "socialnetwork_store" => $sosialNetwork,
                                    "products_store" => 1,
                                    "date_created_store" => $dateCreated
                                );

                               $url = CurlController::api()."stores?token=".$_SESSION["user"]->token_user;
                               $method = "POST";
                               $fields = $dataStore;
                               $header = array(
                                "Content-Type" => "application/x-www-form-urlencoded"
                                );
                                $saveStore = CurlController::request($url,$method,$fields,$header);
                                if($saveStore->status == "200"){
                                    $saveProduct = ControllerVendor::newProduct($saveStore->result->idlast);
                                }else{
                                    echo '
                                        <script>
                                            formatearAlertas();
                                            notiAlert(3, "Error: al guardar tienda");
                                        </script>'; 
                                    return;
                                }

                            }else{
                                echo '
                                    <script>
                                        formatearAlertas();
                                        notiAlert(3, "Error: al salvar la portada");
                                    </script>'; 
                                return;
                            }

                        }else{
                            echo '
                                <script>
                                    formatearAlertas();
                                    notiAlert(3, "Error: al salvar el logo");
                                </script>';    
                            return;     
                        }
                }else{
                    echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: los archivos de imagen no son los indicados");
                        </script>'; 
                    return;
                }

            }else{
                echo '
                    <script>
                        formatearAlertas();
                        notiAlert(3, "Error: en la sintaxis de los campos");
                    </script>'; 
                return;
            }
        }
    }
    
    static public function newProduct($idStore){
        if(isset($_POST["nameProduct"])){
            if(preg_match('/^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["nameProduct"])){
                if(isset($_POST["inputSummary"])){
                   $inputSummary = array();
                   for($i=0; $i < $_POST["inputSummary"]; $i++){
                        array_push($inputSummary, $_POST["summaryProduct_".$i]);
                   }
                }
                if(isset($_POST["inputDetails"])){
                    $inputDetails = array();
                   for($i=0; $i < $_POST["inputDetails"]; $i++){
                        $inputDetails[$i] = (object)["title"=> $_POST["detailsTitleProduct_".$i],"value"=> $_POST["detailsValueProduct_".$i]];
                   }
                }
                if(isset($_POST["inputEspesifications"])){
                    $inputEspecific = array();
                    for($i=0; $i < $_POST["inputEspesifications"]; $i++){
                        $inputEspecific[$i] = (object)[ $_POST["EspesificTypeProduct_".$i] => explode(",", $_POST["EspesificValuesProduct_".$i])];
                   }
                   $inputEspecific = json_encode($inputEspecific);
                   if($inputEspecific == '[{"":[""]}]'){
                    $inputEspecific = null;
                   }
                }else{
                    $inputEspecific = null;
                }
                if(isset($_FILES["logoProduct"]["tmp_name"])&& !empty($_FILES["logoProduct"]["tmp_name"])){
                    $image = $_FILES['logoProduct'];
                    $folder = "img/products";
                    $path = explode("_", $_POST['categoryProduct'])[1];
                    $width = 300;
                    $heigth = 300;
                    $name = $_POST["urlProduct"];

                    $saveImagePortProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);
                    if($saveImagePortProduct == 'error'){
                        echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: al salvar la portada del producto");
                            </script>'; 
                            return;
                    }
                }else{
                    echo '
                    <script>
                        formatearAlertas();
                        notiAlert(3, "Error: al salvar la portada del producto");
                    </script>'; 
                    return;
                }

                if(isset($_POST["galeryProduct"])&& !empty($_POST["galeryProduct"])){ 
                    $galeryArrayProduct = array();
                    $count = 0;
                    foreach(json_decode($_POST["galeryProduct"], true) as $key => $value){
                        $count++;
                        $image["tmp_name"] = $value["file"];
                        $image["type"] = $value["type"];
                        $image["mode"] = "base64";
                        $folder = "img/products";
                        $path = explode("_", $_POST['categoryProduct'])[1]."/gallery";
                        $width = $value["width"];
                        $heigth = $value["height"];
                        $name = mt_rand(10000,99999);

                        $saveImagegaleryProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);
                        array_push($galeryArrayProduct, $saveImagegaleryProduct);
                    }
                    if(count($galeryArrayProduct) == $count){
                        if(isset($_FILES["topBanner"]["tmp_name"]) && !empty($_FILES["topBanner"]["tmp_name"])){
                            $image = $_FILES["topBanner"];
                            $folder = "img/products";
                            $path = explode("_", $_POST['categoryProduct'])[1]."/top";
                            $width = 1920;
                            $heigth = 80;
                            $name = mt_rand(10000,99999);
    
                            $saveImagetopBanerProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);

                            if($saveImagetopBanerProduct != "error"){

                                if(
                                    isset($_POST["topBannerH3Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerH3Tag"]) &&
                                    isset($_POST["topBannerP1Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerP1Tag"]) &&
                                    isset($_POST["topBannerH4Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerH4Tag"]) &&
                                    isset($_POST["topBannerP2Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerP2Tag"]) &&
                                    isset($_POST["topBannerSpanTag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerSpanTag"]) &&
                                    isset($_POST["topBannerButtonTag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerButtonTag"]) 
                                ){
                                    $topbannerProduct = (object)[
                                        "H3 tag" => TemplateController::capitalize($_POST["topBannerH3Tag"]),
                                        "P1 tag" => TemplateController::capitalize($_POST["topBannerP1Tag"]),
                                        "H4 tag" => TemplateController::capitalize($_POST["topBannerH4Tag"]),
                                        "P2 tag" => TemplateController::capitalize($_POST["topBannerP2Tag"]),
                                        "Span tag" => TemplateController::capitalize($_POST["topBannerSpanTag"]),
                                        "Button tag" => TemplateController::capitalize($_POST["topBannerButtonTag"]),
                                        "IMG tag" => $saveImagetopBanerProduct
                                    ];
                                }else{
                                    echo '
                                        <script>
                                            formatearAlertas();
                                            notiAlert(3, "Error: en la sintaxis de los campos");
                                        </script>'; 
                                    return;
                                }
                            }
                        }else{
                            echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: al salvar el top banner");
                            </script>'; 
                            return;
                        }

                        if(isset($_FILES["DefaultBanner"]["tmp_name"]) && !empty($_FILES["DefaultBanner"]["tmp_name"])){
                            $image = $_FILES["DefaultBanner"];
                            $folder = "img/products";
                            $path = explode("_", $_POST['categoryProduct'])[1]."/default";
                            $width = 570;
                            $heigth = 210;
                            $name = mt_rand(10000,99999);
    
                            $saveImagedefaultBanerProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);
                            if($saveImagedefaultBanerProduct == "error"){
                                echo '
                                <script>
                                    formatearAlertas();
                                    notiAlert(3, "Error: al salvar el default banner");
                                </script>'; 
                                return;
                            }
                        }else{
                            echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: al salvar el default banner");
                            </script>'; 
                            return;
                        }

                        if(isset($_FILES["hSlider"]["tmp_name"]) && !empty($_FILES["hSlider"]["tmp_name"])){
                            $image = $_FILES["hSlider"];
                            $folder = "img/products";
                            $path = explode("_", $_POST['categoryProduct'])[1]."/horizontal";
                            $width = 1920;
                            $heigth = 358;
                            $name = mt_rand(10000,99999);
    
                            $saveImageSliderProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);

                            if($saveImageSliderProduct != "error"){
                                if(
                                    isset($_POST["hSliderH4Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH4Tag"]) &&
                                    isset($_POST["hSliderH3_1Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH3_1Tag"]) &&
                                    isset($_POST["hSliderH3_2Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH3_2Tag"]) &&
                                    isset($_POST["hSliderH3_3Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH3_3Tag"]) &&
                                    isset($_POST["hSliderH3_4Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH3_4Tag"]) &&
                                    isset($_POST["hSliderButtonTag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderButtonTag"]) 
                                ){
                                    $SliderProduct = (object)[
                                        "H4 tag" => TemplateController::capitalize($_POST["hSliderH4Tag"]),
                                        "H3-1 tag" => TemplateController::capitalize($_POST["hSliderH3_1Tag"]),
                                        "H3-2 tag" => TemplateController::capitalize($_POST["hSliderH3_2Tag"]),
                                        "H3-3 tag" => TemplateController::capitalize($_POST["hSliderH3_3Tag"]),
                                        "H3-4s tag" => TemplateController::capitalize($_POST["hSliderH3_4Tag"]),
                                        "Button tag" => TemplateController::capitalize($_POST["hSliderButtonTag"]),
                                        "IMG tag" => $saveImageSliderProduct
                                    ];
                                }else{
                                    echo '
                                        <script>
                                            formatearAlertas();
                                            notiAlert(3, "Error: en la sintaxis de los campos");
                                        </script>'; 
                                    return;
                                }
                            }
                        }else{
                            echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: al salvar el horizontal slider");
                            </script>'; 
                            return;
                        }

                        if(isset($_FILES["vSlider"]["tmp_name"]) && !empty($_FILES["vSlider"]["tmp_name"])){
                            $image = $_FILES["vSlider"];
                            $folder = "img/products";
                            $path = explode("_", $_POST['categoryProduct'])[1]."/vertical";
                            $width = 263;
                            $heigth = 629;
                            $name = mt_rand(10000,99999);
    
                            $saveImagedeVerticalBanerProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);
                            if($saveImagedeVerticalBanerProduct == "error"){
                                echo '
                                <script>
                                    formatearAlertas();
                                    notiAlert(3, "Error: al salvar el vertical slider");
                                </script>'; 
                                return;
                            }
                        }else{
                            echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: al salvar el vertical slider");
                            </script>'; 
                            return;
                        }

                        if(!empty($_POST["type_video"]) && !empty($_POST["id_video"])){
                            $video_product = array();
                            if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["id_video"])){
                                array_push($video_product, $_POST["type_video"]);
                                array_push($video_product, $_POST["id_video"]);
                                $video_product = json_encode($video_product);
                            }else{
                                echo '
                                    <script>
                                        formatearAlertas();
                                        notiAlert(3, "Error: en la sintaxis del video");
                                    </script>'; 
                                return;
                            }
                        }else{
                            $video_product = null;
                        }

                        if(!empty($_POST["type_offer"]) && !empty($_POST["valueOffer"]) && !empty($_POST["dateOffer"])){
                            if(preg_match('/^[0-9]{1,}$/', $_POST["valueOffer"])){
                                $offer_product = array($_POST["type_offer"], $_POST["valueOffer"], $_POST["dateOffer"]);
                                $offer_product = json_encode($offer_product);
                            }else{
                                echo '
                                    <script>
                                        formatearAlertas();
                                        notiAlert(3, "Error: en la sintaxis de la oferta");
                                    </script>'; 
                                return;
                            }
                        }else{
                            $offer_product = null;
                        }

                        if(
                            isset($_POST["price"]) && preg_match('/^[.\\,\\0-9]{1,}$/', $_POST["price"]) &&
                            isset($_POST["envio"]) && preg_match('/^[.\\,\\0-9]{1,}$/', $_POST["envio"]) &&
                            isset($_POST["entrega"]) && preg_match('/^[0-9]{1,}$/', $_POST["entrega"]) &&
                            isset($_POST["stock"]) && preg_match('/^[0-9]{1,}$/', $_POST["stock"])
                        ){

                            date_default_timezone_set('UTC');
                            date_default_timezone_set("America/Mexico_City");
                            $dateCreate = date("Y-m-d");

                            $dataProduct = array(
                                "approval_product" => "review",
                                "feedback_product" => "your product is under review",
                                "state_product" => "show",
                                "id_store_product" => $idStore,
                                "name_product" => TemplateController::capitalize($_POST["nameProduct"]),
                                "url_product" => $_POST["urlProduct"],
                                "id_category_product" => explode("_", $_POST["categoryProduct"])[0],
                                "id_subcategory_product" => explode("_", $_POST["subcategoryProduct"])[0],
                                "title_list_product" => explode("_",$_POST["subcategoryProduct"])[1],
                                "description_product" => $_POST["descriptionProduct"],
                                "summary_product" => json_encode($inputSummary),
                                "details_product" => json_encode($inputDetails),
                                "specifications_product" => $inputEspecific,
                                "tags_product" => json_encode( explode(",", $_POST['tagsinput'])),
                                "image_product" => $saveImagePortProduct,
                                "gallery_product" => json_encode($galeryArrayProduct),
                                "top_banner_product" => json_encode($topbannerProduct),
                                "default_banner_product" => $saveImagedefaultBanerProduct,
                                "horizontal_slider_product" => json_encode($SliderProduct),
                                "vertical_slider_product" => $saveImagedeVerticalBanerProduct,
                                "video_product" => $video_product,
                                "offer_product" => $offer_product,
                                "price_product" => $_POST["price"],
                                "shipping_product" => $_POST["envio"],
                                "delivery_time_product" => $_POST["entrega"],
                                "stock_product" => $_POST["stock"],
                                "date_create_product" => $dateCreate
                            );
        
                            $url = CurlController::api()."products?token=".$_SESSION["user"]->token_user;
                            $method = "POST";
                            $fields = $dataProduct;
                            $header = array(
                             "Content-Type" => "application/x-www-form-urlencoded"
                             );
                             $saveProduct = CurlController::request($url,$method,$fields,$header);
                             if($saveProduct->status == "200"){
                                echo '
                                <script>
                                    formatearAlertas();
                                    switAlert("success", "El registro se realizo correctamente", "' . TemplateController::path().'acount&my-store",1500);
                                    window.location="' . TemplateController::path() . 'acount&my-store";
                                </script>'; 
                            return;
                             }else{
                                 echo '
                                     <script>
                                         formatearAlertas();
                                         notiAlert(3, "Error: al guardar el producto");
                                     </script>'; 
                                 return;
                             }
                        }else{
                            echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: al salvar en la sintaxis de los precios");
                            </script>'; 
                            return;
                        }
                    }
                }else{
                    echo '
                    <script>
                        formatearAlertas();
                        notiAlert(3, "Error: al salvar la portada del producto");
                    </script>'; 
                    return;
                }
            }else{
                echo '
                    <script>
                        formatearAlertas();
                        notiAlert(3, "Error en la sintaxis de los campos");
                    </script>';
            }
        }
    }

    public function UpdateStore(){
        if(isset($_POST["idStore"])){
            if(
                preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,10000}$/', $_POST["infoStore"] &&
                preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["cityStore"]) &&
                preg_match('/^[-\\(\\)\\0-9 ]{1,}$/', $_POST["phoneOrder"]) &&
                preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["addresStore"]))
            ){

                if(isset($_FILES['logoStore']["tmp_name"]) && !empty($_FILES['logoStore']["tmp_name"])){
                    $imageLogo = $_FILES['logoStore'];
                    $folderLogo = "img/stores";
                    $pathLogo = $_POST['urlStore'];
                    $widthLogo = 270;
                    $heigthLogo = 270;
                    $nameLogo = "logo";

                    $saveImageLogo = TemplateController::AlmacenPhoto($imageLogo, $folderLogo, $pathLogo, $widthLogo, $heigthLogo, $nameLogo);
                    if($saveImageLogo == 'error'){
                        echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: al guardar el logo");
                        </script>'; 
                    return;
                    }
                }else{
                    $saveImageLogo = $_POST["logoStoreOld"];
                }

                if( isset($_FILES['portStore']["tmp_name"]) && !empty($_FILES['portStore']["tmp_name"]) ){
                    $imagePort = $_FILES['portStore'];
                    $folderPort = "img/stores";
                    $pathPort = $_POST['urlStore'];
                    $widthPort = 1424;
                    $heigthPort = 768;
                    $namePort = "portada";

                    $saveImagePort = TemplateController::AlmacenPhoto($imagePort, $folderPort, $pathPort, $widthPort, $heigthPort, $namePort);
                    if($saveImagePort == 'error'){
                        echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: al guardar la portada");
                        </script>'; 
                    return;
                    }
                }else{
                    $saveImagePort = $_POST["portStoreOld"];
                }

                $sosialNetwork=array();
                $mapaStore=array();

                if(isset($_POST["facebookStore"]) && !empty($_POST["facebookStore"])){
                    array_push($sosialNetwork,["facebook" => "https://www.facebook.com/".$_POST["facebookStore"]]);
                }
                if(isset($_POST["youtubeStore"]) && !empty($_POST["youtubeStore"])){
                    array_push($sosialNetwork,["youtube" => "https://www.youtube.com/".$_POST["youtubeStore"]]);
                }
                if(isset($_POST["instagramStore"]) && !empty($_POST["instagramStore"])){
                    array_push($sosialNetwork,["instagram" => "https://www.instagram.com/".$_POST["instagramStore"]]);
                }
                if(isset($_POST["twitterStore"]) && !empty($_POST["twitterStore"])){
                    array_push($sosialNetwork,["twitter" => "https://twitter.com/".$_POST["twitterStore"]]);
                }

                if($sosialNetwork > 0){
                    $sosialNetwork = json_encode($sosialNetwork);
                }else{
                    $sosialNetwork = null;
                }

                if(isset($_POST["mapStore"])){
                    array_push($mapaStore, explode(",", $_POST["mapStore"])[0] ,explode(",", $_POST["mapStore"])[1]);
                }else{
                    $mapaStore=null;
                }
                            
                $dataStore = "logo_store=".$saveImageLogo."&cover_store=".$saveImagePort."&about_store=".$_POST["infoStore"]."&abstract_store=".substr($_POST["infoStore"],0,100)."..."."&email_store=".$_POST["emailStore"]."&country_store=".explode("_", $_POST["countryStore"])[0]."&city_store=".$_POST["cityStore"]."&phone_store=".explode("_", $_POST["countryStore"])[1]."_".$_POST["phoneOrder"]."&address_store=".$_POST["addresStore"]."&map_store=". json_encode($mapaStore)."&socialnetwork_store=".$sosialNetwork;
                $url = CurlController::api()."stores?id=".$_POST["idStore"]."&nameId=id_store&token=".$_SESSION["user"]->token_user;
                $method = "PUT";
                $fields = $dataStore;
                $header = array(
                "Content-Type" => "application/x-www-form-urlencoded"
                );
                $updateStore = CurlController::request($url,$method,$fields,$header);
                
                if($updateStore->status == "200"){
                    echo '
                    <script>
                        formatearAlertas();
                        switAlert("success", "El producto se guardo correctamente", "' . TemplateController::path().'acount&my-store",1500);
                        window.location="' . TemplateController::path() . 'acount&my-store";
                    </script>'; 
                }else{
                    echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: al guardar tienda");
                        </script>'; 
                    return;
                }
            }else{
                echo '
                    <script>
                        formatearAlertas();
                        notiAlert(3, "Error: en la sintaxis de los campos");
                    </script>'; 
                return;
            }
        }
    }

    public function editProduct(){
        if(isset($_POST["idProduct"])){
            if(isset($_POST["inputSummary"])){
                $summaryProduct = array();
                for($i=0 ; $i < $_POST["inputSummary"]; $i++){
                    array_push($summaryProduct,$_POST["summaryProduct_".$i]);
                }
            }
        

            if(isset($_POST["inputDetails"])){
                $detailsProduct = array();
                for($i=0;$i<$_POST["inputDetails"]; $i++){
                    $detailsProduct[$i] = (object)["title" => $_POST["detailsTitleProduct_".$i],"value" => $_POST["detailsValueProduct_".$i]];
                }
            }

            if(isset($_POST["inputEspesifications"])){
                $inputEspecific = array();
                for($i=0; $i < $_POST["inputEspesifications"]; $i++){
                    $inputEspecific[$i] = (object)[ $_POST["EspesificTypeProduct_".$i] => explode(",", $_POST["EspesificValuesProduct_".$i])];
            }
            $inputEspecific = json_encode($inputEspecific);
            if($inputEspecific == '[{"":[""]}]'){
                $inputEspecific = null;
            }
            }else{
                $inputEspecific = null;
            }

            if(isset($_FILES["logoProduct"]["tmp_name"])&& !empty($_FILES["logoProduct"]["tmp_name"])){
                $image = $_FILES['logoProduct'];
                $folder = "img/products";
                $path = explode("_", $_POST['categoryProduct'])[1];
                $width = 300;
                $heigth = 300;
                $name = $_POST["urlProduct"];

                $ImageProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);
                if($ImageProduct == 'error'){
                    echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: al salvar la imagen del producto");
                        </script>'; 
                        return;
                }
            }else{
                $ImageProduct = $_POST["imageProductOld"];
            }

            $galeryArrayProduct = array();
            $count = 0;
            $count2 = 0;
            $continueEdit = false;
            if(!empty($_POST["galeryProduct"])){
                foreach(json_decode($_POST["galeryProduct"], true) as $key => $value){
                    $count++;
                    $image["tmp_name"] = $value["file"];
                    $image["type"] = $value["type"];
                    $image["mode"] = "base64";
                    $folder = "img/products";
                    $path = explode("_", $_POST['categoryProduct'])[1]."/gallery";
                    $width = $value["width"];
                    $heigth = $value["height"];
                    $name = mt_rand(10000,99999);

                    $galeryProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);
                    array_push($galeryArrayProduct, $galeryProduct);
                    if(count($galeryArrayProduct) == $count){
                        if(!empty($_POST["galeryProductOld"])){
                            foreach(json_decode($_POST["galeryProductOld"], true) as $key => $value){
                                $count2++;
                                array_push($galeryArrayProduct, $value);
                            }
                            if(count(json_decode($_POST["galeryProductOld"], true)) == $count2){
                                $continueEdit = true;
                            }
                        }else{
                            $continueEdit = true;
                        }      
                    }
                }
                if(!empty($_POST["deleteGaleryProduct"])){
                    foreach(json_decode($_POST["deleteGaleryProduct"], true) as $key => $value){
                       unlink("views/img/products/".explode("_",$_POST["categoryProduct"])[1]."/gallery/".$value);
                    }
                }
            }else{
                if(!empty($_POST["galeryProductOld"])){
                    $count2 = 0;
                    foreach(json_decode($_POST["galeryProductOld"], true) as $key => $value){
                        $count2++;
                        array_push($galeryArrayProduct, $value);
                    }
                    if(count(json_decode($_POST["galeryProductOld"], true)) == $count2){
                        $continueEdit = true;
                    }
                }      
            }
            if(count($galeryArrayProduct) == 0){
                echo '
                <script>
                    formatearAlertas();
                    notiAlert(3, "Error: La galeria esta vacia");
                </script>'; 
                return;
            }
            if($continueEdit){
                if(isset($_FILES["topBanner"]["tmp_name"]) && !empty($_FILES["topBanner"]["tmp_name"])){
                    $image = $_FILES["topBanner"];
                    $folder = "img/products";
                    $path = explode("_", $_POST['categoryProduct'])[1]."/top";
                    $width = 1920;
                    $heigth = 80;
                    $name = mt_rand(10000,99999);

                    $saveImagetopBanerProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);

                    if($saveImagetopBanerProduct == "error"){
                        echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: al subir top banner");
                            </script>'; 
                            return;
                    }else{
                        unlink("views/".$folder."/".$path."/".$_POST["topBannerOld"]);
                    }
                }else{
                    $saveImagetopBanerProduct = $_POST["topBannerOld"];
                }
                if(
                    isset($_POST["topBannerH3Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerH3Tag"]) &&
                    isset($_POST["topBannerP1Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerP1Tag"]) &&
                    isset($_POST["topBannerH4Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerH4Tag"]) &&
                    isset($_POST["topBannerP2Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerP2Tag"]) &&
                    isset($_POST["topBannerSpanTag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerSpanTag"]) &&
                    isset($_POST["topBannerButtonTag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["topBannerButtonTag"]) 
                ){
                    $topbannerProduct = (object)[
                        "H3 tag" => TemplateController::capitalize($_POST["topBannerH3Tag"]),
                        "P1 tag" => TemplateController::capitalize($_POST["topBannerP1Tag"]),
                        "H4 tag" => TemplateController::capitalize($_POST["topBannerH4Tag"]),
                        "P2 tag" => TemplateController::capitalize($_POST["topBannerP2Tag"]),
                        "Span tag" => TemplateController::capitalize($_POST["topBannerSpanTag"]),
                        "Button tag" => TemplateController::capitalize($_POST["topBannerButtonTag"]),
                        "IMG tag" => $saveImagetopBanerProduct
                    ];
                }else{
                    echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: en la sintaxis de los campos");
                        </script>'; 
                    return;
                }

                if(isset($_FILES["DefaultBanner"]["tmp_name"]) && !empty($_FILES["DefaultBanner"]["tmp_name"])){
                    $image = $_FILES["DefaultBanner"];
                    $folder = "img/products";
                    $path = explode("_", $_POST['categoryProduct'])[1]."/default";
                    $width = 570;
                    $heigth = 210;
                    $name = mt_rand(10000,99999);

                    $saveImagedefaultBanerProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);
                    if($saveImagedefaultBanerProduct == "error"){
                        echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: al salvar el default banner");
                        </script>'; 
                        return;
                    }else{
                        unlink("views/".$folder."/".$path."/".$_POST["defaultBannerOld"]);
                    }
                }else{
                    $saveImagedefaultBanerProduct = $_POST["defaultBannerOld"];
                }

                if(isset($_FILES["hSlider"]["tmp_name"]) && !empty($_FILES["hSlider"]["tmp_name"])){
                    $image = $_FILES["hSlider"];
                    $folder = "img/products";
                    $path = explode("_", $_POST['categoryProduct'])[1]."/horizontal";
                    $width = 1920;
                    $heigth = 358;
                    $name = mt_rand(10000,99999);

                    $saveImageSliderProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);

                    if($saveImageSliderProduct != "error"){
                        echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: al subir la imagen del horizontal slider");
                            </script>'; 
                        return;
                    }else{
                        unlink("views/".$folder."/".$path."/".$_POST["horizontalSliderOld"]);
                    }
                }else{
                    $saveImageSliderProduct = $_POST["horizontalSliderOld"];
                }
                
                if(
                    isset($_POST["hSliderH4Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH4Tag"]) &&
                    isset($_POST["hSliderH3_1Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH3_1Tag"]) &&
                    isset($_POST["hSliderH3_2Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH3_2Tag"]) &&
                    isset($_POST["hSliderH3_3Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH3_3Tag"]) &&
                    isset($_POST["hSliderH3_4Tag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderH3_4Tag"]) &&
                    isset($_POST["hSliderButtonTag"]) && preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["hSliderButtonTag"]) 
                ){
                    $SliderProduct = (object)[
                        "H4 tag" => TemplateController::capitalize($_POST["hSliderH4Tag"]),
                        "H3-1 tag" => TemplateController::capitalize($_POST["hSliderH3_1Tag"]),
                        "H3-2 tag" => TemplateController::capitalize($_POST["hSliderH3_2Tag"]),
                        "H3-3 tag" => TemplateController::capitalize($_POST["hSliderH3_3Tag"]),
                        "H3-4s tag" => TemplateController::capitalize($_POST["hSliderH3_4Tag"]),
                        "Button tag" => TemplateController::capitalize($_POST["hSliderButtonTag"]),
                        "IMG tag" => $saveImageSliderProduct
                    ];
                }else{
                    echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: en la sintaxis de los campos");
                        </script>'; 
                    return;
                }
                
                if(isset($_FILES["vSlider"]["tmp_name"]) && !empty($_FILES["vSlider"]["tmp_name"])){
                    $image = $_FILES["vSlider"];
                    $folder = "img/products";
                    $path = explode("_", $_POST['categoryProduct'])[1]."/vertical";
                    $width = 263;
                    $heigth = 629;
                    $name = mt_rand(10000,99999);

                    $saveImagedeVerticalBanerProduct = TemplateController::AlmacenPhoto($image, $folder, $path, $width, $heigth, $name);
                    if($saveImagedeVerticalBanerProduct == "error"){
                        echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error: al salvar el vertical slider");
                        </script>'; 
                        return;
                    }else{
                        unlink("views/".$folder."/".$path."/".$_POST["verticalSliderOld"]);
                    }
                }else{
                  $saveImagedeVerticalBanerProduct = $_POST["verticalSliderOld"];
                }

                if(!empty($_POST["type_video"]) && !empty($_POST["id_video"])){
                    $video_product = array();
                    if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["id_video"])){
                        array_push($video_product, $_POST["type_video"]);
                        array_push($video_product, $_POST["id_video"]);
                        $video_product = json_encode($video_product);
                    }else{
                        echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: en la sintaxis del id video");
                            </script>'; 
                        return;
                    }
                }else{
                    $video_product = null;
                }

                if(!empty($_POST["type_offer"]) && !empty($_POST["valueOffer"]) && !empty($_POST["dateOffer"])){
                    if(preg_match('/^[0-9]{1,}$/', $_POST["valueOffer"])){
                        $offer_product = array($_POST["type_offer"], $_POST["valueOffer"], $_POST["dateOffer"]);
                        $offer_product = json_encode($offer_product);
                    }else{
                        echo '
                            <script>
                                formatearAlertas();
                                notiAlert(3, "Error: en la sintaxis de la oferta");
                            </script>'; 
                        return;
                    }
                }else{
                    $offer_product = null;
                }

                if(
                    isset($_POST["price"]) && preg_match('/^[.\\,\\0-9]{1,}$/', $_POST["price"]) &&
                    isset($_POST["envio"]) && preg_match('/^[.\\,\\0-9]{1,}$/', $_POST["envio"]) &&
                    isset($_POST["entrega"]) && preg_match('/^[0-9]{1,}$/', $_POST["entrega"]) &&
                    isset($_POST["stock"]) && preg_match('/^[0-9]{1,}$/', $_POST["stock"])
                ){
                    
                    $dataProduct = "description_product=".TemplateController::cleanhtml(html_entity_decode(str_replace("+", "%2B", $_POST["descriptionProduct"])))."&summary_product=".json_encode($summaryProduct)."&details_product=".json_encode($detailsProduct)."&specifications_product=".$inputEspecific."&tags_product=".json_encode( explode(",", $_POST['tagsinput']))."&image_product=".$ImageProduct."&gallery_product=".json_encode($galeryArrayProduct)."&top_banner_product=".json_encode($topbannerProduct)."&default_banner_product=".$saveImagedefaultBanerProduct."&horizontal_slider_product=".json_encode($SliderProduct)."&vertical_slider_product=".$saveImagedeVerticalBanerProduct."&video_product=".$video_product."&offer_product=".$offer_product."&price_product=".$_POST["price"]."&shipping_product=".$_POST["envio"]."&delivery_time_product=".$_POST["entrega"]."&stock_product=".$_POST["stock"];
                    $url = CurlController::api()."products?id=".$_POST["idProduct"]."&nameId=id_product&token=".$_SESSION["user"]->token_user;
                    $method = "PUT";
                    $fields = $dataProduct;
                    $header = array(
                     "Content-Type" => "application/x-www-form-urlencoded"
                     );
                     $saveProduct = CurlController::request($url,$method,$fields,$header);
                     if($saveProduct->status == "200"){
                        echo '
                        <script>
                            formatearAlertas();
                            switAlert("success", "El registro se realizo correctamente", "' . TemplateController::path().'acount&my-store",1500);
                            window.location="' . TemplateController::path() . 'acount&my-store";
                        </script>'; 
                    return;
                     }else{
                         echo '
                             <script>
                                 formatearAlertas();
                                 notiAlert(3, "Error: al guardar el producto");
                             </script>'; 
                         return;
                     }
                }else{
                    echo '
                    <script>
                        formatearAlertas();
                        notiAlert(3, "Error: al salvar en la sintaxis de los precios");
                    </script>'; 
                    return;
                }
            }
        }
    }

    public function orderUpdates(){
        if(isset($_POST["stage"])){
            $process = json_decode(base64_decode($_POST["processOrder"]), true);
            $changeProcess = array();
            $tipo = "";

            foreach($process as $key => $value){
                if($value["stage"] == $_POST["stage"]){
                    $value["date"] = $_POST["date"]; 
                    $value["status"] = $_POST["status"]; 
                    $value["comment"] = $_POST["comment"]; 
                    $tipo = $_POST["stage"];
                }
                array_push($changeProcess, $value);
            }

            $url = CurlController::api()."orders?id=".$_POST["idOrder"]."&nameId=id_order&token=".$_SESSION["user"]->token_user;
            $method = "PUT";
            if($_POST["stage"] == "delivered" && $_POST["status"] == "ok"){
                $fields = "status_order=ok&process_order=". json_encode($changeProcess);
                $url2 = CurlController::api()."sales?id=".$_POST["idOrder"]."&nameId=id_order_sale&token=".$_SESSION["user"]->token_user;
                $method2 = "PUT";
                $fields2 = "id_store_sale=".$_POST["idStores"]."&name_product_sale=".$_POST["namessProduct"]."&status_sale=ok";
                $headers2 = array(
                    "Content-Type" => "application/x-www-form-urlencoded"
                );
                $saleUpdate = CurlController::request($url2,$method2,$fields2,$headers2);

                if($saleUpdate->status != 200){
                    echo '<script>
                            formatearAlertas();
                            switAlert("error", "Se produjo un error", null,null);
                        </script>';
                    return;
                }
            }else{
                $fields = "process_order=". json_encode($changeProcess);
            }
            $headers= array(
                "Content-Type" => "application/x-www-form-urlencoded"
            );
            $orderUpdate = CurlController::request($url,$method,$fields,$headers);

            if($orderUpdate->status == 200){
                $name = $_POST["clientOrder"];
                $subject = "Su producto esta".$tipo;
                $email = $_POST["emailOrder"];
                $message = "Su producto se ".$tipo." correctamente!";
                $url = TemplateController::path()."acount&my-shopping";
                $post = "Ver su producto";
                $sendEmail = TemplateController::sendEmail($name,$subject,$email,$message,$url,$post);
                if($sendEmail == "ok"){
                    echo '
                    <script>
                        formatearAlertas();
                        switAlert("success", "Se actualizo correctamente la orden", null, null, 1500);
                    </script>'; 
                }
            }
        }
    } 

    public function disputeAnswer(){

        if(isset($_POST["idDispute"])){

            if(isset($_POST["answerDisput"])){
                if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["answerDisput"])){
                    date_default_timezone_set('UTC');
                    date_default_timezone_set("America/Mexico_City");

                    $url = CurlController::api()."disputes?id=".$_POST["idDispute"]."&nameId=id_dispute&token=".$_SESSION["user"]->token_user;
                    $method = "PUT";
                    $fields ="answer_dispute=".$_POST["answerDisput"]."&date_answer_dispute=".date("Y-m-d"); 
                    $headers= array(
                        "Content-Type" => "application/x-www-form-urlencoded"
                    );

                    $dispute = CurlController::request($url,$method,$fields,$headers);

                    if($dispute->status == 200){
                        $name = $_POST["clientDispute"];
                        $subject = "Se respondio tu disputa";
                        $email = $_POST["emailDispute"];
                        $message = "La tienda ".$_POST["nameStore"]." respondio a tu disputa.";
                        $url = TemplateController::path()."acount&my-store&disputes";
                        $post = "Ver resuesta";
                        $sendEmail = TemplateController::sendEmail($name,$subject,$email,$message,$url,$post);
                        if($sendEmail == "ok"){
                            echo '
                            <script>
                                formatearAlertas();
                                switAlert("success", "Se envio tu respuesta correctamente", null, null, 1500);
                            </script>'; 
                        }else{
                            echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error al enviar por correo");
                        </script>';    
                        }
                    }else{
                        echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error al hacer la peticion");
                        </script>';
                    }
                }else{
                    echo '
                    <script>
                        formatearAlertas();
                        notiAlert(3, "Error en la sintaxis de los campos");
                    </script>';
                }
            }
        }
    }

    public function messageAnswer(){
        if(isset($_POST["idMessage"])){

            if(isset($_POST["answerMessage"])){
                if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["answerMessage"])){
                    date_default_timezone_set('UTC');
                    date_default_timezone_set("America/Mexico_City");

                    $url = CurlController::api()."messages?id=".$_POST["idMessage"]."&nameId=id_message&token=".$_SESSION["user"]->token_user;
                    $method = "PUT";
                    $fields ="answer_message=".$_POST["answerMessage"]."&date_answer_message=".date("Y-m-d"); 
                    $headers= array(
                        "Content-Type" => "application/x-www-form-urlencoded"
                    );

                    $messages = CurlController::request($url,$method,$fields,$headers);

                    if($messages->status == 200){
                        $name = $_POST["clientMessage"];
                        $subject = "Se respondio tu pregunta";
                        $email = $_POST["emailMessage"];
                        $message = "La tienda ".$_POST["nameStore"]." respondio a tu pregunta.";
                        $url = TemplateController::path().$_POST["urlProduct"];
                        $post = "Ver resuesta";
                        $sendEmail = TemplateController::sendEmail($name,$subject,$email,$message,$url,$post);
                        if($sendEmail == "ok"){
                            echo '
                            <script>
                                formatearAlertas();
                                switAlert("success", "Se envio tu respuesta correctamente", null, null, 1500);
                            </script>'; 
                        }else{
                            echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error al enviar por correo");
                        </script>';    
                        }
                    }else{
                        echo '
                        <script>
                            formatearAlertas();
                            notiAlert(3, "Error al hacer la peticio");
                        </script>';
                    }
                }else{
                    echo '
                    <script>
                        formatearAlertas();
                        notiAlert(3, "Error en la sintaxis de los campos");
                    </script>';
                }
            }
        }
    }
}
?>