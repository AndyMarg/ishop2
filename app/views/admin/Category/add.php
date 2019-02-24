<?php
$admin_path = \core\base\Application::getConfig()->dirs->admin;
$www_path = \core\base\Application::getConfig()->dirs->www;
?>

<section class="content-header">
    <div class="row admin-header">
        <div class="col-md-6">
            <h3>Список категорий</h3>
        </div>
        <div class="col-md-6 text-right">
            <ol class="breadcrumb">
                <li><a href="<?=$admin_path?>"><i class="fa fa-home"></i> Главная</a></li>
                <li><a href="<?=$admin_path?>/category"><i class="fa fa-navicon"></i> Категории</a></li>
                <li class="active"> Новая категория</li>
            </ol>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?=$admin_path?>/category/add" method="post" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование категории</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Наименование категории" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="form-group">
                            <label for="parent">Родительская категория</label>
                            <?php echo core\base\View::fragment('categories', compact(['categories']));?>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Ключевые слова">
                        </div>
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Описание">
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</section>


