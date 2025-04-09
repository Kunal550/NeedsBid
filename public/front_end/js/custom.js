$(document).ready(function () {
    $(".home-slider").owlCarousel({
        items: 1,
        loop: true,
        margin: 20,
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        autoplayTimeout: 4500,
        smartSpeed: 4000,
        nav: false,
        dots: true,
        navText: [
            "<i class='fa fa-long-arrow-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
        autoplay: true,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });

    $(".qlist .owl-carousel").owlCarousel({
        items: 5,
        loop: false,
        margin: 50,
        autoplayTimeout: 3500,
        smartSpeed: 3000,
        nav: true,
        dots: false,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
        autoplay: false,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1,
                margin: 15,
            },
            600: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1000: {
                items: 5,
                margin: 50,
            },
        },
    });
    $(".product-slider").owlCarousel({
        items: 3,
        loop: false,
        margin: 20,
        autoplayTimeout: 3500,
        smartSpeed: 3000,
        nav: true,
        dots: false,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
        autoplay: false,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1,
                margin: 15,
            },
            600: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1000: {
                items: 3,
                margin: 20,
            },
        },
    });
    $(".brand-slider").owlCarousel({
        items: 5,
        loop: true,
        margin: 25,
        autoplayTimeout: 3500,
        smartSpeed: 3000,
        nav: false,
        dots: true,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
        autoplay: true,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 3,
            },
            600: {
                items: 3,
            },
            992: {
                items: 4,
            },
            1000: {
                items: 5,
            },
        },
    });
    $(".fp-slider").owlCarousel({
        items: 4,
        loop: true,
        margin: 1,
        autoplayTimeout: 3500,
        smartSpeed: 3000,
        nav: true,
        dots: false,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
        autoplay: false,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1000: {
                items: 4,
            },
        },
    });
    $(".tslider").owlCarousel({
        items: 3,
        loop: false,
        margin: 15,
        autoplayTimeout: 3500,
        smartSpeed: 3000,
        nav: true,
        dots: true,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
        autoplay: true,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
    });
    $(".blog-slider").owlCarousel({
        items: 3,
        loop: false,
        margin: 30,
        autoplayTimeout: 3500,
        smartSpeed: 3000,
        nav: true,
        dots: true,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
        autoplay: true,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
    });
    $(".gal-slider").owlCarousel({
        items: 4,
        loop: false,
        margin: 15,
        autoplayTimeout: 3500,
        smartSpeed: 3000,
        nav: true,
        dots: false,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>",
        ],
        autoplay: true,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1000: {
                items: 4,
            },
        },
    });

    $("#searchBtn").submit(function (e) {
        $("#myDiv").show();
    });
});
function removeDel(rowid) {
    $('.dynamic_' + rowid).remove();
}
