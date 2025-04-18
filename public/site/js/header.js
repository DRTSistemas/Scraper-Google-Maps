$(function () {

    /* EFEITO ANCORA MENU*/
    let alturas = {},
        position = $(window).scrollTop(),
        scroll;

    $('header nav ul li a').on('click', function () {
        $(this).parent().addClass('active');

        $('html, body').animate({
            scrollTop: $( $(this).attr('href') ).offset().top-60
        }, 1500);
        return false;
    });

});