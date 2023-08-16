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
                    <a class="nav-link" href="<?php echo TemplateController::path() ?>acount&my-store&orders">Orders</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="<?php echo TemplateController::path() ?>acount&my-store&disputes">Disputes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo TemplateController::path() ?>acount&my-store&messages">Messages</a>
                </li>
                
            </ul>

        </div>

    </div>
    
    <input type="hidden" id="path" value="<?php echo TemplateController::path(); ?>">
    <input type="hidden" id="idStore" value="<?php echo $storeResult[0]->id_store; ?>">
    <input type="hidden" id="urlApi" value="<?php echo CurlController::api(); ?>">

    <table class="table dt-responsive dt-server-messages" width="100%">
        
        <thead>

            <tr>   
                
                <th>#</th>   

                <th>product</th>

                <th>Client</th>   

                <th>Email</th>

                <th>Content</th>   

                <th>Date created</th>

                <th>Answer</th>

                <th>Date answer</th>

            </tr>

        </thead>

    </table>
</div>

<div class="modal" id="answerMessage">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" class="needs-validation" novalidate>
                <!-- header -->
                <div class="modal-header">
                    <h5 class="modal-title text-center">Answer message</h5>
                    <button class="close btn btn-danger" type="button" data-dismiss="modal">&times;</button>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <input type="hidden" name="idMessage">
                    <input type="hidden" name="clientMessage">
                    <input type="hidden" name="emailMessage">
                    <input type="hidden" name="urlProduct">
                    <input type="hidden" id="nameStore"  name="nameStore" value="<?php echo $storeResult[0]->name_store; ?>">
                   
                    <div class="form-group">
                        <label>Type your Answer</label>
                        <div class="form-group__content">
                            <textarea 
                            class="form-control"
                            type="text"
                            name="answerMessage"
                            placeholder="Escribe tu respuesta..."
                            required
                            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validatejs(event, 'parrafo')"></textarea>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">El mensaje es requerido</div>
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
                    $message = new ControllerVendor();
                    $message->messageAnswer();
                ?>
            </form>
        </div>
    </div>
</div> 