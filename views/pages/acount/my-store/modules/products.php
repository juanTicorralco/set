<?php if(isset($_GET["product"])): ?>
<?php 
    if($_GET["product"] == "new"){

        include "views/pages/acount/my-store/modules/new-product.php";
    }
    if(is_numeric( $_GET["product"])==1){
        include "views/pages/acount/my-store/modules/adit-product.php";
    }
?>
<?php else: ?>
<div class="ps-section__right">                             
    <div class="d-flex justify-content-between">
    
        <div>
            <a href="<?php echo TemplateController::path() ?>acount&my-store?product=new#vendor-store" class="btn btn-lg btn-warning my-3">Create new product</a>
        </div>
        
        <div>
            <ul class="nav nav-tabs">  

                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo TemplateController::path() ?>acount&my-store">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo TemplateController::path() ?>acount&my-store&orders">Orders</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo TemplateController::path() ?>acount&my-store&disputes">Disputes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo TemplateController::path() ?>acount&my-store&messages">Messages</a>
                </li>
                
            </ul>

        </div>

    </div>
    
    <input type="hidden" id="path" value="<?php echo TemplateController::path(); ?>">
    <input type="hidden" id="idStore" value="<?php echo $storeResult[0]->id_store; ?>">
    <input type="hidden" id="urlApi" value="<?php echo CurlController::api(); ?>">

    <table class="table dt-responsive dt-server" width="100%">
        
        <thead>

            <tr>   
                
                <th>#</th>   

                <th>Actions</th>

                <th>Feedback</th>   

                <th>State</th>

                <th>Image</th>   

                <th>Name</th>

                <th>Category</th>

                <th>Subcategory</th>

                <th>Price</th>

                <th>Shipping</th>

                <th>Stock</th>

                <th>Delivery time</th>

                <th>Offer</th>

                <th>Summary</th>

                <th>Specification</th>

                <th>Details</th>

               <th>Description</th>      

                <th>Gallery</th>

                <th>Top Banner</th>

                <th>Default Banner</th>

                <th>Horizontal Slider</th>

                <th>Vertical Slider</th>

                <th>Video</th>

                <th>Tags</th>

                <th>Views</th>

                <th>Sales</th>

                <th>Reviews</th>

                <th>Date created</th>

            </tr>

        </thead>

    </table>
</div>
<?php endif; ?>