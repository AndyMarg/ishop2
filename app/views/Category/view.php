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
<!--end-breadcrumbs-->

<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-9 prdt-left">
                <?php if (!$products->isEmpty()): ?>
                    <?php foreach ($products as $item): ?>
                        <div class="col-md-4 product-left p-left">
                            <div class="product-main simpleCart_shelfItem">
                                <a href="product/<?= $item->alias; ?>" class="mask"><img
                                        class="img-responsive zoom-img" src="images/<?= $item->img; ?>"
                                        alt=""/></a>
                                <div class="product-bottom">
                                    <h3><a href="product/<?= $item->alias; ?>"><?= $item->title; ?></a></h3>
                                    <p>Explore Now</p>
                                    <h4>
                                        <a class="add-to-cart-link" href="cart/add/?id=<?= $item->id; ?>"
                                           data-id="<?= $item->id; ?>"><i></i></a>
                                        <span class="item_price">
                                                <?= $currency->symbol_left; ?>
                                                <?= $item->price * $currency->value; ?>
                                                <?= $currency->symbol_right; ?>
                                        </span>
                                        <?php if ($item->old_price): ?>
                                            <small>
                                                <del><?= $item->old_price * $currency->value; ?></del>
                                            </small>
                                        <?php endif; ?>
                                    </h4>
                                </div>
                                <div class="srch">
                                    <?php if ($item->old_price): ?>
                                        <span>-<?= 100 - round(($item->price / $item->old_price) * 100); ?>
                                            %</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <?php if ($products->isNeedPagination()): ?>
                            <p id="pagination-info">Показано <?=$products->count()?> товара(ов) из <?=$products->getTotal()?></p>
                            <?=(new core\libs\Pagination($products))->getHtml()?>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <h3>В этой категории товаров пока нет ...</h3>
                <?php endif; ?>
            </div>

            <div class="col-md-3 prdt-right">
                <div class="w_sidebar">
                    <?php new \app\widgets\filter\Filter();  ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--product-end-->

