<?php
$admin_path = \core\base\Application::getConfig()->dirs->admin;
$www_path = \core\base\Application::getConfig()->dirs->www;
?>

<section class="content-header">
    <h1>Заказ № <?=$order->id?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= $admin_path ?>"><i class="fa fa-home"></i> Главная</a></li>
        <li><a href="<?= $admin_path ?>/orders"><i class="fa fa-home"></i> Заказы</a></li>
        <li class="active"> Заказ № <?= $order->id ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tbody>
                                <tr><td>Номер заказа</td><td><?=$order->id?></td></tr>
                                <tr><td>Дата заказа</td><td><?=$order->date?></td></tr>
                                <tr><td>Дата изменения</td><td><?=$order->update_at?></td></tr>
                                <tr><td>Позиций в заказе</td><td><?=$order->cnt?></td></tr>
                                <tr><td>Сумма заказа</td><td><?=$order->summa?></td></tr>
                                <tr><td>Валюта</td><td><?=$order->currency_code?></td></tr>
                                <tr><td>Имя заказчика</td><td><?=$order->user?></td></tr>
                                <tr><td>Статус</td><td><?=$order->status == '0' ? 'Новый' : 'Завершен'?></td></tr>
                                <tr><td>Комментарий</td><td><?=$order->note?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h3>Детали заказа</h3>
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ИД товара</th>
                                <th>Наименование</th>
                                <th>Кол-во</th>
                                <th>Цена (<?=$order->currency_code?>)</th>
                                <th>Сумма (<?=$order->currency_code?>)</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $cnt = 0;
                                    foreach ($order_items as $item):
                                        $cnt += $item->qty;
                                 ?>
                                    <tr>
                                    <td><?=$item->product_id?></td>
                                    <td><?=$item->title?></td>
                                    <td><?=$item->qty?></td>
                                    <td><?=$item->price?></td>
                                    <td><?=$item->summa?></td>
                                    </tr>
                                <?php endforeach;?>
                                <tr class="active">
                                    <td colspan="2"><b>ИТОГО</b></td>
                                    <td><b><?=$cnt?></b></td>
                                    <td></td>
                                    <td><b><?=$order->summa?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>




