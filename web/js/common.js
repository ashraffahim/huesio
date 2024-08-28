$(document).on('click', evt => {
    const closeOnBlurElements = $('.close-on-blur');
    if (closeOnBlurElements.length > 0 && !$(evt.target).is('.close-on-blur')) {
        $('.close-on-blur').removeClass('open');
    }
});