/*jshint esversion: 6 */
/*globals $:true, */
if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before formizard.js file.");
}

let dropup = $.dropup = {};
dropup.options = {
    mobileView: true,
    mobileBreakPoint: 1200,
    dropup: {
        enableTransitionEffects: true,
        transitionEffect: 'flipInX',
        transitionDelay: 'faster',
    },
    enableWavesPlugin: true,
    wavesEffect: 'waves-cyan',
    wavesType: 'default',

};

dropup.activateMobileScript = function () {
    this.bindMenuNavigation();
};
dropup.bindMenuNavigation = function () {
    let effects=['visible'];
    $(".multimenu-dropup-container nav > div > ul li").on('click', function (e) {
        if ($(window).width() < dropup.options.mobileBreakPoint) {
            e.stopPropagation();
            var thisMenu = $(this).children("ul");
            var prevState = thisMenu.css('display');
            if (prevState == 'none') {
                dropup.animateMenu.animateNow(thisMenu,effects,5);
            } else {
                thisMenu.removeClass(effects.join(' '));
            }
        }
    });
};

dropup.enableMobileMenu = function () {
    //the following hides the menu when a click is registered outside
    $(document).on('click', function (e) {
        
        if ($(e.target).closest('.multimenu-dropup-container').length === 0)
            $(".multimenu-dropup-container .navbar-collapse").removeClass('in');
    });
};

dropup.animateMenu = {
    bind: function () {
        let t = 0;
        let animateMenu = this;

        //adjust menu left or right according to viewable area
        $(".multimenu-dropup-container>nav>div>ul li").on('mouseenter mouseleave', function (e) {
            e.preventDefault();

            if (!$('ul', this).length && e.type == 'mouseenter') {
                return;
            }
            let elm = $('ul:first', this);
            let effects = [];

            if ($(window).width() > dropup.options.mobileBreakPoint) {
                //selected effects for menu
                effects.push('animated', dropup.options.dropup.transitionEffect, dropup.options.dropup.transitionDelay);
                if (e.type == 'mouseenter') {
                    e.stopPropagation();
                    $(elm).addClass('visible');
                    let off = elm.offset();
                    let l = off.left;
                    let w = elm.width();

                    let docH = $(".multimenu-dropup-container").height();
                    let docW = $(".multimenu-dropup-container").width();

                    let isEntirelyVisible = (l + w <= docW);
                    if (!isEntirelyVisible) {
                        $(elm).removeClass(effects.join(' '));
                        $(elm).addClass('edge-right');

                        //animate the menu and adjust according to viewable port from right
                        if (dropup.options.dropup.enableTransitionEffects) {
                            //if not first time then clearTimeout
                            animateMenu.clearTimeout(t);
                            t = animateMenu.animateNow(elm, effects);
                        }

                    } else {
                        //remove right adjustment
                        $(elm).removeClass('edge-right');

                        //animate menu if transition enabled
                        if (dropup.options.dropup.enableTransitionEffects) {
                            animateMenu.clearTimeout(t);
                            t = animateMenu.animateNow(elm, effects, 10);
                        }
                    }

                } else {
                    elm.removeClass('edge-right visible ' + effects.join(' '));
                }
            } else {
                console.log('here');
                effects.push('animated', 'fadeIn', dropup.options.dropup.transitionDelay);
                //if not first time then clearTimeout
                animateMenu.clearTimeout(t);
                t = animateMenu.animateNow(elm, effects, 10);
            }
        });
    },
    animateNow: function (elm, effects = ['animated', 'fadeIn', dropup.options.dropup.transitionDelay], delay = 1) {
        return setTimeout(function () {
            elm.toggleClass(effects.join(' '));
        }, delay);
    },
    clearTimeout: function (t) {
        //if not first time then clearTimeout
        (t > 0) && clearTimeout(t);
    }
};
dropup.addWavesEffect = function () {
    let effectType = this.options.wavesType == 'default' ? '' : this.options.wavesType;
    let config = ['waves-effect', effectType, this.options.wavesEffect];

    //Set Waves
    Waves.attach('.multimenu-dropup a', config);
    Waves.init();
}
dropup.init = function () {

    if (dropup.options.mobileView) {
        //adds the bars icon for the mobile
        $(".multimenu-dropup-container nav .container-fluid").before("<a href=\"#\" class=\"dropup-mobile navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar-collapse\" aria-expanded=\"false\"></a>");
    }

    //adds class to li if it has child ul
    $(".multimenu-dropup-container  li:has( > ul)").addClass("has-children");

    //for normal menu
    if ($(window).width() > dropup.options.mobileBreakPoint) {
        $('.multimenu-dropup-container nav > div > ul > li ul').addClass('sub-menu');
        this.animateMenu.bind();
    } else {
        //activate the mobile script
        this.activateMobileScript();
    }
    window.onresize = function (event) {
        //for normal menu
        if ($(window).width() > dropup.options.mobileBreakPoint) {
            $('.multimenu-dropup-container nav > div > ul > li ul').addClass('sub-menu');
            dropup.animateMenu.bind();
        } else {
            //activate the mobile script
            dropup.activateMobileScript();
        }
    };
    //enable the mobile menu anchor
    this.enableMobileMenu();

    //add waves effect
    if (dropup.options.enableWavesPlugin) {
        this.addWavesEffect();
    }

};