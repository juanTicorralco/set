<div class="ps-section__right">                             
    <div class="d-flex justify-content-between">
    <div>
           
        </div>
        <div>
            <ul class="nav nav-tabs">  

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo TemplateController::path() ?>acount&my-store">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo TemplateController::path() ?>acount&my-store&orders">Orders</a>
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

    <table class="table dt-responsive dt-server-orders" width="100%">
        
        <thead>

            <tr>   
                
                <th>#</th>   

                <th>Status</th>

                <th>Client</th>   

                <th>Email</th>

                <th>Country</th>   

                <th>City</th>

                <th>Address</th>

                <th>Phone</th>

                <th>Product</th>

                <th>Quantity</th>

                <th>Details</th>

                <th>Price</th>

                <th>Process</th>

                <th>Date</th>

            </tr>

        </thead>

    </table>
</div>
<div class="modal" id="nextProcess">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" class="needs-validation" novalidate>
                <!-- header -->
                <div class="modal-header">
                    <h5 class="modal-title text-center">Next Process For <span></span></h5>
                    <button class="close btn btn-danger text-white" type="button" data-dismiss="modal">&times;</button>
                </div>
                <!-- body -->
                <div class="modal-body text-left p-5">
                    <div class="card my-3 orderBody"></div>
                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="form-group submit">
                        <button class="ps-btn ps-btn--fullwidth orderUpdate">Save</button>
                    </div>
                </div>
                <?php
                    $order = new ControllerVendor ();
                    $order -> orderUpdates();
                ?>
            </form>
        </div>
    </div>
</div>