<?php
$user = \app\models\User::get();
$cart = app\models\Cart::get();
$currency = (new app\models\Currencies())->current;
?>

<!DOCTYPE html>
<html>
<head>
    <base href="/">
    <?= $this->getMetaHtml(); ?>
    <script src="js/jquery-1.11.0.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/megamenu.css">
    <!--theme-style-->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<!--top-header-->
<div class="top-header">
    <div class="container">
        <div class="top-header-main">
            <div class="col-md-6 top-header-left">
                <div class="drop">
                    <div class="box">
                        <select id="currency" tabindex="4" class="dropdown drop">
                            <?php new \app\widgets\currency\Currency(); ?>
                        </select>
                    </div>
                    <div class="btn-group">
                        <a id="user-menu" class="dropdown-toggle" data-toggle="dropdown"
                           data-id="<?= isset($user) && $user->isPersisted() ? $user->id : '' ?>">
                            <?= isset($user) ? $user->name : 'Неавторизованный пользователь' ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if (isset($user) && $user->isPersisted()): ?>
                                <li><a href="user/logout">Выход</a></li>
                            <?php else: ?>
                                <li><a href="user/login">Вход</a></li>
                                <li><a href="user/signup">Регистрация</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6 top-header-left">
                <div class="cart box_1">
                    <a href="cart/show" onclick="getCart(); return false;">
                        <div class="total">
                            <img src="images/cart-1.png" alt=""/>
                            <?php if (!empty($cart->products)): ?>
                                <span class="simpleCart_total">
                                    <?php echo $currency->symbol_left . $cart->sum * $currency->value . $currency->symbol_right ?>
                                </span>
                            <?php else: ?>
                                <span class="simpleCart_total">Корзина пуста</span>
                            <?php endif; ?>

                        </div>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!--top-header-->
<!--start-logo-->
<div class="logo">
    <a href="<?= \core\base\Application::getConfig()->dirs->root ?>"><h1>Luxury Watches</h1></a>
</div>
<!--start-logo-->
<!--bottom-header-->
<div class="header-bottom">
    <div class="container">
        <div class="header">
            <div class="col-md-9 header-left">
                <div class="menu-container">
                    <div class="menu">
                        <?php
                        $menu = new app\widgets\menu\Menu(
                            (new app\models\Categories())->asArray(true),
                            [
                                'htmlAttributes' => [
                                    'style' => 'color: red;'
                                ]
                            ]
                        );
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3 header-right">
                <div class="search-bar">
                    <form action="search" method="get" autocomplete="off">
                        <input type="text" id="typeahead" class="typeahead" name="search_value"
                               value="Поиск"
                               onfocus="this.value = '';"
                               onblur="if (this.value === '') {this.value = 'Поиск';}">
                        <input type="submit" value="">
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!--bottom-header-->

    <div class="content">
        <!-- Validation errors -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if (isset($_SESSION['errors'])): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($_SESSION['errors'] as $error_list): ?>
                                <ul>
                                    <?php foreach ($error_list as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['errors']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['success'] ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>


                </div>
            </div>
        </div>

        <!-- Content -->
        <?= $content; ?>

    </div>

    <!--information-starts-->
    <div class="information">
        <div class="container">
            <div class="infor-top">
                <div class="col-md-3 infor-left">
                    <h3>Follow Us</h3>
                    <ul>
                        <li><a href="#"><span class="fb"></span><h6>Facebook</h6></a></li>
                        <li><a href="#"><span class="twit"></span><h6>Twitter</h6></a></li>
                        <li><a href="#"><span class="google"></span><h6>Google+</h6></a></li>
                    </ul>
                </div>
                <div class="col-md-3 infor-left">
                    <h3>Information</h3>
                    <ul>
                        <li><a href="#"><p>Specials</p></a></li>
                        <li><a href="#"><p>New Products</p></a></li>
                        <li><a href="#"><p>Our Stores</p></a></li>
                        <li><a href="contact.html"><p>Contact Us</p></a></li>
                        <li><a href="#"><p>Top Sellers</p></a></li>
                    </ul>
                </div>
                <div class="col-md-3 infor-left">
                    <h3>My Account</h3>
                    <ul>
                        <li><a href="account.html"><p>My Account</p></a></li>
                        <li><a href="#"><p>My Credit slips</p></a></li>
                        <li><a href="#"><p>My Merchandise returns</p></a></li>
                        <li><a href="#"><p>My Personal info</p></a></li>
                        <li><a href="#"><p>My Addresses</p></a></li>
                    </ul>
                </div>
                <div class="col-md-3 infor-left">
                    <h3>Store Information</h3>
                    <h4>The company name,
                        <span>Lorem ipsum dolor,</span>
                        Glasglow Dr 40 Fe 72.</h4>
                    <h5>+955 123 4567</h5>
                    <p><a href="mailto:example@email.com">contact@example.com</a></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!--information-end-->
    <!--footer-starts-->
    <div class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="col-md-6 footer-left">
                    <form>
                        <input type="text" value="Enter Your Email" onfocus="this.value = '';"
                               onblur="if (this.value === '') {this.value = 'Enter Your Email';}">
                        <input type="submit" value="Subscribe">
                    </form>
                </div>
                <div class="col-md-6 footer-right">
                    <p>© 2015 Luxury Watches. All Rights Reserved | Design by <a href="http://w3layouts.com/"
                                                                                 target="_blank">W3layouts</a></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!--footer-end-->

    <?php
    // отладочная информация по запросам
    if (core\base\Application::getConfig()->db->debug) {
        echo \core\base\Application::getDb()->getLogHtml();
    }
    ?>
    <!-- START: Cart modal window -->
    <div id="cart" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Корзина</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button id="cart-btn-close" type="button" class="btn btn-default" data-dismiss="modal">Продолжить
                        покупки
                    </button>
                    <a id="cart-btn-order" href="order/show" type="button" class="btn btn-primary">Оформить заказ</a>
                    <button id="cart-btn-clear" type="button" class="btn btn-danger" onclick="clearCart()">Очистить
                        корзину
                    </button>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->
    <!-- END: Cart modal window -->

    <!-- START: Not authority warning modal window -->
    <div id="modal-not-authority-warning" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Уважаемый покупатель, Вы не авторизованы в интернет-магазине!</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Для того, чтобы оформить заказ Вам необходимо либо авторизоваться,
                        если у вас уже есть учетные данные, либо зарегистрововаться  в интернет-магазине
                    </p>
                </div>
                <div class="modal-footer">
                    <button id="cart-btn-close" type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button id="cart-btn-signup" type="button" class="btn btn-primary"
                            onclick="$('#modal-not-authority-warning').modal('hide'); setTimeout(function(){$('#window-login').modal('show')}, 1000);">Войти
                    </button>
                    <button id="cart-btn-signup" type="button" class="btn btn-primary"
                            onclick="$('#modal-not-authority-warning').modal('hide'); setTimeout(function(){$('#window-signup').modal('show')}, 1000);">Зарегистрироваться
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Not authority warning modal window -->

    <!--scripts-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/typeahead.bundle.js"></script>
    <script src="js/validator.js"></script>


    <script src="js/megamenu.js"></script>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!--dropdown-->
    <script src="js/jquery.easydropdown.js"></script>
    <!--Slider-Starts-Here-->
    <script src="js/responsiveslides.min.js"></script>
    <script>
        // You can also use "$(window).load(function() {"
        $(function () {
            // Slideshow 4
            $("#slider4").responsiveSlides({
                auto: true,
                pager: true,
                nav: true,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                    $('.events').append("<li>after event fired.</li>");
                }
            });

        });
    </script>
    <!--dropdown accordeon-->
    <script type="text/javascript">
        $(function () {

            var menu_ul = $('.menu_drop > li > ul'),
                menu_a = $('.menu_drop > li > a');

            menu_ul.hide();

            menu_a.click(function (e) {
                e.preventDefault();
                if (!$(this).hasClass('active')) {
                    menu_a.removeClass('active');
                    menu_ul.filter(':visible').slideUp('normal');
                    $(this).addClass('active').next().stop(true, true).slideDown('normal');
                } else {
                    $(this).removeClass('active');
                    $(this).next().stop(true, true).slideUp('normal');
                }
            });

        });
    </script>
    <script src="js/main.js"></script>

    <?php $this->insertScripts(); ?>

</body>
</html>