<?php
    $admin_path = \core\base\Application::getConfig()->dirs->admin;
    $www_path = \core\base\Application::getConfig()->dirs->www;
?>

<section class="content-header">
    <h1>Панель управления </h1>
    <ol class="breadcrumb">
        <li><a href="<?=$admin_path?>"><i class="fa fa-home"></i> Главная</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?=$cnt_new_order?></h3>
                    <p>Новых заказов</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?=$admin_path?>/orders" class="small-box-footer">Все заказы <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?=$cnt_product?></h3>
                    <p>Товаров</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?=$admin_path?>/product" class="small-box-footer">Все товары <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?=$cnt_user?></h3>
                    <p>Пользователей</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?=$admin_path?>/user" class="small-box-footer">Список пользователей <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?=$cnt_category?></h3>
                    <p>Категорий товаров</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="<?=$admin_path?>/category" class="small-box-footer">Список категорий <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

</section>

