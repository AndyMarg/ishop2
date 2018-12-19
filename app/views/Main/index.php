<!--banner-starts-->
<div class="bnr" id="home">
    <div id="top" class="callbacks_container">
        <ul class="rslides" id="slider4">
            <li>
                <img src="images/bnr-1.jpg" alt=""/>
            </li>
            <li>
                <img src="images/bnr-2.jpg" alt=""/>
            </li>
            <li>
                <img src="images/bnr-3.jpg" alt=""/>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
<!--banner-ends-->

<!--about-starts-->
<?php if ($brands): ?>
    <div class="about">
        <div class="container">
            <div class="about-top grid-1">
                <?php foreach ($brands as $brand): ?>
                    <div class="col-md-4 about-left">
                        <figure class="effect-bubba">
                            <img class="img-responsive" src="images/<?= $brand->img ?>" alt=""/>
                            <figcaption>
                                <h2><?= $brand->title ?></h2>
                                <p><?= $brand->description ?></p>
                            </figcaption>
                        </figure>
                    </div>
                <?php endforeach; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--about-end-->

<!--product-starts-->
<?php if ($products): ?>
    <div class="product">
        <div class="container">
            <div class="product-top">
                <div class="product-one">
                    <?php foreach ($products as $id => $product): ?>
                        <div class="col-md-3 product-left">
                            <div class="product-main simpleCart_shelfItem">

                                <a href="product/<?= $product->alias; ?>" class="mask"><img
                                            class="img-responsive zoom-img" src="images/<?= $product->img; ?>" alt=""/></a>
                                <div class="product-bottom">
                                    <h3><a href="product/<?= $product->alias; ?>"><?= $product->title; ?></a></h3>
                                    <p>Explore Now</p>
                                    <h4>
                                        <a class="add-to-cart-link" href="cart/add/?id=<?= $product->id; ?>"
                                           data-id="<?= $product->id; ?>"><i></i></a>
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
                                        <span>-<?= 100 - round(($product->price / $product->old_price) * 100); ?>
                                            %</span>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--product-end-->
