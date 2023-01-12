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
        // traer las ordenes
        $select="quantity_order,price_order,details_order,process_order,id_order,name_store,url_store,id_category_product,name_product,url_product,image_product,reviews_product,id_store_order,email_store,id_user_order,id_product,reviews_product";
        $url= CurlController::api()."relations?rel=orders,stores,products&type=order,store,product&linkTo=id_user_order&equalTo=".$_SESSION["user"]->id_user."&select=".$select."&orderBy=id_order&orderMode=DESC&token=".$_SESSION["user"]->token_user;
        $method= "GET";
        $header= array();
        $filds= array();
        $shoppingOrder= CurlController::request($url, $method, $header, $filds)->result;

         // traer disputas
         $select="id_order_dispute,content_dispute,answer_dispute,date_answer_dispute,date_created_dispute,method_user,logo_store,url_store";
         $url= CurlController::api()."relations?rel=disputes,orders,users,stores&type=dispute,order,user,store&linkTo=id_user_dispute&equalTo=".$_SESSION["user"]->id_user."&select=".$select."&orderBy=id_dispute&orderMode=DESC&token=".$_SESSION["user"]->token_user;
         $method= "GET";
         $header= array();
         $filds= array();
         $disputes = CurlController::request($url, $method, $header, $filds)->result;
         if(!is_array($disputes)){
            $disputes = array();
         }
    }
}
?>
<!--=====================================
My Account Content
======================================--> 

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
                    <li ><a href="<?php echo $path; ?>acount&wishAcount">My Wishlist</a></li>
                    <li class="active"><a href="<?php echo $path; ?>acount&my-shopping">My Shopping</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-store">My Store</a></li>
                    <li><a href="<?php echo $path; ?>acount&my-sales">My Sales</a></li>
                </ul>

                <!--=====================================
                My Shopping
                ======================================--> 

                <div class="table-responsive">

                    <table class="table ps-table--whishlist dt-responsive dt-client" width="100%">

                        <thead>

                            <tr>      

                                <th>Product name</th>

                                <th>Proccess</th>

                                <th>Price</th>

                                <th>Quantity</th>

                                <th>Review</th>

                            </tr>

                        </thead>

                        <tbody>

                            <!-- Product -->
                            <?php if(isset($shoppingOrder) && $shoppingOrder != null && $shoppingOrder != "no found"): ?>
                                <?php foreach($shoppingOrder as $key => $value): ?>

                                    <tr>

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

                                                    <a href="<?php echo $path.$value->url_product?>"><?php echo $value->name_product; ?></a>
                                                    <div><a href="<?php echo $path.$value->url_store ?>"><small> <?php echo $value->name_store; ?></small></a></div>
                                                    
                                                    <small><?php echo json_decode($value->details_order); ?></small>
                                                </div>

                                            </div>

                                        </td>

                                        <td>
                                            <?php $processOrder = json_decode($value->process_order, true); ?>

                                            <ul class="timeline">

                                                <?php foreach($processOrder as $key => $item): ?>
                                                    <?php if($item["status"] == "ok"): ?>
                                                        <li class="success">                                             
                                                            <h5><?php echo $item["date"] ?></h5>
                                                            <p class="text-success"><?php echo $item["stage"]; ?> <i class="fas fa-check"></i></p>
                                                            <p>Comment: <?php echo $item["comment"] ?></p>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="process">                                             
                                                            <h5><?php echo $item["date"] ?></h5>
                                                            <p><?php echo $item["stage"]; ?></p>
                                                            <button class="btn btn-primary" disabled><span class="spinner-border spinner-border-sm"></span>In Process</button>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            
                                            </ul>  

                                            <?php if($processOrder[2]["status"] == "ok"): ?>
                                                <a class="btn btn-warning btn-lg" href="<?php echo $path.$value->url_product?>">Repurchase</a>
                                            <?php else: ?>
                                                <a class="btn btn-warning btn-lg openDisputes btn-danger text-white"
                                                idOrder = "<?php echo $value->id_order; ?>"
                                                idUser = "<?php echo $value->id_user_order; ?>"
                                                idStore = "<?php echo $value->id_store_order; ?>"
                                                emailStore ="<?php echo $value->email_store; ?>"
                                                nameStore = "<?php echo $value->name_store; ?>">Open Dispute</a>
                                                <?php if(count($disputes) > 0): ?>
                                                    <?php foreach($disputes as $index => $item): ?>
                                                        <?php if($value->id_order == $item->id_order_dispute): ?>
                                                            <div class="my-3">
                                                                <div class="media border p-3">
                                                                    <div class="media-body">
                                                                        <h4><small>Dispute on <?php echo $item->date_created_dispute; ?></small></h4>
                                                                        <p><?php echo $item->content_dispute; ?></p>
                                                                    </div>
                                                                    <?php if($_SESSION["user"]->method_user == "direct"): ?>
                                                                        <?php if($_SESSION["user"]->picture_user == ""): ?>
                                                                            <img class="img-fluid rounded-circle ml-auto" src="img/users/default/default.png" style="width: 60px;">
                                                                        <?php else: ?>
                                                                            <img class="img-fluid rounded-circle ml-auto" src="img/users/<?php echo $_SESSION["user"]->id_user?>/<?php echo $_SESSION["user"]->picture_user?>" style="width: 60px;">
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <?php if( $item->date_answer_dispute != null && $item->answer_dispute != null ): ?>
                                                                    <div class="media border p-3">
                                                                    <img class="img-fluid rounded-circle ml-3 mt-3" src="img/stores/<?php echo $item->url_store?>/<?php echo $item->logo_store ?>" style="width: 60px;">
                                                                        <div class="media-body text-right">
                                                                            <h4><small>Answer on <?php echo $item->date_answer_dispute; ?></small></h4>
                                                                            <p><?php echo $item->answer_dispute; ?></p>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        </td> 

                                        <td class="price text-center"><?php echo $value->price_order; ?></td>

                                        <td class="text-center"><?php echo $value->quantity_order; ?></td>

                                        <td>
                                        <div class="text-center  mt-2">
                                            <?php if($processOrder[2]["status"] == "ok"): ?>

                                                <?php 
                                                    if($value->reviews_product != null){
                                                        $rating = 0;
                                                        $comment = "";
                                                        $reviews = json_decode($value->reviews_product, true);
                                                        foreach($reviews as $index => $item){
                                                            if(isset($item["user"])){
                                                                if($item["user"] == $value->id_user_order){
                                                                    $rating = $item["review"];
                                                                    $comment = $item["comment"];
                                                                }
                                                            }
                                                        }
                                                    }else{
                                                        $rating = 0;    
                                                    }
                                                ?>

    
                                                <div class="br-theme-fontawesome-stars">

                                                    <select class="ps-rating" data-read-only="true" style="display: none;">
                                                        <?php
                                                        if ($rating > 0) {
                                                            for ($i = 0; $i < 5; $i++) {
                                                                if ($rating < ($i + 1)) {
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

                                                </div>

                                                <?php  if($value->reviews_product != null): ?>
                                                <p>Comentario: <?php echo $comment ?></p>
                                                <?php endif; ?>

                                                <a 
                                                class="btn btn-warning btn-lg CommentStars"
                                                idUser=<?php echo $value->id_user_order?>
                                                idProduct=<?php echo $value->id_product?>>
                                                <?php if($rating != 0): ?>
                                                    Edit comment
                                                <?php else: ?>
                                                    Add comment
                                                <?php endif; ?>
                                                </a>

                                                
                                            <?php else: ?>

                                                <a class="btn btn-warning btn-lg disabled">Add comment</a>

                                            <?php endif; ?>
                                        </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>
                            <?php endif; ?>
        
                        </tbody>

                    </table>

                </div><!-- End My Shopping -->

            </div>


        </div>

    </div>

</div>
<div class="modal" id="newDispute">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" class="needs-validation" novalidate>
                <!-- header -->
                <div class="modal-header">
                    <h5 class="modal-title text-center">New dispute</h5>
                    <button class="close btn btn-danger" type="button" data-dismiss="modal">&times;</button>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <input type="hidden" name="idOrder">
                    <input type="hidden" name="idUser">
                    <input type="hidden" name="idStore">
                    <input type="hidden" name="emailStore">
                    <input type="hidden" name="nameStore">
                    <div class="form-group">
                        <label>Type your message</label>
                        <div class="form-group__content">
                            <textarea 
                            class="form-control"
                            type="text"
                            name="contentDispute"
                            placeholder="Escribe tu disputa..."
                            required
                            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validatejs(event, 'parrafo')"></textarea>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">El nombre es requerido</div>
                        </div>
                    </div>
                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="form-group submit">
                        <button class="btn btn-warning ps-btn ps-btn--fullwidth">Enviar</button>
                    </div>
                </div>
                <?php
                    $newDispute = new ControllerUser ();
                    $newDispute -> disputeSubmit();
                ?>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="newComment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" class="needs-validation" novalidate>
                <!-- header -->
                <div class="modal-header">
                    <h5 class="modal-title text-center">New Calification</h5>
                    <button class="close btn btn-danger" type="button" data-dismiss="modal">&times;</button>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <input type="hidden" name="idProduct">
                    <input type="hidden" name="idUser">
                    <div class="form-group">
                        
                        <div class="form-group form-group__rating">

                            <label>Your rating of this product</label>

                            <select class="ps-rating" name="rating" data-read-only="false">

                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>

                            </select>

                        </div>

                        <label>Type your comment</label>
                        <div class="form-group__content">
                            <textarea 
                            class="form-control"
                            type="text"
                            name="contentComment"
                            placeholder="Escribe tu comentario..."
                            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validatejs(event, 'parrafo')"></textarea>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">El nombre es requerido</div>
                        </div>
                    </div>
                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="form-group submit">
                        <button class="btn btn-warning ps-btn ps-btn--fullwidth">Enviar</button>
                    </div>
                </div>
                <?php
                    $newComment = new ControllerUser ();
                    $newComment -> calificationSubmit();
                ?>
            </form>
        </div>
    </div>
</div>