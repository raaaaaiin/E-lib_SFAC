//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function () {

    $('a.page-scroll[href*="#"]:not([href="#"])').on('click', function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
            && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: (target.offset().top - 60)
                }, 1200, "easeInOutExpo");
                return false;
            }
        }
    });


});


// $(document).ready(function () {
//     var speed = 1000;
//     debugger;
//     // check for hash and if div exist... scroll to div
//     var hash = window.location.hash;
//     if ($(hash).length) scrollToID(hash, speed);
//
//     // scroll to div on nav click
//     $('.page-scroll').each(function (e) {
//         var id = $(this).attr('href');
//         if (id === hash) {
//             scrollToID(id, speed);
//         }
//     });
// })
//
// function scrollToID(id, speed) {
//     var offSet = 70;
//     var obj = $(id).offset();
//     var targetOffset = obj.top - offSet;
//     $('html,body').animate({scrollTop: targetOffset}, speed);
// }
//
