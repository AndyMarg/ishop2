<!-- START: breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li>Авторизация</li>
            </ol>
        </div>
    </div>
</div>
<!-- END: breadcrumbs -->

<!-- START: user registration form -->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12">
                <div class="product-one signup">
                    <div class="register-top heading">
                        <h2>АВТОРИЗАЦИЯ</h2>
                    </div>

                    <div class="register-main">
                        <div class="col-md-6 account-left">
                            <?php $user = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : null; ?>
                            <form method="post" action="user/login/?redirect=root" id="signup" role="form" data-toggle="validator">
                                <div class="form-group has-feedback">
                                    <label for="login">Логин</label>
                                    <input type="text" name="login" class="form-control" id="login" placeholder="Логин"
                                           value="<?=$user['login'] ?: ''?>" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="pasword">Пароль</label>
                                    <input type="password" name="password" class="form-control" id="pasword" placeholder="Пароль"
                                           data-minlength="6" data-error="Пароль должен включать не менее 6 символов" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <button type="submit" class="btn btn-default">Вход</button>
                            </form>
                            <?php if(isset($_SESSION['form_data'])) unset($_SESSION['form_data']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: user registration form -->
