/*jshint esversion: 6 */
/*globals $:true, */
if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before formizard.js file.");
}

let bigdrop = $.bigdrop = {};

bigdrop.options = {
    mobileView: true
};
bigdrop.activate = function () {
    //checks if a normal submenu
    $('.multimenu-bigdrop > ul > li > ul:not(:has(ul))').addClass('normal-sub');
    //checks if needs to be a bigdrop
    $('.multimenu-bigdrop > ul > li > ul:has(ul)').addClass('bigdrop-sub');
    //checks if its higher than 3rd level
    $(".bigdrop-sub > li > ul > li ul").addClass("infinite-sub");
    //adds class to li if it has child ul
    $(".bigdrop-sub > li > ul li:has( > ul)").addClass("has-children");
    if (this.options.mobileView) {
        //adds the bars icon for the mobile
        $(".multimenu-bigdrop > ul").before("<a href=\"#\" class=\"multimenu-mobile\">Navigation</a>");
    }


    //the following hides the menu when a click is registered outside
    $(document).on('click', function (e) {
        if ($(e.target).parents('.multimenu-bigdrop').length === 0)
            $(".multimenu-bigdrop > ul").removeClass('show-on-mobile');
    });
    $(".multimenu-mobile").on('click', function (e) {
        $(".multimenu-bigdrop > ul").toggleClass('show-on-mobile');
        e.preventDefault();
    });
};
bigdrop.activateMobile = function () {
    //If width is less or equal to 943px dropdowns are displayed on click (thanks Aman Jain from stackoverflow)
    $(".multimenu-bigdrop>ul li").on('click', function (e) {
        if ($(window).width() < 943) {
            e.stopPropagation();
            //no more overlapping menus
            //hides other children menus when a list item with children menus is clicked
            var thisMenu = $(this).children("ul");
            var prevState = thisMenu.css('display');
            // $(".multimenu > ul > li > ul:visible").fadeOut();

            if (prevState == 'none') {
                thisMenu.css('display', 'block');
            } else {
                thisMenu.css('display', 'none');
            }

        }
    });
};
bigdrop.fixMenuPosition = function () {
    //adjust menu left or right according to viewable area
    $(".multimenu-bigdrop li").on('mouseenter mouseleave', function (e) {

        if ($('ul', this).length) {

            var elm = $('ul:first', this);

            if ($(window).width() > 943) {
                var off = elm.offset();
                var l = off.left;
                var w = elm.width();
                var docH = $(".multimenu-bigdrop").height();
                var docW = $(".multimenu-bigdrop").width();

                var isEntirelyVisible = (l + w <= docW);
                if (!isEntirelyVisible) {
                    $(elm).addClass('edge-right');
                } else {
                    $(elm).removeClass('edge-right');

                    setTimeout(() => {
                        elm.toggleClass('visible');
                    }, 100);
                }
            } else {
                setTimeout(() => {
                    elm.toggleClass('visible');
                }, 100);
            }
        }
        e.preventDefault();
    });
};
bigdrop.addWavesEffect = function () {
    //apply waves effect on the menu links
    Waves.attach('.multimenu-bigdrop ul a', ['waves-effect', 'waves-light']);
    Waves.init();
};

bigdrop.init = function () {
    bigdrop.activate();
    bigdrop.activateMobile();
    bigdrop.fixMenuPosition();
    bigdrop.addWavesEffect();
};