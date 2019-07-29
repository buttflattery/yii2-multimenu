/*global $ */
$(document).ready(function () {

    "use strict";

    // $('.multimenu > ul > li:has( > ul)').addClass('menu-dropdown-icon');
    //Checks if li has sub (ul) and adds class for toggle icon - just an UI


    //checks if a normal submenu
    $('.multimenu > ul > li > ul:not(:has(ul))').addClass('normal-sub');
    //checks if needs to be a bigdrop
    $('.multimenu > ul > li > ul:has(ul)').addClass('bigdrop-sub');
    //checks if its higher than 3rd level
    $(".bigdrop-sub > li > ul > li ul").addClass("infinite-sub");
    //adds class to li if it has child ul
    $(".bigdrop-sub > li > ul li:has( > ul)").addClass("has-children");
    //adds the bars icon for the mobile
    $(".multimenu > ul").before("<a href=\"#\" class=\"multimenu-mobile\">Navigation</a>");


    //the following hides the menu when a click is registered outside
    $(document).on('click', function (e) {
        if ($(e.target).parents('.multimenu').length === 0)
            $(".multimenu > ul").removeClass('show-on-mobile');
    });

    //If width is less or equal to 943px dropdowns are displayed on click (thanks Aman Jain from stackoverflow)
    $(".multimenu>ul li").on('click', function (e) {
        if ($(window).width() < 943) {
            e.stopPropagation();
            console.log("inside",this);
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
    

    $(".multimenu-mobile").on('click', function (e) {
        $(".multimenu > ul").toggleClass('show-on-mobile');
        e.preventDefault();
    });

    //adjust menu left or right according to viewable area

    $(".multimenu li").on('mouseenter mouseleave', function (e) {

        if ($('ul', this).length) {

            var elm = $('ul:first', this);

            if ($(window).width() > 943) {
                var off = elm.offset();
                var l = off.left;
                var w = elm.width();
                var docH = $(".multimenu").height();
                var docW = $(".multimenu").width();

                var isEntirelyVisible = (l + w <= docW);
                if (!isEntirelyVisible) {
                    $(elm).addClass('edge-right');
                } else {
                    $(elm).removeClass('edge-right');
    
                    setTimeout(() => {
                        elm.toggleClass('visible');
                    }, 100);
                }
            }else{
                setTimeout(() => {
                    elm.toggleClass('visible');
                }, 100);
            }
        }
        e.preventDefault();
    });

    //apply waves effect on the menu links
    Waves.attach('.multimenu ul a', ['waves-effect', 'waves-light']);
    Waves.init();
});