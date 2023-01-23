<?php
require_once "../controllers/curlController.php";
class ControllerDelete{
    public $id;
    public function eliminarAjaxProduct(){
        $select = "url_category,image_product,gallery_product,top_banner_product,default_banner_product,horizontal_slider_product,vertical_slider_product";
        $url = CurlController::api()."relations?rel=products,categories,subcategories,stores&type=product,category,subcategory,store&linkTo=id_product&equalTo=".$this->id."&select=".$select; 
        $method ="GET";
        $fields = array();
        $headers = array();
        $deleteProduct = CurlController::request($url,$method,$fields,$headers)->result[0];
       
        if(file_exists("../views/img/products/".$deleteProduct->url_category."/".$deleteProduct->image_product)){
            unlink("../views/img/products/".$deleteProduct->url_category."/".$deleteProduct->image_product);
        }

        foreach(json_decode($deleteProduct->gallery_product, true) as $key => $value){
            if(file_exists("../views/img/products/".$deleteProduct->url_category."/gallery/".$value)){
                unlink("../views/img/products/".$deleteProduct->url_category."/gallery/".$value);
            }
        }

        if(file_exists("../views/img/products/".$deleteProduct->url_category."/top/".json_decode($deleteProduct->top_banner_product, true)["IMG tag"])){
            unlink("../views/img/products/".$deleteProduct->url_category."/top/".json_decode($deleteProduct->top_banner_product, true)["IMG tag"]);
        }

        if(file_exists("../views/img/products/".$deleteProduct->url_category."/default/".$deleteProduct->default_banner_product)){
            unlink("../views/img/products/".$deleteProduct->url_category."/default/".$deleteProduct->default_banner_product);
        }

        if(file_exists("../views/img/products/".$deleteProduct->url_category."/horizontal/".json_decode($deleteProduct->horizontal_slider_product, true)["IMG tag"])){
            unlink("../views/img/products/".$deleteProduct->url_category."/horizontal/".json_decode($deleteProduct->horizontal_slider_product, true)["IMG tag"]);
        }

        if(file_exists("../views/img/products/".$deleteProduct->url_category."/vertical/".$deleteProduct->vertical_slider_product)){
            unlink("../views/img/products/".$deleteProduct->url_category."/vertical/".$deleteProduct->vertical_slider_product);
        }

        
    }
}
if(isset($_POST["idProduct"])){
    $idProduct = new ControllerDelete();
    $idProduct ->  id = $_POST["idProduct"];
    $idProduct -> eliminarAjaxProduct();
}
?>