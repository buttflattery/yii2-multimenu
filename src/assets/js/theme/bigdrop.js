/*global $ */
$(document).ready(function () {

    "use strict";

    // $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');
    //Checks if li has sub (ul) and adds class for toggle icon - just an UI


    $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');
    //Checks if drodown menu's li elements have anothere level (ul), if not the dropdown is shown as regular dropdown, not a mega menu (thanks Luka Kladaric)
    $(".menu > ul").before("<a href=\"#\" class=\"menu-mobile\">Navigation</a>");


    //the following hides the menu when a click is registered outside
    $(document).on('click', function (e) {
        if ($(e.target).parents('.menu').length === 0)
            $(".menu > ul").removeClass('show-on-mobile');
    });

    $(".menu > ul > li").on('click', function () {
        if ($(window).width() < 943) {
            //no more overlapping menus
            //hides other children menus when a list item with children menus is clicked
            var thisMenu = $(this).children("ul");
            var prevState = thisMenu.css('display');
             $(".menu > ul > li > ul:visible").fadeOut();
            
            if (prevState == 'none') {
                thisMenu.css('display', 'block');
            }else{
                thisMenu.css('display', 'none');
            }
        }
    });
    //If width is less or equal to 943px dropdowns are displayed on click (thanks Aman Jain from stackoverflow)

    $(".menu-mobile").on('click', function (e) {
        $(".menu > ul").toggleClass('show-on-mobile');
        e.preventDefault();
    });
    //when clicked on mobile-menu, normal menu is shown as a list, classic rwd menu story (thanks mwl from stackoverflow)

    //apply waves effect on the menu links
    Waves.attach('.menu ul a',['waves-effect','waves-light']);
    Waves.init();
});