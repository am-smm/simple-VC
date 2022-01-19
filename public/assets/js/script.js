// para ativar as tooltip
// ver: https://getbootstrap.com/docs/5.1/components/tooltips/#example-enable-tooltips-everywhere
const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})

$("div.alert").fadeTo(4000, 300).slideUp(300, function(){
    $(this).slideUp(300);
});