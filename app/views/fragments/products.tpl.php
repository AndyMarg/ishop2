<div class="product-one">
    <?php foreach ($products as $id => $product): ?>
        <div class="col-md-<?= 12/$num_in_row ?> product-left">
            <div class="product-main simpleCart_shelfItem">
                <a href="product/<?= $product->alias; ?>" class="mask">
                    <img class="img-responsive zoom-img" src="images/<?= $product->img; ?>" alt=""/>
                </a>
                <div class="product-bottom">
                    <h3><a href="product/<?= $product->alias; ?>"><?= $product->title; ?></a></h3>
                    <p>Explore Now</p>
                    <h4>
                        <a class="add-to-cart-link" href="cart/add/?id=<?= $product->id; ?>" data-id="<?= $product->id; ?>">
                            <i></i>
                        </a>
                        <span class="item_price">
                            <?= $currency->symbol_left; ?>
                            <?= $product->price * $currency->value; ?>
                            <?= $currency->symbol_right; ?>
                        </span>
                        <?php if ($product->old_price): ?>
                            <small>
                                <del><?= $product->old_price * $currency->value; ?></del>
                            </small>
                        <?php endif; ?>
                    </h4>
                </div>
                <div class="srch">
                    <?php if ($product->old_price): ?>
                        <span>-<?= 100 - round(($product->price / $product->old_price) * 100); ?>%</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <div class="text-center">
        <?php if ($products->isNeedPagination()): ?>
            <p id="pagination-info">Показано <?= $products->count() ?> товара(ов) из <?= $products->getTotal() ?></p>
            <?= (new core\libs\Pagination($products))->getHtml() ?>
        <?php endif; ?>
    </div>
</div>
