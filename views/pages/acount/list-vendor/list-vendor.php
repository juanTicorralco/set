<?php
if (!isset($_SESSION['user'])) {
    echo '<script>
            window.location="' . $path . 'acount&login";
    </script>';
    return;
}else{
    $time= time();
    if($_SESSION["user"]->token_exp_user < $time){
        echo '<script>
        switAlert("error", "Para proteger tus datos, si no hay actividad en tu cuenta, se cierra automaticamente. Vuelve a logearte!", "' . $path . 'acount&logout","");
            
    </script>';
    return;
    }else{
        $arrayProdust = array();
        $select1 = "id_product_order";
        $url1 = CurlController::api()."orders?linkTo=id_user_order&equalTo=".$_SESSION["user"]->id_user."&token=".$_SESSION["user"]->token_user."&select=".$select1;
        $method= "GET";
        $header= array();
        $filds= array();
        $idorder = CurlController::request($url1, $method, $header, $filds);
        if($idorder->status == 200){
            $idorder = $idorder->result;
            $idProductOrder = array();
            $valuenum=0;

            foreach($idorder as $key => $value){
                if($value->id_product_order != $valuenum){
                    $valuenum = $value->id_product_order;
                    if(!in_array($valuenum, $idProductOrder)){
                        array_push($idProductOrder, $valuenum);
                    }
                }       
            }
            foreach($idProductOrder as $key => $value){
                $select2 = "id_product,id_category_product,image_product,name_product,stars_product,win_product,url_product";
                $url2 = CurlController::api()."products?linkTo=id_product&equalTo=".$value."&select=".$select2;
                $idProductO = CurlController::request($url2, $method, $header, $filds);
                if($idProductO->status == 200){
                    array_push($arrayProdust,$idProductO->result[0]);
                }
            }
        }
    }
}

?>
<div class="ps-vendor-dashboard pro">

    <div class="container">

        <div class="ps-section__header">

            <!--=====================================
            Profile
            ======================================--> 

            <?php include "views/pages/acount/profile/profile.php"; ?>

            <!--=====================================
            Nav Account
            ======================================--> 

            <div class="ps-section__content">

                <ul class="ps-section__links">
                    <?php if($_SESSION["user"]->method_user == "direct"): ?>
                    <li><a href="<?php echo $path; ?>acount&wishAcount">My Wishlist</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-shopping">My Shopping</a></li>
                    <?php endif; ?>
                    <?php if($_SESSION["user"]->method_user == "administer"): ?>
                    <li><a href="<?php echo $path; ?>acount&my-shopping">My Shopping</a></li>
                    <li class="active"><a href="<?php echo $path; ?>acount&list-vendor">Lista vendidos</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-sales">My Sales</a></li>
                    <?php endif; ?>
                    <?php if($_SESSION["user"]->method_user == "globalAdminister"): ?>
                    <li><a href="<?php echo $path; ?>acount&my-store">My Store</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-sales">My Sales</a></li>
                    <?php endif; ?>
                </ul>

                <?php

                ?>

                <div class="table-responsive">

                    <table class="table ps-table--whishlist dt-responsive dt-client" width="100%">

                        <thead>

                            <tr>      

                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Esterlla</th>
                                <th>Ganador</th>

                            </tr>

                        </thead>

                        <tbody>

                            <!-- Product -->
                                <?php foreach($arrayProdust as $key => $value): ?>

                                    <tr>
                                        <td> <?php echo $key+1 ?></td>

                                        <td>

                                            <div class="ps-product--cart">

                                                <div class="ps-product__thumbnail">

                                                <?php
                                                    $url=CurlController::api()."categories?linkTo=id_category&equalTo=".$value->id_category_product."&select=url_category";
                                                    $method="GET";
                                                    $fields=array();
                                                    $headers=array();

                                                    $category= CurlController::request($url, $method, $fields, $headers)->result[0];
                                                ?>
                                                    <a href="<?php echo $path . $value->url_product; ?>">
                                                        <img src="img/products/<?php echo $category->url_category; ?>/<?php echo $value->image_product; ?>" alt="">
                                                    </a>
                                                    
                                                </div>

                                                <div class="ps-product__content">
                                                    <a href="<?php echo $path . $value->url_product; ?>"><?php echo $value->name_product; ?></a>
                                                </div>

                                            </div>

                                        </td>
                                        <td class="text-center">
                                            <?php 
                                                 $select3 = "name_vendor_order,stars_order";
                                                 $url1 = CurlController::api()."orders?linkTo=id_product_order&equalTo=".$value->id_product."&token=".$_SESSION["user"]->token_user."&select=".$select3;
                                                 $namesorder = CurlController::request($url1, $method, $header, $filds)->result;
                                                $starProd= json_decode($value->stars_product);
                                                $stars_product = '[';
                                                foreach($namesorder as $key2 => $value2){
                                                    echo "<pre>"; echo $value2->stars_order. " - " . $value2->name_vendor_order; echo "</pre>";
                                                    $stars_product .= '{"'.$value2->name_vendor_order.'":'.$value2->stars_order.'},';
                                                }

                                                $stars_product = substr($stars_product, 0, -1);
                                                $stars_product .= ']';
                                                $arrayStarPro = "";
                                                foreach(json_decode($stars_product) as $key2 => $value2){
                                                    foreach($value2 as $key3 => $value3){
                                                        foreach($value3 as $key4 => $value4){
                                                            if($value->win_product != null || $value->win_product != ""){
                                                                if($value->win_product == $value4 ){
                                                                    $arrayStarPro = key($value2);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                        </td>
                                        
                                        <td><?php 
                                        if($value->win_product == null || $value->win_product == ""){
                                            echo "<p class='text-danger'>No hay ganador</p>";
                                        }else{
                                            echo  "<p class='text-success font-weight-bold'>".$value->win_product." - ". $arrayStarPro ."</p>";
                                        } 
                                        ?></td> 
                                       
                                    </tr>

                                <?php endforeach; ?>
                        </tbody>

                    </table>

                </div><!-- End My Shopping -->
            </div>
        </div>
    </div>
</div>