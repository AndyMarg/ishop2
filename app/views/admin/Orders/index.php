<?php
$admin_path = \core\base\Application::getConfig()->dirs->admin;
$www_path = \core\base\Application::getConfig()->dirs->www;
?>

<section class="content-header">
    <div class="row admin-header">
        <div class="col-md-6">
            <h3>Список заказов</h3>
        </div>
        <div class="col-md-6 text-right">
            <ol class="breadcrumb">
                <li><a href="<?= $admin_path ?>"><i class="fa fa-home"></i> Главная</a></li>
                <li class="active"><i class="fa fa-shopping-cart"></i> Заказы</li>
            </ol>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <?php if(count($orders->asArray()) > 0):?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Покупатель</th>
                                <th>Статус</th>
                                <th>Сумма заказа</th>
                                <th>Валюта заказа</th>
                                <th>Позиций в заказе</th>
                                <th>Дата создания</th>
                                <th>Дата изменения</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = ($orders->getCountOnPage() * ($orders->getPage()-1)) + 1;
                                foreach ($orders as $order):
                            ?>
                            <tr <?=$order->status == '1' ? "class=\"success\"" : ''?>>
                                <td><?=$i++?></td>
                                <td><?=$order->id?></td>
                                <td><?=$order->user?></td>
                                <td><?=$order->status == '0' ? 'Новый' : 'Завершен'?></td>
                                <td><?=$order->summa?></td>
                                 <td><?=$order->currency_code?></td>
                                <td><?=$order->cnt?></td>
                                <td><?=$order->date?></td>
                                <td><?=$order->update_at?></td>
                                <td>
                                    <row>
                                        <div class="col-md-6">
                                            <a href="<?=$admin_path?>/order/view?id=<?=$order->id?>"><i class="fa fa-fw fa-eye"></i></a>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="delete-warning" href="<?=$admin_path?>/order/delete?id=<?=$order->id?>"><i class="fa fa-fw fa-close text-danger"></i></a>
                                        </div>
                                    </row>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <h4>Новые заказы отсутствуют</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="text-center">
        <?php if ($orders && $orders->isNeedPagination()): ?>
            <p id="pagination-info">Показано <?= $orders->count() ?> заказа(ов) из <?= $orders->getTotal() ?></p>
            <?= (new core\libs\Pagination($orders))->getHtml() ?>
        <?php endif; ?>
    </div>
</section>


