/*********show full-footer*********/
$("#show-more-footer").click(function () {
    $("#full-footer-top").toggleClass("special-maxheight");
});



/**black-menu***/
$(document).ready(function () {
    var oldTop = 0;
    var flag_menu = 0;
    $(".my-menu").hover(
        function () {
            $(".black-menu").show();
        },
        function () {
            $(".black-menu").hide();
        }
    );

    $(window).scroll(function () {
        var nowTop = $(this).scrollTop();
        if (oldTop > nowTop) {
            $(".header-page").addClass("top-menu-active-2");
            flag_menu = 1;
        } else {
            $(".header-page").removeClass("top-menu-active-2");
        }

        if ($(this).scrollTop() > 40) {
            $(".header-page").addClass("top-menu-active");
            $(".header-logo").addClass("d-none");
            $(".menu-body").addClass("menu-body-new");
            $(".logo-small-menu").addClass("d-block");
        } else if ($(this).scrollTop() < 40) {
            $(".header-page").removeClass("top-menu-active");
            $(".header-logo").removeClass("d-none");
            $(".menu-body").removeClass("menu-body-new");
            $(".logo-small-menu").removeClass("d-block");

        }

        oldTop = nowTop;
    });
});

// START MOBILE MENU
$(document).mouseup(function (e) {
    if ($(".active-s-menu").length) {
        var container = $(".s-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            subject_close();
        }
    }
    if ($(".menu-active").length) {
        var container = $(".menu");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            close_menu();
        }
    }
    if ($(".active-mobile-menu").length) {
        var container = $(".mobile-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            close_mobile_menu();
        }
    }
});

function open_menu() {
    $(".black-menu").show();
    $(".in-main-menu").removeClass("in-main-menu-3");
    $(".in-main-menu").removeClass("in-main-menu-2");
    $(".menu").addClass("menu-active");
}
function close_menu() {
    $(".black-menu").hide();
    $(".menu").removeClass("menu-active");
}

function open_level_two(param) {
    $(".body-level-two").removeClass("body-level-two-active");
    $(param).addClass("body-level-two-active");
    $(".in-main-menu").addClass("in-main-menu-2");
}
function back_level_one() {
    $(".in-main-menu").removeClass("in-main-menu-2");
}
function open_level_three(param) {
    $(".body-level-three").removeClass("body-level-three-active");
    $(param).addClass("body-level-three-active");
    $(".in-main-menu").addClass("in-main-menu-3");
}
function open_level_four(param) {
    $(".body-level-four").removeClass("body-level-four-active");
    $(param).addClass("body-level-four-active");
    $(".in-main-menu").addClass("in-main-menu-4");
}
function back_level_two() {
    $(".in-main-menu").removeClass("in-main-menu-3");
}
function back_level_three() {
    $(".in-main-menu").removeClass("in-main-menu-4");
}
function open_filter(param) {
    $(param).slideToggle();
}
function open_filter_foure(param) {
    $(param).slideToggle();
}

// END MOBILE MENU

