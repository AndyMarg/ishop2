<?php
$admin_path = \core\base\Application::getConfig()->dirs->admin;
$www_path = \core\base\Application::getConfig()->dirs->www;
$categories = $categories->getFlatTree();
?>

<section class="content-header">
    <div class="row admin-header">
        <div class="col-md-6">
            <h3>Список категорий</h3>
        </div>
        <div class="col-md-6 text-right">
            <ol class="breadcrumb">
                <li><a href="<?= $admin_path ?>"><i class="fa fa-home"></i> Главная</a></li>
                <li class="active"><i class="fa fa-navicon"></i> Категории</li>
            </ol>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <?php if(count($categories) > 0):?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="30%">Название</th>
                                    <th width="30%">Описание</th>
                                    <th width="10%" class="text-center">Кол-во подкатегорий</th>
                                    <th width="10%" class="text-center">Кол-во продуктов в категории</th>
                                    <th width="20%" class="text-center">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?=str_repeat('&nbsp', $category['level']*10)?><?=$category['title']?></td>
                                        <td><?=$category['description']?></td>
                                        <td class="text-center"><?=$category['cnt_subcategory']?></td>
                                        <td class="text-center"><?=$category['cnt_prod']?></td>
                                        <td class="text-center">
                                            <row>
                                                <div class="col-md-6">
                                                    <a href="<?=$admin_path?>/category/view?id=<?=$category['id']?>"><i class="fa fa-fw fa-eye"></i></a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a class="delete-warning <?=($category['cnt_prod'] || $category['cnt_subcategory']) ? 'disabled' : 'text-danger'?>" href="<?=$admin_path?>/category/delete?id=<?=$category['id']?>">
                                                        <i class="fa fa-fw fa-close"></i>
                                                    </a>
                                                </div>
                                            </row>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


