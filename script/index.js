// Navbar Toggling Positions JS

// $(document).ready(function () {
//     window.onscroll = function () {
//         var scroll_top = document.body.scrollTop || document.documentElement.scrollTop;
//         if (scroll_top > 3000) {
//             $(".nav-bar").addClass('fixed');
//         }
//         else {
//             $(".nav-bar").removeClass('fixed');
//         }
//     }
// })


// Products Gallery JS

// let cont_width = $('#productCardsContainer').width();

// $('#prev-btn').click(function () {
//     event.preventDefault();
//     $('#productCardsContainer').animate({
//         scrollLeft: "-=380px"
//     }, "slow");
// });

// $('#nxt-btn').click(function () {
//     event.preventDefault();
//     $('#productCardsContainer').animate({
//         scrollLeft: "+=380px"
//     }, "slow");
// });


// Product Slider JS (Owl Carousel)

$(document).ready(function () {
    $('#owl-one').owlCarousel({
        margin: 0,
        responsiveClass: true,
        lazyLoad: false,
        nav: true,
        autoHeight: true,
        navText: [
            "<i class='fa-solid fa-chevron-left prdt-left'></i>",
            "<i class='fa-solid fa-chevron-right prdt-right'></i>"
        ],
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 3,
            },
            1000: {
                items: 4,
            }
        }
    })
})



// Gallery (Image Owl)

$(document).ready(function(){
    $('#owl-two').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        center:true,
        loop:true,
        nav:true,
        autoHeight:true,
        navText:[
            "<i class='fa-solid fa-chevron-left gall-left'></i>",
            "<i class='fa-solid fa-chevron-right gall-right'></i>"
        ],
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3,
            },
            1000:{
                items:3,
            }
        }
    })
})