$(function () {
    var contactButton = $('.contact-button');
    var contactInfo = $('.contact-info');

    contactButton.on('click', function (element) {
        $(this).addClass('d-none');
        contactInfo.fadeIn(600);
    });
    $('.close-info').on('click', function (element) {
        contactInfo.css('display', 'none');
        contactButton.removeClass('d-none');
    });
});