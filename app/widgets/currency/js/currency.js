$('#currency').change(function() {
    window.location = 'currency/change?currency=' + $(this).val();
});

