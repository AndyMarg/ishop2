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

<div class="container">
    <?php if(!empty($cart->products)): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <row>
                <th>Фото</th>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Цена</th>
                <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
            </row>
            </thead>
            <tbody>
            <?php foreach ($cart->products as $id => $product): ?>
                <tr>
                    <td><a href="product/<?=$product['alias']?>"><img class="cart-image" src="images/<?=$product['img']?>" alt=""></a></td>
                    <td><a href="product/<?=$product['alias']?>"><?=$product['title']?></a></td>
                    <td><?=$product['quantity']?></td>
                    <td>
                        <?= $currency->symbol_left?>
                        <?=$product['price'] * $currency->value?>
                        <?= $currency->symbol_right?>
                    </td>
                    <td><span data-id="<?=$id?>" class="glyphicon glyphicon-remove text-danger delete-product" aria-hidden="true"></span></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td>Итого:</td>
                <td colspan="4" class="text-right cart-quantity"><?=$cart->quantity?></td>
            </tr>
            <tr>
                <td>На сумму:</td>
                <td colspan="4" class="text-right cart-sum">
                    <?= $currency->symbol_left?>
                    <?=$cart->sum * $currency->value?>
                    <?= $currency->symbol_right?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <h3 id="cart_is_empty">Корзина пуста</h3>
<?php endif; ?>
</div>

