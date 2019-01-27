<!-- banner -->
<div class="bnr" id="home">
    <div id="top" class="callbacks_container">
        <ul class="rslides" id="slider4">
            <li><img src="images/bnr-1.jpg" alt=""/></li>
            <li><img src="images/bnr-2.jpg" alt=""/></li>
            <li><img src="images/bnr-3.jpg" alt=""/></li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>

<!--brands-->
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

<!--products-->
<?php if ($products): ?>
    <div class="product">
        <div class="container">
            <div class="product-top">
                <?php
                    $num_in_row = 4;
                    echo core\base\View::fragment('products', compact(['products', 'currency', 'num_in_row']));
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>

