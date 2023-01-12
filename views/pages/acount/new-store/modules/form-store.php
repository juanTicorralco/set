<div class="tab-pane container fade" id="crearStore">
     <!-- Modal header -->
     <div class="modal-header">
        <h4 class="modal-title text-center">2.- CREAR TIENDA</h4>
    </div>

    <div class="modal-body text-left p-5">
        <!-- name store -->
        <div class="form-group">
            <label>Store name<sup class="text-danger">*</sup></label>
            <div class="form-group__content">
                <input 
                type="text"
                class="form-control formStore"
                name="nameStore"
                placeholder="Nombre de tu tienda..." 
                required 
                pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}" 
                onchange="dataRepeat(event, 'store')">
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
                class="form-control formStore"
                name="urlStore"
                placeholder="URL de tu tienda..."
                readonly 
                required >
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">El nombre es requerido</div>
            </div>
        </div>
        <!-- information -->
        <div class="form-group">
            <label>Information Store<sup class="text-danger">*</sup></label>
            <div class="form-group__content">
                <textarea  
                class="form-control formStore"  
                id="infoStore"
                name="infoStore"
                required
                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,10000}'
                onchange="validatejs(event, 'parrafo')"
                rows="7" 
                placeholder="Notes about your store, e.g. special notes for delivery."></textarea>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">La informacion es requerida</div>
            </div>
        </div>
        <!-- email -->
        <div class="form-group">
            <label>Email Address<sup class="text-danger">*</sup></label>
            <div class="form-group__content">
                <input 
                class="form-control formStore" 
                id="emailStore" 
                name="emailStore"
                type="email" 
                value="<?php echo $_SESSION["user"]->email_user; ?>" 
                readonly 
                required>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">El email es requerido</div>
            </div>

        </div>
        <!-- country -->
        <div class="form-group">

            <label>Store Country<sup class="text-danger">*</sup></label>

            <?php
                $data = file_get_contents("views/json/ciudades.json");
                $ciudades= json_decode($data, true);
            ?>

            <div class="form-group__content">

                <select 
                    class="form-control select2 formStore" 
                    style="width: 100%;"
                    id="countryStore"
                    onchange="changeContry(event)"
                    required
                    name="countryStore">
                    <?php if($_SESSION["user"]->country_user != null): ?>
                        <option value="<?php echo $_SESSION["user"]->country_user ?>_<?php echo explode("_",$_SESSION["user"]->phone_user)[0]?>"><?php echo $_SESSION["user"]->country_user ?></option>
                    <?php else: ?>
                        <option value>Select country</option>
                    <?php endif; ?>
                    <?php foreach($ciudades as $key => $value):?>
                        <option value="<?php echo $value["name"] ?>_<?php echo $value["dial_code"] ?>"><?php echo $value["name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">El pais es requerido</div>

            </div>

        </div>
        <!-- city -->
        <div class="form-group">
            <label>City Store<sup>*</sup></label>
            <div class="form-group__content">
                <input 
                class="form-control formStore" 
                id="cityStore"
                type="text"
                name="cityStore"
                pattern = "[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
                onchange="validatejs(event, 'text')" 
                value="<?php echo $_SESSION["user"]->city_user; ?>" 
                required>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">La ciudad es requerida</div>
            </div>
        </div>
        <!-- phone -->
        <div class="form-group">
            <label>Phone Store<sup>*</sup></label>
            <div class="form-group__content input-group">
                <?php if($_SESSION["user"]->phone_user != null): ?>
                <div class="input-group-append">
                    <span class="input-group-text dialCode"><?php echo explode("_",$_SESSION["user"]->phone_user)[0]?></span>
                </div>
                <?php 
                    $phone= explode("_", $_SESSION["user"]->phone_user)[1]; 
                ?>
                <?php else: ?>
                    <div class="input-group-append">
                    <span class="input-group-text dialCode">+--</span>
                </div>
                <?php $phone="" ?>
                <?php endif; ?>
                <input 
                class="form-control formStore" 
                type="text" 
                id="phoneOrder"
                name="phoneOrder"
                pattern = "[-\\(\\)\\0-9 ]{1,}"
                onchange="validatejs(event, 'phone')"
                value="<?php echo $phone; ?>" 
                required>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">El telefono es requerido</div>
            </div>
        </div>
        <!-- addres -->
        <div class="form-group">
            <label>Address Store<sup>*</sup></label>
            <div class="form-group__content">
                <input 
                class="form-control formStore" 
                type="text" 
                id="addresStore"
                name="addresStore"
                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                onchange="validatejs(event, 'parrafo')"
                value="<?php echo $_SESSION["user"]->address_user; ?>" 
                required>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">La direccion es requerida</div>
            </div>
        </div>
        <!-- mapa -->
        <div class="form-group">
            <label>Map Store<sup>*</sup><small> (Puedes mover el marcador para una mejor localizacion)</small></label>
            <div id="myMap" style="height: 400px"></div>
            <input type="hidden" name="mapStore" id="mappp" class="formStore" <?php 
                if(isset( $_SESSION["user"]->map_user)){
                    echo  'value =' . $_SESSION["user"]->map_user;
                }
                ?> >
        </div>
        <!-- Logo -->
        <div class="form-group">
            <label>Logo Store<sup class="text-danger">*</sup></label>
            <div class="form-group__content">
                <label class="pb-5" for="logoStore">
                    <img src="img/stores/default/default-logo.jpg" class="img-fluid changeLogo" style="width:150px;">
                </label>
                <div class="custom-file">
                    <input 
                    type="file"
                    id="logoStore"
                    class="custom-file-input formStore"
                    name="logoStore"
                    accept="image/*"
                    maxSize="2000000"
                    onchange="validateImageJs(event,'changeLogo')"
                    required>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">El logo es requerida</div>
                    <label for="logoStore" class="custom-file-label">Subir</label>
                </div>
            </div>
        </div>
        <!-- portada -->
        <div class="form-group">
            <label>Portada Store<sup class="text-danger">*</sup></label>
            <div class="form-group__content">
                <label class="pb-5" for="portStore">
                    <img src="img/stores/default/default-cover.jpg" class="img-fluid changePort" style="width:100%;">
                </label>
                <div class="custom-file">
                    <input 
                    type="file"
                    id="portStore"
                    class="custom-file-input formStore"
                    name="portStore"
                    accept="image/*"
                    maxSize="2000000"
                    onchange="validateImageJs(event,'changePort')"
                    required>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">La Portada es requerida</div>
                    <label for="portStore" class="custom-file-label">Subir</label>
                </div>
            </div>
        </div>
        <!-- redes -->
        <div class="form-group">
            <label>Social Network<sup class="text-danger">*</sup></label>
            <!-- facebook -->
            <div class="form-group__content input-group mb-5">
                <div class="input-group-append">
                    <span class="input-group-text">https://www.facebook.com/</span>
                </div>
                <input type="text"
                class="form-control"
                name="facebookStore"
                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,10000}'
                onchange="validatejs(event, 'parrafo')"
                placeholder="Tu usuario">
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Este campo es requerido</div>
            </div>
            <!-- youtube -->
            <div class="form-group__content input-group mb-5">
                <div class="input-group-append">
                    <span class="input-group-text">https://www.youtube.com/</span>
                </div>
                <input type="text"
                class="form-control"
                name="youtubeStore"
                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,10000}'
                onchange="validatejs(event, 'parrafo')"
                placeholder="Tu usuario">
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Este campo es requerido</div>
            </div>
            <!-- instagram -->
            <div class="form-group__content input-group mb-5">
                <div class="input-group-append">
                    <span class="input-group-text">https://www.instagram.com/</span>
                </div>
                <input type="text"
                class="form-control"
                name="instagramStore"
                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,10000}'
                onchange="validatejs(event, 'parrafo')"
                placeholder="Tu usuario">
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Este campo es requerido</div>
            </div>
            <!-- twitter -->
            <div class="form-group__content input-group mb-5">
                <div class="input-group-append">
                    <span class="input-group-text">https://twitter.com/</span>
                </div>
                <input type="text"
                class="form-control"
                name="twitterStore"
                pattern = '[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,10000}'
                onchange="validatejs(event, 'parrafo')"
                placeholder="Tu usuario">
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Este campo es requerido</div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-lg" onclick="validarStore()">Crear</button>
    </div>
</div>