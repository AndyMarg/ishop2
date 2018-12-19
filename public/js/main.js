// product modifications changed
$('.available select').on('change', function() {
    var price = $(this).find('option').filter(':selected').data('price');
    var base_price = $('#main-price').data('base');
    if (price) {
        $('#main-price span').text(price);
    } else {
        $('#main-price span').text(base_price);
    }
});


/*
 * Функции корзины 
 */

// Отправить товар в корзину (клик на объектах с классом "add-to-cart-link"
$('body').on('click', '.add-to-cart-link', function (e) {
    e.preventDefault();
    // получить значения
    var to_cart_product_id = $(this).data('id');           // ид продукта, добавляемого в корзину
    var current_product_id = $('#product-add').data('id'); // ид продукта, отображаемого на странице продукта  
    var quantity = $('.quantity input').val();             // количество товаров в звказе
    if (!quantity || to_cart_product_id !== current_product_id) { 
        quantity = 1;
    }
    var modifier = $('.available select').find('option').filter(':selected').val(); // модификатор (разновидность) товара
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
    
    // отобразить корзину
    function showCart(cart) {
       if ($(cart).filter('#cart_is_empty').length > 0) {
           $('#cart-btn-order').css('display', 'none');
           $('#cart-btn-clear').css('display', 'none');
       } else {
           $('#cart-btn-order').css('display', 'inline-block');
           $('#cart-btn-clear').css('display', 'inline-block');
       }
       $('#cart .modal-body').html(cart);
       $('#cart').modal();
    }
    
    // очистить корзину
    function clearCart() {
        
    }
});