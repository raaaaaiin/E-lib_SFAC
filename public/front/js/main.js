$(function () {

    "use strict";


    //===== Section Menu Active

    var scrollLink = $('.page-scroll');
    // Active link switching
    $(window).scroll(function () {
        var scrollbarLocation = $(this).scrollTop();

        scrollLink.each(function () {
            if ($(this.hash).length) {
                var sectionOffset = $(this.hash).offset().top - 73;
               
                if (sectionOffset <= scrollbarLocation) {
                    $(this).parent().addClass('active');
                    $(this).parent().siblings().removeClass('active');
                }
            }
        });
    });


    //===== close navbar-collapse when a  clicked

    $(".navbar-nav a").on('click', function () {
        $(".navbar-collapse").removeClass("show");
    });

    $(".navbar-toggler").on('click', function () {
        $(this).toggleClass("active");
    });

    $(".navbar-nav a").on('click', function () {
        $(".navbar-toggler").removeClass('active');
    });


    //===== Sidebar

    $('[href="#side-menu-left"], .overlay-left').on('click', function (event) {
        $('.sidebar-left, .overlay-left').addClass('open');
    });

    $('[href="#close"], .overlay-left').on('click', function (event) {
        $('.sidebar-left, .overlay-left').removeClass('open');
    });


    //===== Slick

    $('.slider-items-active').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        speed: 800,
        arrows: true,
        prevArrow: '<span class="prev"><i class="lni lni-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="lni lni-arrow-right"></i></span>',
        dots: true,
        autoplay: true,
        autoplaySpeed: 5000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                }
            }
        ]
    });


    //===== Isotope Project 4

    $('.container').imagesLoaded(function () {
        var $grid = $('.grid').isotope({
            // options
            transitionDuration: '1s'
        });

        // filter items on button click
        $('.portfolio-menu ul').on('click', 'li', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
        });
        // for simple searching
        //$("#search_book").on("keypress", function (e) {
        $("#search_book").on("keypress", function (e) {
           
            if (e.which == 13) {
                if ($("#search_book").val().length > 2) {
                    $grid.isotope({
                        filter: function () {
                            let search_keyword = $("#search_book").val().toLowerCase();
                            var name = $(this).find('.title').text();
                            let regex = '\\b' + search_keyword + '\\b';
                           
                            window.livewire.emit('saveData', search_keyword);
                            return name.match(search_keyword);
                        }
                    });
                   
                }
               
                if ($("#search_book").val().length == 0) {
                    $grid.isotope({filter: ''});
                }
            }
        });
        if (document.location.search.length) {
            if ($("#basic_mode").length) {
                $("#search_book").focus();
                if ($.QueryString["search"]) {
                    $("#search_book").val($.QueryString["search"]);
                    var e = $.Event("keypress", {which: 13});
                    $("#search_book").trigger(e);
                } else {
                    if (window.basic_slugs !== undefined) {
                        if ($.QueryString["pcat"]) {
                            let sel_parent = window.basic_slugs[$.QueryString["pcat"]];
                           
                            $grid.isotope({
                                filter: sel_parent
                            });
                        }
                    }
                }
            }
        }
        $(".portfolio-menu li").on("click",function () {
            if ($.QueryString["search"]||$.QueryString["pcat"] ) {clearQueryString();}
            $("#search_book").val('');
        });
        //for menu active class
        $('.portfolio-menu ul li').on('click', function (event) {
            $(this).siblings('.active').removeClass('active');
            $(this).addClass('active');
            event.preventDefault();
        });

        
    });

    

    



















    //===== slick Testimonial Four

    $('.testimonial-active').slick({
        dots: false,
        arrows: true,
        prevArrow: '<span class="prev"><i class="lni lni-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="lni lni-arrow-right"></i></span>',
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 800,
        slidesToShow: 1,
    });


    //====== Magnific Popup

    $('.video-popup').magnificPopup({
        type: 'iframe'
        // other options
    });


    //===== Magnific Popup

    $('.image-popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });


    //===== Back to top

    // Show or hide the sticky footer button
    $(window).on('scroll', function (event) {
        if ($(this).scrollTop() > 600) {
            $('.back-to-top').fadeIn(200)
        } else {
            $('.back-to-top').fadeOut(200)
        }
    });


    $('body').on('click', 'button.closeCallout', function () {
        $(this).parent().parent().remove();
    });

    //Animate the scroll to yop
    $('.back-to-top').on('click', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: 0,
        }, 1500);
    });


    //=====


});
(function ($) {
    $.QueryString = (function (paramsArray) {
        let params = {};

        for (let i = 0; i < paramsArray.length; ++i) {
            let param = paramsArray[i]
                .split('=', 2);

            if (param.length !== 2)
                continue;

            params[param[0]] = decodeURIComponent(param[1].replace(/\+/g, " "));
        }

        return params;
    })(window.location.search.substr(1).split('&'))
})(jQuery);
