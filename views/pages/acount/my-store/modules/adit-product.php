<?php
    if(isset($_GET["product"])){
        $select = "id_product,name_product,approval_product,state_product,url_product,feedback_product,image_product,name_category,id_category,url_category,name_category,id_subcategory,title_list_subcategory,name_subcategory,price_product,shipping_product,stock_product,delivery_time_product,offer_product,summary_product,specifications_product,details_product,description_product,tags_product,gallery_product,top_banner_product,default_banner_product,horizontal_slider_product,vertical_slider_product,video_product,views_product,sales_product,reviews_product,date_create_product";
        $url = CurlController::api()."relations?rel=products,categories,subcategories,stores&type=product,category,subcategory,store&linkTo=id_product,id_store&equalTo=".$_GET["product"].",".$storeResult[0]->id_store."&select=".$select;
        $method = "GET";
        $fields = array();
        $headers = array();
        $editProduct = CurlController::request($url,$method,$fields,$headers)->result[0];
    }
?>
<?php if($editProduct == "n"): ?>
    <h4 class="text-center">No existe este producto en tu inventario</h4><br>
<?php else: ?>
    <form class="needs-validation" novalidate method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?php echo CurlController::api();?>" id="urlApi">
    <input type="hidden" value="<?php echo $editProduct->id_product;?>" name="idProduct">
    <div>
        <!-- Modal header -->
        <div class="modal-header">
            <h5 class="modal-title text-center">EDITAR PRODUCTO</h5>
            <a href="<?php echo TemplateController::path() ?>acount&my-store#vendor-store" class="btn btn-danger">Cancel</a>
        </div>
        <div class="modal-body text-left p-5">
            <!-- name store -->
            <div class="form-group">
                <label>Product name<sup class="text-danger">*</sup></label>
                <div class="form-group__content">
                    <input 
                    type="text"
                    class="form-control"
                    placeholder="Nombre de tu producto..."
                    readonly 
                    value="<?php echo $editProduct->name_product ?>"
                    pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}" 
                    onchange="dataRepeat(event, 'product')">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">El nombre es requerido</div>
                </div>
            </div>
            <!-- url store -->
            <div class="form-group">
                <label>URL store<sup class="text-danger">*</sup></label>
                <div class="form-group__content">
                    <input 
                    type="text"
                    class="form-control"
                    placeholder="URL de tu Producto..."
                    readonly 
                    value="<?php echo $editProduct->url_product ?>"
                    required 
                    pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                    onchange="validatejs(event, 'parrafo')">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">El nombre es requerido</div>
                </div>
            </div>
            <!-- Categories -->
            <div class="form-group">
                <label>Product Category<sup class="text-danger">*</sup></label>
                <div class="form-group__content">
                    <select 
                    class="form-control"
                    name="categoryProduct"
                    readonly
                    required>
                        <option value="<?php echo $editProduct->id_category."_".$editProduct->url_category; ?>"><?php echo $editProduct->name_category; ?></option>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">El nombre es requerido</div>
                </div>
            </div>
            <!-- Subcategories -->
            <div class="form-group subcategoryProduct">
                <label>Product Subcategory<sup class="text-danger">*</sup></label>
                <div class="form-group__content">
                    <select 
                        class="form-control"
                        name="subcategoryProduct"
                        readonly
                        required>
                        <option value="<?php echo $editProduct->id_subcategory."_".$editProduct->url_subcategory; ?>"><?php echo $editProduct->name_subcategory; ?></option>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">El nombre es requerido</div>
                </div>
            </div>
            <!-- description -->
            <div class="form-group">
                <label>Description Product<sup class="text-danger">*</sup></label>
                <div class="form-group__content">
                    <textarea 
                        class="summernote editSummerNote" 
                        name="descriptionProduct"
                        idProduct="<?php echo $editProduct->id_product ?>" 
                        required>
                    </textarea>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
            </div>
            <!-- resumen -->
            <div class="form-group">
                <label>Sumary Product<sup class="text-danger">*</sup> Ex: 20 hras de portabilidad</label>
                <?php foreach(json_decode($editProduct->summary_product, true) as $key => $value): ?>
                <input type="hidden" name="inputSummary" value="<?php echo $key+1 ?>">
                <div class="form-group__content input-group mb-3 inputSummary">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <button type="button" class="btn btn-danger" onclick="removedInput(<?php echo $key ?>,'inputSummary')">&times;</button>
                        </span>
                    </div>
                    <input 
                    class="form-control"
                    type="text"
                    name="summaryProduct_<?php echo $key?>"
                    required
                    value="<?php echo $value ?>"
                    pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                    onchange="validatejs(event, 'parrafo')">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
                <?php endforeach;?>
                <button type="button" class="btn btn-primary mb-2 btn-large" onclick="addInput(this,'inputSummary')">Agregar</button>
            </div>
            <!-- details -->
            <div class="form-group">
                <label>Details Product<sup class="text-danger">*</sup>EX: <strong>title:</strong> Bloutwe, <strong>Value:</strong> yes</label>
                <?php foreach(json_decode($editProduct->details_product, true) as $key => $value):?>
                    <input type="hidden" name="inputDetails" value="<?php echo $key + 1 ?>">
                    <div class="row mb-3 inputDetails">
                        <div class="col-12 col-lg-6 form-group__content input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <button type="button" class="btn btn-danger" onclick="removedInput(<?php echo $key ?>,'inputDetails')">&times;</button>
                                </span>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    Title:
                                </span>
                            </div>
                            <input 
                            class="form-control"
                            type="text"
                            name="detailsTitleProduct_<?php echo $key ?>"
                            value="<?php echo $value["title"] ?>"
                            required
                            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validatejs(event, 'parrafo')">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Acompleta el campo</div>
                        </div>
                        <div class="col-12 col-lg-6 form-group__content input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    Value:
                                </span>
                            </div>
                            <input 
                            class="form-control"
                            type="text"
                            name="detailsValueProduct_<?php echo $key ?>"
                            value="<?php echo $value["value"] ?>"
                            required
                            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validatejs(event, 'parrafo')">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Acompleta el campo</div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button type="button" class="btn btn-primary mb-2 btn-large" onclick="addInput(this,'inputDetails')">Agregar element</button>
            </div>
            <!-- Especificaciones -->
            <div class="form-group">
                <label>Especifications Product<sup class="text-danger">*</sup>EX: <strong>Type:</strong> Color, <strong>Values:</strong> black,green,yelow</label>
                <?php if($editProduct->specifications_product != null): ?>
                    <?php foreach(json_decode($editProduct->specifications_product, true) as $key => $value): ?>
                        <input type="hidden" name="inputEspesifications" value="<?php echo $key + 1?>">
                        <div class="row mb-3 inputEspesifications">
                            <div class="col-12 col-lg-6 form-group__content input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <button type="button" class="btn btn-danger" onclick="removedInput(<?php echo $key ?>,'inputEspesifications')">&times;</button>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Type:
                                    </span>
                                </div>
                                <input 
                                class="form-control"
                                type="text"
                                name="EspesificTypeProduct_<?php echo $key?>"
                                value="<?php echo array_keys($value)[0] ?>"
                                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validatejs(event, 'parrafo')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                            <div class="col-12 col-lg-6 form-group__content input-group">
                                <input 
                                class="form-control tags-input"
                                data-role="tagsinput"
                                type="text"
                                name="EspesificValuesProduct_<?php echo $key ?>"
                                placeholder="Escribe y preciona enter" 
                                value="<?php echo implode(",", array_values($value)[0]) ?>"
                                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validatejs(event, 'parrafo')">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php else: ?>
                    <input type="hidden" name="inputEspesifications" value="1">
                    <div class="row mb-3 inputEspesifications">
                        <div class="col-12 col-lg-6 form-group__content input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <button type="button" class="btn btn-danger" onclick="removedInput(0,'inputEspesifications')">&times;</button>
                                </span>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    Type:
                                </span>
                            </div>
                            <input 
                            class="form-control"
                            type="text"
                            name="EspesificTypeProduct_0"
                            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validatejs(event, 'parrafo')">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Acompleta el campo</div>
                        </div>
                        <div class="col-12 col-lg-6 form-group__content input-group">
                            <input 
                            class="form-control tags-input"
                            data-role="tagsinput"
                            type="text"
                            name="EspesificValuesProduct_0"
                            placeholder="Escribe y preciona enter" 
                            pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validatejs(event, 'parrafo')">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Acompleta el campo</div>
                        </div>
                    </div>
                <?php endif; ?>
                <button type="button" class="btn btn-primary mb-2 btn-large" onclick="addInput(this,'inputEspesifications')">Agregar element</button>
            </div>
            <!-- tags -->
            <div class="form-group">
                <label>Tags Product<sup class="text-danger">*</sup> Ex: uno dos tres....</label>
                <div class="form-group__content input-group mb-3 inputTags">
                    <input 
                    class="form-control tags-input"
                    type="text"
                    data-role="tagsinput"
                    name="tagsinput"
                    value="<?php echo implode(",", json_decode($editProduct->tags_product,true)) ?>"
                    required
                    pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                    onchange="validatejs(event, 'parrafo')">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
            </div>
            <!-- imagen principal -->
            <div class="form-group">
                <label>Imagen Principal Product<sup class="text-danger">*</sup></label>
                <input type="hidden" name="imageProductOld" value="<?php echo $editProduct->image_product; ?>">
                <div class="form-group__content">
                    <label class="pb-5" for="logoProduct">
                        <img src="img/products/<?php echo $editProduct->url_category ?>/<?php echo $editProduct->image_product ?>" class="img-fluid changeProduct" style="width:150px;">
                    </label>
                    <div class="custom-file">
                        <input 
                        type="file"
                        id="logoProduct"
                        class="custom-file-input"
                        name="logoProduct"
                        accept="image/*"
                        maxSize="2000000"
                        onchange="validateImageJs(event,'changeProduct')"
                        >
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">El logo es requerida</div>
                        <label for="logoProduct" class="custom-file-label">Subir</label>
                    </div>
                </div>
            </div>
            <!-- galeria -->
            <label>Galery Product<sup class="text-danger">*</sup></label>
            <div class="dropzone mb-3">
                <?php foreach(json_decode($editProduct->gallery_product, true) as $value): ?>
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image">
                            <img style="width: 100%; height:100%;" src="img/products/<?php echo $editProduct->url_category; ?>/gallery/<?php echo $value; ?>" alt="<?php echo $value; ?>">
                        </div>
                        <a class="dz-remove" data-dz-remove remove="<?php echo $value; ?>" onclick="removeGallery(this)">Remove file</a>
                    </div>
                <?php endforeach; ?>
                <div class="dz-message">
                    Solo puedes subir imagenes que tengan 500 x 500 de tamaño
                </div>
            </div>
            <input type="hidden" name="galeryProduct">
            <input type="hidden" name="galeryProductOld" value=<?php echo $editProduct->gallery_product; ?>>
            <input type="hidden" name="deleteGaleryProduct">
            <!-- banner -->
            <div class="form-group">
                <label>Banner Product<sup class="text-danger">*</sup></label>
                <figure class="pb-5">
                    <img src="img/products/default/example-top-banner.png" alt="img" class="img-fluid">
                </figure>
                <div class="row mb-5">
                    <!-- H3 -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                H3 Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="20%"
                        name="topBannerH3Tag"
                        maxlength="50"
                        value="<?php echo json_decode($editProduct->top_banner_product, true)["H3 tag"]; ?>"
                        required
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- P1 -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                P1 Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="Discount..."
                        name="topBannerP1Tag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->top_banner_product, true)["P1 tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- H4 -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                H4 Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="For Books Of March"
                        name="topBannerH4Tag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->top_banner_product, true)["H4 tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- P2 -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                P2 Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="Enter Promotion"
                        name="topBannerP2Tag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->top_banner_product, true)["P2 tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- Span -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                Span Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="sale2019"
                        name="topBannerSpanTag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->top_banner_product, true)["Span tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- Button -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                Button Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="Shop Now"
                        name="topBannerButtonTag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->top_banner_product, true)["Button tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- imagen -->
                    <div class="col-12">
                        <label>IMG Tag:</label>
                        <input type="hidden" name="topBannerOld" value="<?php echo json_decode($editProduct->top_banner_product, true)["IMG tag"]?>">
                        <div class="form-group__content">
                            <label class="pb-5" for="topBanner">
                                <img src="img/products/<?php echo $editProduct->url_category ?>/top/<?php echo json_decode($editProduct->top_banner_product, true)["IMG tag"]?>" alt="img" class="img-fluid changeTopBanner">
                            </label>
                            <div class="custom-file">
                                <input 
                                type="file"
                                class="custom-file-input"
                                id="topBanner"
                                name="topBanner"
                                accept="image/"
                                maxSize="2000000"
                                onchange="validateImageJs(event,'changeTopBanner')"
                                >
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                                <label for="topBanner" class="custom-file-label">Subir</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- baner por defecto -->
            <div class="form-group">
                <label>Banner Principal Product<sup class="text-danger">*</sup></label>
                <input type="hidden" name="defaultBannerOld" value="<?php echo $editProduct->default_banner_product?>">
                <div class="form-group__content">
                    <label class="pb-5" for="DefaultBanner">
                        <img src="img/products/<?php echo $editProduct->url_category?>/default/<?php echo $editProduct->default_banner_product?>" class="img-fluid changeDefaultBanner" style="width:500px;">
                    </label>
                    <div class="custom-file">
                        <input 
                        type="file"
                        id="DefaultBanner"
                        class="custom-file-input"
                        name="DefaultBanner"
                        accept="image/*"
                        maxSize="2000000"
                        onchange="validateImageJs(event,'changeDefaultBanner')"
                        >
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">El logo es requerida</div>
                        <label for="DefaultBanner" class="custom-file-label">Subir</label>
                    </div>
                </div>
            </div>
            <!-- slide horizontal -->
            <div class="form-group">
                <label>Slider Horizontal Product<sup class="text-danger">*</sup></label>
                <figure class="pb-5">
                    <img src="img/products/default/example-horizontal-slider.png" alt="img" class="img-fluid">
                </figure>
                <div class="row mb-3">
                    <!-- H4 -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                H4 Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="Limit Edition"
                        name="hSliderH4Tag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->horizontal_slider_product, true)["H4 tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- h3-1 -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                H3-1 Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="Happy Summer"
                        name="hSliderH3_1Tag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->horizontal_slider_product, true)["H3-1 tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- H3-2-->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                H3-2 Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="Combo Super Cool"
                        name="hSliderH3_2Tag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->horizontal_slider_product, true)["H3-2 tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- H3-3 -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                H3-3 Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="Up to"
                        name="hSliderH3_3Tag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->horizontal_slider_product, true)["H3-3 tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- H3-4s -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                H3-4s Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="40%"
                        name="hSliderH3_4Tag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->horizontal_slider_product, true)["H3-4s tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- Button -->
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0 mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                Button Tag:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        placeholder="Shop Now"
                        name="hSliderButtonTag"
                        maxlength="50"
                        required
                        value="<?php echo json_decode($editProduct->horizontal_slider_product, true)["Button tag"]; ?>"
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- imagen -->
                    <div class="col-12">
                        <label>IMG Tag:</label>
                        <input type="hidden" name="horizontalSliderOld" value="<?php echo json_decode($editProduct->horizontal_slider_product, true)["IMG tag"]?>">
                        <div class="form-group__content">
                            <label class="pb-5" for="hSlider">
                                <img src="img/products/<?php echo $editProduct->url_category ?>/horizontal/<?php echo json_decode($editProduct->horizontal_slider_product, true)["IMG tag"]?>" alt="img" class="img-fluid changehSlider">
                            </label>
                            <div class="custom-file">
                                <input 
                                type="file"
                                class="custom-file-input"
                                id="hSlider"
                                name="hSlider"
                                accept="image/"
                                maxSize="2000000"
                                onchange="validateImageJs(event,'changehSlider')"
                                >
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Acompleta el campo</div>
                                <label for="hSlider" class="custom-file-label">Subir</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- lider vertical por defecto -->
            <div class="form-group">
                <label>Slider Vertical Product<sup class="text-danger">*</sup></label>
                <input type="hidden" name="verticalSliderOld" value="<?php echo $editProduct->vertical_slider_product?>">
                <div class="form-group__content">
                    <label class="pb-5" for="vSlider">
                        <img src="img/products/<?php echo $editProduct->url_category ?>/vertical/<?php echo $editProduct->vertical_slider_product?>" class="img-fluid changevSlider" style="width:260px;">
                    </label>
                    <div class="custom-file">
                        <input 
                        type="file"
                        id="vSlider"
                        class="custom-file-input "
                        name="vSlider"
                        accept="image/*"
                        maxSize="2000000"
                        onchange="validateImageJs(event,'changevSlider')"
                        >
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">El logo es requerida</div>
                        <label for="vSlider" class="custom-file-label">Subir</label>
                    </div>
                </div>
            </div>
            <!-- video -->
            <div class="form-group">
                <label>Video Product Ex: <strong>Type: </strong>Youtube, <strong>Id:</strong> 2h3h2h2b3</label>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0 pr-0">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                Type:
                            </span>
                        </div>
                        <select name="type_video" class="form-control">
                            <?php if($editProduct->video_product != null): ?>
                                <?php if(json_decode($editProduct->video_product, true)[0] == "youtube"): ?>
                                    <option value="youtube">YouTube</option>
                                    <option value="vimeo">Vimeo</option>
                                <?php else: ?>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="youtube">YouTube</option>
                                <?php endif; ?>
                            <?php else: ?>
                            <option value="">Select Platform</option>
                            <option value="youtube">YouTube</option>
                            <option value="vimeo">Vimeo</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 form-group__content input-group mx-0">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                Id:
                            </span>
                        </div>
                        <input 
                        type="text"
                        class="form-control"
                        name="id_video"
                        maxlength="100"
                        <?php if($editProduct->video_product != null): ?>
                        value="<?php echo json_decode($editProduct->video_product, true)[1] ?>"
                        <?php endif; ?>
                        pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validatejs(event, 'parrafo')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                </div>
            </div>
            <!-- pv, pe, envio, stock -->
            <div class="form-group">
                <div class="row mb-3">
                    <!-- precio venta -->
                    <div class="col-12 col-lg-3">
                        <label>Price Product <sup class="text-danger">*</sup></label>
                        <div class="form-group__content input-group mx-0 pr-0">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    Price $:
                                </span>
                            </div>
                            <input 
                            type="number"
                            class="form-control"
                            name="price"
                            min="0"
                            step="any"
                            value="<?php echo $editProduct->price_product ?>"
                            pattern = "[.\\,\\0-9]{1,}"
                            onchange="validatejs(event, 'numbers')"
                            required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Acompleta el campo</div>
                        </div>
                    </div>
                    <!-- envio -->
                    <div class="col-12 col-lg-3">
                        <label>Envio Product <sup class="text-danger">*</sup></label>
                        <div class="form-group__content input-group mx-0 pr-0">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    Envio $:
                                </span>
                            </div>
                            <input 
                            type="number"
                            class="form-control"
                            name="envio"
                            min="0"
                            step="any"
                            value="<?php echo $editProduct->shipping_product ?>"
                            pattern = "[.\\,\\0-9]{1,}"
                            onchange="validatejs(event, 'numbers')"
                            required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Acompleta el campo</div>
                        </div>
                    </div>
                    <!-- dias de entrega -->
                    <div class="col-12 col-lg-3">
                        <label>Delivery time Product <sup class="text-danger">*</sup></label>
                        <div class="form-group__content input-group mx-0 pr-0">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    Entregar en:
                                </span>
                            </div>
                            <input 
                            type="number"
                            class="form-control"
                            name="entrega"
                            min="0"
                            pattern = "[0-9]{1,}"
                            value="<?php echo $editProduct->delivery_time_product ?>"
                            onchange="validatejs(event, 'numbers')"
                            required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Acompleta el campo</div>
                        </div>
                    </div>
                    <!-- stock -->
                    <div class="col-12 col-lg-3">
                        <label>Stock Product <sup class="text-danger">*</sup> (MAX: 100 unit)</label>
                        <div class="form-group__content input-group mx-0 pr-0">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    Stock:
                                </span>
                            </div>
                            <input 
                            type="number"
                            class="form-control"
                            name="stock"
                            min="0"
                            max="100"
                            pattern = "[0-9]{1,}"
                            value="<?php echo $editProduct->stock_product ?>"
                            onchange="validatejs(event, 'numbers')"
                            required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Acompleta el campo</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- oferta -->
            <div class="form-group">
                <label>Offer Product Ex: <strong>Type: </strong>Discount, <strong>Percent %: </strong>25, <strong>end ofer: </strong>10/10/2020</label>
                <div class="row mb-3">
                    <div class="form-group__content input-group col-12 col-lg-4 mx-0 pr-0">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                Type:
                            </span>
                        </div>
                        <select name="type_offer" class="form-control" onchange="changeOfer(event)">
                            <?php if($editProduct->offer_product != null): ?>
                                <?php if( json_decode($editProduct->offer_product, true)[0] == "Discount"): ?>
                                    <option value="Discount">Discount</option>
                                    <option value="Fixed">Fixed</option>
                                <?php else: ?>
                                    <option value="Fixed">Fixed</option>
                                    <option value="Discount">Discount</option>
                                <?php endif; ?>
                            <?php else: ?>
                                <option value="">Select Discount</option>
                                <option value="Discount">Discount</option>
                                <option value="Fixed">Fixed</option>
                            <?php endif;?>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- porcentaje -->
                    <div class="form-group__content input-group col-12 col-lg-4 mx-0 pr-0">
                        <div class="input-group-append">
                        <?php if($editProduct->offer_product != null): ?>
                            <?php if( json_decode($editProduct->offer_product, true)[0] == "Discount"): ?>
                                <span class="input-group-text typeOffer">
                                Percent %:
                                 </span>
                            <?php else: ?>
                                <span class="input-group-text typeOffer">
                                Price $:
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="input-group-text typeOffer">
                                Percent %:
                            </span>
                        <?php endif;?>    
                        </div>
                        <input 
                        type="number"
                        class="form-control"
                        name="valueOffer"
                        min="0"
                        step="any"
                        <?php if($editProduct->offer_product != null): ?>
                        value="<?php echo json_decode($editProduct->offer_product, true)[1] ?>"
                        <?php endif; ?>
                        pattern = "[0-9]{1,}"
                        onchange="validatejs(event, 'numbers')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                    <!-- time -->
                    <div class="form-group__content input-group col-12 col-lg-4 mx-0 pr-0">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                End Offer:
                            </span>
                        </div>
                        <input 
                        type="date"
                        class="form-control"
                        name="dateOffer"
                        <?php if($editProduct->offer_product != null): ?>
                        value="<?php echo json_decode($editProduct->offer_product, true)[2] ?>"
                        <?php endif; ?>>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                </div>
            </div>
    
        </div>
        <div class="modal-footer">
            <div class="form-group submit">
                <button class="ps-btn ps-btn-fullwidth" type="submit">Editar</button>
                <?php 
                    $editProduct =new ControllerVendor();
                    $editProduct->editProduct();
                ?>
            </div>
        </div>
    </div>
</form>
<?php endif; ?>