window.addEventListener('load', function () {
    setTimeout(hide_loader, 500);
});

function hide_loader() {
    $('#loader-container').fadeOut(300);
    document.body.style.overflow = 'visible';
}