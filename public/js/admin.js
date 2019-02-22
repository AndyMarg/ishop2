// Delete warning
$('.delete-warning').click(function () {
    let ok = confirm("Подтвердите действие");
    if (!ok) return false;
});

$('ul.sidebar-menu li a').each(function() {
    if (this.href === location.protocol + '//' + location.hostname + location.pathname) {
        $(this).parent().addClass('active');
       $(this).closest('.treeview').addClass('active');
    }
});

