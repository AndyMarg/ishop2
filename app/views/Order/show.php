<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Заказ товара</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->

<!-- START: order-info -->
<div class="order-info">
    <div class="container">
        <div class="col-md-12">
            <h2 class="text-center">Оформление заказа</h2>
            <?php if (!empty($cart->products)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Фото</th>
                            <th>Наименование</th>
                            <th>Количество</th>
                            <th>Цена</th>
                            <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($cart->products as $id => $product): ?>
                            <tr>
                                <td><a href="product/<?= $product['alias'] ?>"><img class="cart-image"
                                                                                    src="images/<?= $product['img'] ?>"
                                                                                    alt=""></a></td>
                                <td><a href="product/<?= $product['alias'] ?>"><?= $product['title'] ?></a></td>
                                <td><?= $product['quantity'] ?></td>
                                <td>
                                    <?= $currency->symbol_left ?>
                                    <?= $product['price'] * $currency->value ?>
                                    <?= $currency->symbol_right ?>
                                </td>
                                <td><span data-id="<?= $id ?>"
                                          class="glyphicon glyphicon-remove text-danger delete-product"
                                          aria-hidden="true" onclick="deleteProductFromOrder(<?= $id ?>)"></span></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Итого:</td>
                            <td colspan="4" class="text-right cart-quantity"><?= $cart->quantity ?></td>
                        </tr>
                        <tr>
                            <td>На сумму:</td>
                            <td colspan="4" class="text-right cart-sum">
                                <?= $currency->symbol_left ?>
                                <?= $cart->sum * $currency->value ?>
                                <?= $currency->symbol_right ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <h3 id="cart_is_empty">Корзина пуста</h3>
            <?php endif; ?>

            <form method="post" action="order/add" name="order-add" role="form">
                <div class="form-group">
                    <label for="note">Примечание</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
                <button id="do-order" type="button" class="btn btn-default" onclick="addOrder()">Оформить</button>
            </form>

        </div>
    </div>
</div>
<!-- END: order-info-->

<!-- START: signup modal window -->
<div id="window-signup" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Регистрация покупателя</h4>
            </div>
            <div class="modal-body">
                <!-- START: user registration form -->
                <div class="container">
                    <div class="row">
                        <div class="register-main">
                            <div class="col-md-9">
                                <?php $user = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : null; ?>
                                <form method="post" action="user/signup" id="signup" role="form"
                                      data-toggle="validator">
                                    <div class="form-group has-feedback">
                                        <label for="login">Логин</label>
                                        <input type="text" name="login" class="form-control" id="login"
                                               placeholder="Логин"
                                               value="<?= $user['login'] ?: '' ?>" required>
                                        <span class="glyphicon form-control-feedback"
                                              aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pasword">Пароль</label>
                                        <input type="password" name="password" class="form-control"
                                               id="pasword" placeholder="Пароль"
                                               data-minlength="6"
                                               data-error="Пароль должен включать не менее 6 символов"
                                               required>
                                        <span class="glyphicon form-control-feedback"
                                              aria-hidden="true"></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="name">Имя</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="Имя"
                                               value="<?= $user['name'] ?: '' ?>" required>
                                        <span class="glyphicon form-control-feedback"
                                              aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                               placeholder="Email"
                                               value="<?= $user['email'] ?: '' ?>" required>
                                        <span class="glyphicon form-control-feedback"
                                              aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="address">Адрес</label>
                                        <input type="text" name="address" class="form-control" id="address"
                                               placeholder="Адрес"
                                               value="<?= $user['address'] ?: '' ?>" required>
                                        <span class="glyphicon form-control-feedback"
                                              aria-hidden="true"></span>
                                    </div>
                                    <button type="submit" class="btn btn-default">Зарегистрировать</button>
                                </form>
                                <?php if (isset($_SESSION['form_data'])) unset($_SESSION['form_data']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: user registration form -->
            </div>
            <div class="modal-footer">
                <button id="authority-btn-close" type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<!-- END: signup modal window -->

<!-- START: login modal window -->
<div id="window-login" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Вход</h4>
            </div>
            <div class="modal-body">
                <!-- START: user registration form -->
                <div class="container">
                    <div class="row">
                        <div class="register-main">
                            <div class="col-md-9">
                                <?php $user = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : null; ?>
                                <form method="post" action="user/login" id="signup" role="form"
                                      data-toggle="validator">
                                    <div class="form-group has-feedback">
                                        <label for="login">Логин</label>
                                        <input type="text" name="login" class="form-control" id="login"
                                               placeholder="Логин"
                                               value="<?= $user['login'] ?: '' ?>" required>
                                        <span class="glyphicon form-control-feedback"
                                              aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="pasword">Пароль</label>
                                        <input type="password" name="password" class="form-control"
                                               id="pasword" placeholder="Пароль"
                                               data-minlength="6"
                                               data-error="Пароль должен включать не менее 6 символов"
                                               required>
                                        <span class="glyphicon form-control-feedback"
                                              aria-hidden="true"></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <button type="submit" class="btn btn-default">Войти</button>
                                </form>
                                <?php if (isset($_SESSION['form_data'])) unset($_SESSION['form_data']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: user registration form -->
            </div>
            <div class="modal-footer">
                <button id="authority-btn-close" type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<!-- END: login modal window -->
