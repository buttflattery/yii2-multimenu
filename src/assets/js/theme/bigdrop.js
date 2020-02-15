/*jshint esversion: 6 */
/*globals $:true, */
if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before formizard.js file.");
}

let bigdrop = $.bigdrop = {};

bigdrop.options = {
    mobileView: true,
    mobileBreakPoint: 1200,
    bigdrop: {
        enableTransitionEffects: true,
        transitionEffect: 'flipInX',
        transitionDelay: 'faster',
    },
    enableWavesPlugin: true,
    wavesEffect: 'waves-cyan',
    wavesType: 'default',
};
bigdrop.activate = function () {
    //checks if a normal submenu
    $('.multimenu-bigdrop  div.container-fluid .navbar > li > ul:not(:has(ul))').addClass('normal-sub');

    //checks if needs to be a bigdrop
    $('.multimenu-bigdrop div.container-fluid .navbar > li > ul:has(ul)').addClass('bigdrop-sub');

    //checks if its higher than 3rd level
    $(".bigdrop-sub > li > ul > li ul").addClass("infinite-sub");

    //adds class to li if it has child ul
    $(".multimenu-bigdrop li:has( > ul)").addClass("has-children");

    if (this.options.mobileView) {
        //adds the bars icon for the mobile
        $(".multimenu-bigdrop div.container-fluid").before("<a href=\"#\" class=\"bigdrop-mobile navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bigdrop-navbar-collapse\" aria-expanded=\"false\"></a>");
    } else if (bigdrop.options.mobileBreakPoint >= $(window).width()) {
        bigdrop.hideNav();
    }

    //the following hides the menu when a click is registered outside
    $(document).on('click', function (e) {
        if ($(e.target).parents('.multimenu-bigdrop').length === 0)
            $(".multimenu-bigdrop-container .navbar").removeClass('in');
    });

};
bigdrop.activateMobile = function () {
    $(".multimenu-bigdrop div.container-fluid .navbar li").on('click', function (e) {
        if ($(window).width() < bigdrop.options.mobileBreakPoint) {
            e.stopPropagation();
            var thisMenu = $(this).children("ul");
            var prevState = thisMenu.css('display');

            if (prevState == 'none') {
                let effects = ['animated', 'visible', 'fadeIn'];
                bigdrop.animateMenu.animateNow(thisMenu, effects, 10);
                //thisMenu.addClass('visible');
            } else {
                thisMenu.removeClass('visible');
            }

        }
    });
};
bigdrop.animateMenu = {
    bind: function () {

        //unbind previous bindings
        bigdrop.animateMenu.unbind();

        let t = 0;
        let animateMenu = this;
        //adjust menu left or right according to viewable area
        $(".multimenu-bigdrop li").on('mouseenter mouseleave', function (e) {
            e.preventDefault();

            if (!$('ul', this).length && e.type == 'mouseenter') {
                return;
            }

            let elm = $('ul:first', this);
            let effects = [];

            if ($(window).width() > bigdrop.options.mobileBreakPoint) {
                //selected effects for menu
                effects.push('animated', bigdrop.options.bigdrop.transitionEffect, bigdrop.options.bigdrop.transitionDelay);
                if (e.type == 'mouseenter') {
                    e.stopPropagation();
                    $(elm).addClass('visible');
                    let off = elm.offset();
                    let l = off.left;
                    let w = elm.width();

                    let docH = $(".multimenu-bigdrop").height();
                    let docW = $(".multimenu-bigdrop").width();

                    let isEntirelyVisible = (l + w <= docW);

                    //if not visible entirely and is an infinite-sub menu 
                    if (!isEntirelyVisible && elm.hasClass('infinite-sub')) {
                        $(elm).removeClass(effects.join(' '));
                        $(elm).addClass('edge-right');

                        //animate the menu and adjust according to viewable port from right
                        if (bigdrop.options.bigdrop.enableTransitionEffects) {
                            //if not first time then clearTimeout
                            animateMenu.clearTimeout(t);
                            t = animateMenu.animateNow(elm, effects);
                        }

                    } else {
                        //remove right adjustment
                        $(elm).removeClass('edge-right');

                        //if third level dont animate
                        if ($(elm).parents('.bigdrop-sub').length && !$(elm).hasClass('infinite-sub')) {
                            return;
                        }

                        //animate menu if transition enabled
                        if (bigdrop.options.bigdrop.enableTransitionEffects) {
                            animateMenu.clearTimeout(t);
                            t = animateMenu.animateNow(elm, effects, 10);
                        }
                    }
                } else {
                    elm.removeClass('edge-right visible ' + effects.join(' '));
                }
            }

        });
    },
    unbind: function () {
        $(".multimenu-bigdrop li").off('mouseenter mouseleave');
    },
    animateNow: function (elm, effects = ['animated', 'fadeIn', bigdrop.options.bigdrop.transitionDelay], delay = 1) {
        return setTimeout(function () {
            elm.toggleClass(effects.join(' '));
        }, delay);
    },
    clearTimeout: function (t) {
        //if not first time then clearTimeout
        (t > 0) && clearTimeout(t);
    }
};


bigdrop.addWavesEffect = function () {
    let effectType = this.options.wavesType == 'default' ? '' : this.options.wavesType;
    let config = ['waves-effect', effectType, this.options.wavesEffect];

    //apply waves effect on the menu links
    Waves.attach('.multimenu-bigdrop ul a', config);
    Waves.init();
};

bigdrop.hideNav = function () {
    $("div.multimenu-bigdrop-container").hide();
};

bigdrop.showNav = function () {
    if ($("div.multimenu-bigdrop-container:hidden")) {
        $("div.multimenu-bigdrop-container").show();
    }
};

bigdrop.init = function () {
    bigdrop.activate();
    bigdrop.activateMobile();

    $(window).resize(function (event) {
        bigdrop.animateMenu.bind();

        if ($(window).width() <= bigdrop.options.mobileBreakPoint) {
            if (!bigdrop.options.mobileView) {
                bigdrop.hideNav();
            } else {
                bigdrop.showNav();
            }
        } else {
            bigdrop.showNav();
        }
    });

    bigdrop.animateMenu.bind();

    //enable waves plugin
    if (this.options.enableWavesPlugin) {
        bigdrop.addWavesEffect();
    }
};