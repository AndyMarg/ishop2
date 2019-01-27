<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <?php if (count($category->breadcrumbs) > 0): ?>
                    <?php foreach ($category->breadcrumbs as $item): ?>
                        <li><a href="category/<?= $item->alias; ?>"><?= $item->title; ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ol>
        </div>
    </div>
</div>

<!--products-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-9 prdt-left">
                <div id="category-products">
                    <?php if (!$products->isEmpty()): ?>
                        <?php
                            $num_in_row = 3;
                            echo core\base\View::fragment('products', compact(['products', 'currency', 'num_in_row']));
                        ?>
                    <?php else: ?>
                        <h3>В этой категории товаров пока нет ...</h3>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-3 prdt-right">
                <div class="w_sidebar">
                    <?php new \app\widgets\filter\Filter(); ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


