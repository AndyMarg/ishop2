// product modifications changed
$('.available select').on('change', function() {
    let price = $(this).find('option').filter(':selected').data('price');
    let base_price = $('#main-price').data('base');
    if (price) {
        $('#main-price span').text(price);
    } else {
        $('#main-price span').text(base_price);
    }
});

/**
 * Функции корзины 
 */

// Отправить товар в корзину (клик на объектах с классом "add-to-cart-link"
$('body').on('click', '.add-to-cart-link', function (e) {
    e.preventDefault();
    addCart($(this).data('id'));
});

// Удалить товар из корзины (клик на объектах с классом "delete-product" в модальном окне
$('.modal-body').on('click', '.delete-product', function (e) {
    deleteCart($(this).data('id'));
});

// удаление товара из корзины
function deleteCart(product_id) {
    // отправить запрос на сервер
    $.ajax({
        url: 'cart/delete',
        data: {id: product_id},
        type: 'GET',
        success: function (response) {
            showCart(response);
        },
        error: function (e) {
            console.log(e.responseJSON["message"]);
        }
    });
}

// добавить товар в корзину и показать ее
function addCart(product_id) {
    // получить значения
    let to_cart_product_id = product_id;                   // ид продукта, добавляемого в корзину
    let current_product_id = $('#product-add').data('id'); // ид продукта, отображаемого на странице продукта
    let quantity = $('.quantity input').val();             // количество товаров в звказе
    if (!quantity || to_cart_product_id !== current_product_id) {
        quantity = 1;
    }
    let modifier = $('.available select').find('option').filter(':selected').val(); // модификатор (разновидность) товара
    if (!modifier || to_cart_product_id !== current_product_id) {
        modifier = 0;
    }
    // отправить запрос на сервер
    $.ajax({
        url: 'cart/add',
        data: {id: to_cart_product_id, quantity: quantity, modifier: modifier},
        type: 'GET',
        success: function (response) {
            showCart(response);
        },
        error: function (e) {
            console.log(e.responseJSON["message"]);
        }
    });
}

// запросить данные о корзине и показать ее
function getCart() {
    $.ajax({
        url: 'cart/show',
        type: 'GET',
        success: function (response) {
            showCart(response);
        },
        error: function (e) {
            console.log(e.responseJSON["message"]);
        }
    });
}

// отобразить корзину
function showCart(cart) {
    if ($(cart).filter('#cart_is_empty').length > 0) {
        $('#cart-btn-order, #cart-btn-clear').css('display', 'none');
    } else {
        $('#cart-btn-order, #cart-btn-clear').css('display', 'inline-block');
    }
    $('#cart .modal-body').html(cart);
    $('#cart').modal();
    updateSum(cart);
}

// очистить корзину
function clearCart() {
    // отправить запрос на сервер
    $.ajax({
        url: 'cart/clear',
        type: 'GET',
        success: function (response) {
            showCart(response);
        },
        error: function (e) {
            console.log(e.responseJSON["message"]);
        }
    });
}

function updateSum(cart) {
    // обновить информацию о сумме в главном шаблоне (справа вверху, рядом со значком корзины)
    let sumElement = $(cart).find('.cart-sum');
    if(sumElement.length) {
        $('.simpleCart_total').html(sumElement.text());
    } else {
        $('.simpleCart_total').text('Корзина пуста');
    }
}

/**
 * контекстный поиск
 */

let products = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: '%QUERY',
        url: 'search/livesearch?query=%QUERY'
    }
});

products.initialize();

$("#typeahead").typeahead({
    // hint: false,
    highlight: true
},{
    name: 'products',
    display: 'title',
    limit: 9,
    source: products
});

$('#typeahead').bind('typeahead:select', function(ev, suggestion) {
    // console.log(suggestion);
    window.location = 'search/?search_value=' + encodeURIComponent(suggestion.title);
});



