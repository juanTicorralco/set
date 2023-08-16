<!-- <div class="tab-pane container fade" id="crearProduct"> -->
<div class="tab-pane container fade" id="crearStore">
     <!-- Modal header -->
     <div class="modal-header">
        <h4 class="modal-title text-center">3.- CREAR PRODUCTO</h4>
    </div>
    <div class="modal-body text-left p-5">
        <!-- name store -->
        <div class="form-group">
            <label>Product name<sup class="text-danger">*</sup></label>
            <div class="form-group__content">
                <input 
                type="text"
                class="form-control"
                name="nameProduct"
                placeholder="Nombre de tu producto..." 
                required 
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
                name="urlProduct"
                placeholder="URL de tu Producto..."
                readonly 
                required >
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">El nombre es requerido</div>
            </div>
        </div>
        <!-- Categories -->
        <div class="form-group">
            <label>Product Category<sup class="text-danger">*</sup></label>
            <?php
                $url = CurlController::api()."categories?select=id_category,name_category,url_category";
                $method= "GET";
                $header= array();
                $fields= array();
                
                $Categories= CurlController::request($url, $method, $header, $fields)->result;
            ?>
            <div class="form-group__content">
                <select 
                class="form-control"
                name="categoryProduct"
                onchange="changecategory(event)"
                required>
                    <option value="">Select Category</option>
                    <?php foreach($Categories as $key => $value):?>
                        <option value="<?php echo $value->id_category."_".$value->url_category; ?>"><?php echo $value->name_category; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">El nombre es requerido</div>
            </div>
        </div>
        <!-- Subcategories -->
        <div class="form-group subcategoryProduct" style="display: none ;">
            <label>Product Subcategory<sup class="text-danger">*</sup></label>
            <div class="form-group__content">
                <select 
                    class="form-control"
                    name="subcategoryProduct"
                    required>
                    <option value="">Select Subcategory</option>
                </select>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">El nombre es requerido</div>
            </div>
        </div>
        <!-- description -->
        <div class="form-group">
            <label>Description Product<sup class="text-danger">*</sup></label>
            <div class="form-group__content">
                <textarea class="summernote" name="descriptionProduct" required></textarea>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Acompleta el campo</div>
            </div>
        </div>
        <!-- resumen -->
        <div class="form-group">
            <label>Sumary Product<sup class="text-danger">*</sup> Ex: 20 hras de portabilidad</label>
            <div class="form-group__content input-group mb-3 inputSummary">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <button type="button" class="btn btn-danger" onclick="removedInput(0,'inputSummary')">&times;</button>
                    </span>
                </div>
                <input 
                class="form-control"
                type="text"
                name="summaryProduct_0"
                required
                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                onchange="validatejs(event, 'parrafo')">
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Acompleta el campo</div>
            </div>
            <button type="button" class="btn btn-primary mb-2 btn-large" onclick="addInput(this,'inputSummary')">Agregar</button>
        </div>
        <!-- details -->
        <div class="form-group">
            <label>Details Product<sup class="text-danger">*</sup>EX: <strong>title:</strong> Bloutwe, <strong>Value:</strong> yes</label>
            <div class="row mb-3 inputDetails">
                <div class="col-12 col-lg-6 form-group__content input-group">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <button type="button" class="btn btn-danger" onclick="removedInput(0,'inputDetails')">&times;</button>
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
                    name="detailsTitleProduct_0"
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
                    name="detailsValueProduct_0"
                    required
                    pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                    onchange="validatejs(event, 'parrafo')">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mb-2 btn-large" onclick="addInput(this,'inputDetails')">Agregar element</button>
        </div>
        <!-- Especificaciones -->
        <div class="form-group">
            <label>Especifications Product<sup class="text-danger">*</sup>EX: <strong>Type:</strong> Color, <strong>Values:</strong> black,green,yelow</label>
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
                    required
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
                    required
                    pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                    onchange="validatejs(event, 'parrafo')">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
            </div>
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
            <div class="form-group__content">
                <label class="pb-5" for="logoProduct">
                    <img src="img/products/default/default-image.jpg" class="img-fluid changeProduct" style="width:150px;">
                </label>
                <div class="custom-file">
                    <input 
                    type="file"
                    id="logoProduct"
                    class="custom-file-input formStore"
                    name="logoProduct"
                    accept="image/*"
                    maxSize="2000000"
                    onchange="validateImageJs(event,'changeProduct')"
                    required>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">El logo es requerida</div>
                    <label for="logoProduct" class="custom-file-label">Subir</label>
                </div>
            </div>
        </div>
        <!-- galeria -->
        <label>Galery Product<sup class="text-danger">*</sup></label>
        <div class="dropzone mb-3">
            <div class="dz-message">
                Solo puedes subir imagenes que tengan 500 x 500 de tamaño
            </div>
        </div>
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
                    pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                    onchange="validatejs(event, 'parrafo')">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
                <!-- imagen -->
                <div class="col-12">
                    <label>IMG Tag:</label>
                    <div class="form-group__content">
                        <label class="pb-5" for="topBanner">
                            <img src="img/products/default/default-top-banner.jpg" alt="img" class="img-fluid changeTopBanner">
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
                            required>
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
            <div class="form-group__content">
                <label class="pb-5" for="DefaultBanner">
                    <img src="img/products/default/default-banner.jpg" class="img-fluid changeDefaultBanner" style="width:500px;">
                </label>
                <div class="custom-file">
                    <input 
                    type="file"
                    id="DefaultBanner"
                    class="custom-file-input formStore"
                    name="DefaultBanner"
                    accept="image/*"
                    maxSize="2000000"
                    onchange="validateImageJs(event,'changeDefaultBanner')"
                    required>
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
                    pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                    onchange="validatejs(event, 'parrafo')">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
                <!-- imagen -->
                <div class="col-12">
                    <label>IMG Tag:</label>
                    <div class="form-group__content">
                        <label class="pb-5" for="hSlider">
                            <img src="img/products/default/default-horizontal-slider.jpg" alt="img" class="img-fluid changehSlider">
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
                            required>
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
            <div class="form-group__content">
                <label class="pb-5" for="vSlider">
                    <img src="img/products/default/default-vertical-slider.jpg" class="img-fluid changevSlider" style="width:260px;">
                </label>
                <div class="custom-file">
                    <input 
                    type="file"
                    id="vSlider"
                    class="custom-file-input formStore"
                    name="vSlider"
                    accept="image/*"
                    maxSize="2000000"
                    onchange="validateImageJs(event,'changevSlider')"
                    required>
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
                        <option value="">Select Platform</option>
                        <option value="youtube">YouTube</option>
                        <option value="vimeo">Vimeo</option>
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
                        pattern = "[.\\,\\0-9]{1,}"
                        onchange="validatejs(event, 'numbers')"
                        required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                </div>
                <!-- dias de entrega -->
                <div class="col-12 col-lg-3">
                    <label>Price Product <sup class="text-danger">*</sup></label>
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
                        onchange="validatejs(event, 'numbers')"
                        required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Acompleta el campo</div>
                    </div>
                </div>
                <!-- precio venta -->
                <div class="col-12 col-lg-3">
                    <label>Price Product <sup class="text-danger">*</sup> (MAX: 100 unit)</label>
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
                        <option value="">Select Discount</option>
                        <option value="Discount">Discount</option>
                        <option value="Fixed">Fixed</option>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
                <!-- porcentaje -->
                <div class="form-group__content input-group col-12 col-lg-4 mx-0 pr-0">
                    <div class="input-group-append">
                        <span class="input-group-text typeOffer">
                            Percent %:
                        </span>
                    </div>
                    <input 
                    type="number"
                    class="form-control"
                    name="valueOffer"
                    min="0"
                    step="any"
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
                    name="dateOffer">
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Acompleta el campo</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="form-group submit">
            <button class="ps-btn ps-btn-fullwidth" type="submit">Crear</button>
            <?php 
                $newVendor = new ControllerVendor();
                $newVendor->newProduct(1);
            ?>
        </div>
    </div>
</div>