/*jshint esversion: 6 */
/*globals $:true, */
if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before formizard.js file.");
}

let bigdrop = $.bigdrop = {};

bigdrop.options = {
    mobileView: true,
    transitionEffet: 'flipInX',
    transitionSpeed:'faster'
};
bigdrop.activate = function () {
    //checks if a normal submenu
    $('.multimenu-bigdrop > ul > li > ul:not(:has(ul))').addClass('normal-sub');
    //checks if needs to be a bigdrop
    $('.multimenu-bigdrop > ul > li > ul:has(ul)').addClass('bigdrop-sub');
    //checks if its higher than 3rd level
    $(".bigdrop-sub > li > ul > li ul").addClass("infinite-sub");
    //adds class to li if it has child ul
    $(".multimenu-bigdrop li:has( > ul)").addClass("has-children");


    if (this.options.mobileView) {
        //adds the bars icon for the mobile
        $(".multimenu-bigdrop").before("<a href=\"#\" class=\"bigdrop-mobile navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bigdrop-navbar-collapse\" aria-expanded=\"false\"></a>");
    }

    //the following hides the menu when a click is registered outside
    $(document).on('click', function (e) {
        if ($(e.target).parents('.multimenu-bigdrop').length === 0)
            $(".multimenu-bigdrop > ul").removeClass('in');
    });

};
bigdrop.activateMobile = function () {
    $(".multimenu-bigdrop>ul li").on('click', function (e) {
        if ($(window).width() < 1200) {
            e.stopPropagation();

            var thisMenu = $(this).children("ul");
            var prevState = thisMenu.css('display');

            if (prevState == 'none') {
                thisMenu.css('display', 'block');
            } else {
                thisMenu.css('display', 'none');
            }

        }
    });
};
bigdrop.fixMenuPosition = function () {
    let t = 0;
    //adjust menu left or right according to viewable area
    $(".multimenu-bigdrop li").on('mouseenter mouseleave', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if ($('ul', this).length) {

            var elm = $('ul:first', this);

            if ($(window).width() > 1200) {
                var off = elm.offset();
                var l = off.left;
                var w = elm.width();
                var docH = $(".multimenu-bigdrop").height();
                var docW = $(".multimenu-bigdrop").width();

                var isEntirelyVisible = (l + w <= docW);
                
                if (e.type == 'mouseenter') {
                    if (!isEntirelyVisible) {
                        $(elm).removeClass('animated visible '+bigdrop.options.transitionEffet+' '+bigdrop.options.transitionSpeed);
                        $(elm).addClass('edge-right');

                        //if not first time then clearTimeout
                        if (t > 0) {
                            clearTimeout(t);
                        }
                        
                        return setTimeout(function () {
                            elm.toggleClass('animated visible ' + bigdrop.options.transitionEffet+' '+bigdrop.options.transitionSpeed);
                        }, 1);

                    } else {
                        $(elm).removeClass('edge-right visible');

                        //if third level dont animate
                        if ($(elm).parents('.bigdrop-sub').length) {
                            return;
                        }
                        //if not first time then clearTimeout
                        if (t > 0) {
                            clearTimeout(t);
                        }
                        t = setTimeout(function () {
                            elm.toggleClass('animated visible ' + bigdrop.options.transitionEffet+' '+bigdrop.options.transitionSpeed);
                        }, 10);
                    }
                } else {
                    elm.removeClass('animated visible edge-right ' + bigdrop.options.transitionEffet+' '+bigdrop.options.transitionSpeed);
                }

            } else {
                //if not first time then clearTimeout
                if (t > 0) {
                    clearTimeout(t);
                }
                setTimeout(function () {
                    elm.toggleClass('animated fadeIn '+bigdrop.options.transitionSpeed);
                }, 10);
            }
        }
        e.preventDefault();
    });
};
bigdrop.addWavesEffect = function () {
    //apply waves effect on the menu links
    Waves.attach('.multimenu-bigdrop ul a', ['waves-effect', 'waves-cyan']);
    Waves.init();
};

bigdrop.init = function () {
    bigdrop.activate();
    bigdrop.activateMobile();
    bigdrop.fixMenuPosition();
    bigdrop.addWavesEffect();
};