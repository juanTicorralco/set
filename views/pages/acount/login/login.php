<?php
if (isset($_SESSION['user'])) {
    echo '<script>
            window.location="' . $path . 'acount&wishAcount";
    </script>';
    return;
}
?>
<!--=====================================
Login - Register Content
======================================-->

<div class="ps-my-account">

    <div class="container">

        <?php
        /* Verificacion del correo electronico */

        if (isset($urlParams[2])) {
            $verify = base64_decode($urlParams[2]);

            $url = CurlController::api() . "users?linkTo=email_user&equalTo=" . $verify . "&select=id_user";
            $metod = "GET";
            $header = array();
            $fields = array();

            $resultVerify = CurlController::request($url, $metod, $header, $fields);
        
            if (isset($resultVerify)) {
                if ($resultVerify->status == 200) {
                    $url = CurlController::api() . "users?id=" . $resultVerify->result[0]->id_user . "&nameId=id_user&token=no&except=verificated_user";
                    $metod = "PUT";
                    $header = "verificated_user=1";
                    $fields = array();

                    $veryf = CurlController::request($url, $metod, $header, $fields);

                    if (isset($veryf)) {
                        if ($veryf->status == 200) {

                            echo '<div class="alert alert-success alert-dismissible">Tu Cuenta se VERIFICO CORRECTAMENTE, inicia sesion en tu nueva cuenta <i class="fas fa-laugh-wink"></i></div>
                            <script>
                            formatearAlertas()
                        </script>';
                        }
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible">UPSSS!! hay un error al confirmar tu email, vuelve a intentaro. Si el error persiste vuelve a registrarte!!</div>
                        <script>
                        formatearAlertas()
                    </script>';
                    }
                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible">UPSSS!! hay un error al confirmar tu email, vuelve a intentaro. Si el error persiste vuelve a registrarte!!</div>
                <script>
                formatearAlertas()
            </script>';
            }
        }
        ?>

        <form class="ps-form--account ps-tab-root needs-validation" novalidate method="post">

            <ul class="ps-tab-list">

                <li>
                    <p><a href="<?php echo $path ?>acount&login">Mi Cuenta</a></p>
                </li>

                <li class="active">
                    <p><a href="<?php echo $path ?>acount&enrollment">Registrarse</a></p>
                </li>

            </ul>

            <div class="ps-tabs">

                <!--=====================================
                Login Form
                ======================================-->

                <div class="ps-tab active" id="sign-in">

                    <div class="ps-form__content">

                        <h5>Entrar a mi cuenta</h5>

                        <div class="form-group">

                            <input class="form-control" type="email" name="logEmail" placeholder="Email..." required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" onchange="validatejs(event, 'email')">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">El email es requerido</div>
                        </div>

                        <div class="form-group form-forgot">

                            <input class="form-control" type="password" name="logPassword" placeholder="Password..." required pattern="[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}" onchange="validatejs(event, 'passEnt')">
                            <a href="#resetUserPassword" data-toggle="modal">Recuperar</a>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">El password es requerido</div>

                        </div>

                        <div class="form-group">

                            <div class="ps-checkbox">

                                <input class="form-control" type="checkbox" id="remember-me" name="remember-me" onchange="rememberme(event)">
                                <label for="remember-me">Reconrdar</label>

                            </div>

                        </div>

                        <div class="form-group submtit">

                            <button type="submit" class="ps-btn ps-btn--fullwidth">Entrar</button>

                        </div>

                        <?php
                        $login = new ControllerUser();
                        $login->login();
                        ?>

                    </div>

                    <div class="ps-form__footer">

                        <!-- <p>Entrar a mi cuenta con:</p> -->

                        <ul class="ps-list--social">

                            <!-- <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a class="google" href="#"><i class="fab fa-google"></i></a></li> -->

                        </ul>

                    </div>

                </div><!-- End Login Form -->

            </div>

        </form>

    </div>

</div>

<!-- The Modal -->
<div class="modal" id="resetUserPassword">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Resetear Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" class="ps-form--account ps-tab-root needs-validation" novalidate>
                    <div class="form-group">

                        <input class="form-control" type="email" name="resetPassword" placeholder="Email..." required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" onchange="validatejs(event, 'email')">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">El email es requerido</div>
                    </div>

                    <div class="form-group submtit">

                        <button type="submit" class="ps-btn ps-btn--fullwidth">Enviar</button>

                        <?php
                            $reset= new ControllerUser();
                            $reset->resetPassword();
                        ?>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>