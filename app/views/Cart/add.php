<?php if(!$cart->isEmpty()): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <row>
                    <th>Фото</th>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                </row>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
<?php else: ?>
    <h3 id="cart_is_empty">Корзина пуста</h3>
<?php endif; ?>





