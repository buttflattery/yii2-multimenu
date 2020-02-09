/*jshint esversion: 6 */
/*globals $:true, */
if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before formizard.js file.");
}
/* Browser - Function ======================================================================================================
 *  You can manage browser
 *  
 */
var edge = 'Microsoft Edge';
var ie10 = 'Internet Explorer 10';
var ie11 = 'Internet Explorer 11';
var opera = 'Opera';
var firefox = 'Mozilla Firefox';
var chrome = 'Google Chrome';
var safari = 'Safari';

let leftnav = $.leftnav = {};
leftnav.browser = {
    activate: function () {
        var _this = this;
        var className = _this.getClassName();

        if (className !== '') $('html').addClass(_this.getClassName());
    },
    getBrowser: function () {
        var userAgent = navigator.userAgent.toLowerCase();

        if (/edge/i.test(userAgent)) {
            return edge;
        } else if (/rv:11/i.test(userAgent)) {
            return ie11;
        } else if (/msie 10/i.test(userAgent)) {
            return ie10;
        } else if (/opr/i.test(userAgent)) {
            return opera;
        } else if (/chrome/i.test(userAgent)) {
            return chrome;
        } else if (/firefox/i.test(userAgent)) {
            return firefox;
        } else if (!!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)) {
            return safari;
        }

        return undefined;
    },
    getClassName: function () {
        var browser = this.getBrowser();

        if (browser === edge) {
            return 'edge';
        } else if (browser === ie11) {
            return 'ie11';
        } else if (browser === ie10) {
            return 'ie10';
        } else if (browser === opera) {
            return 'opera';
        } else if (browser === chrome) {
            return 'chrome';
        } else if (browser === firefox) {
            return 'firefox';
        } else if (browser === safari) {
            return 'safari';
        } else {
            return '';
        }
    }
};

/* Left Sidebar - Function =================================================================================================
 *  You can manage the left sidebar menu options
 *  
 */
leftnav.options = {
    mobileView: false,
    mobileBreakPoint: 1200,
    enableWavesPlugin: true,
    wavesEffect: 'waves-cyan',
    wavesType: 'default',
    leftnav: {
        position:'default',
        enableTransitionEffects: true,
        transitionEffect: 'flipInX',
        transitionDelay: 'faster',
        slimScroll: {
            scrollColor: 'rgba(0,0,0,0.5)',
            scrollWidth: '4px',
            scrollAlwaysVisible: false,
            scrollBorderRadius: '0',
            scrollRailBorderRadius: '0',
            scrollActiveItemWhenPageLoad: true,
        }
    },
};

leftnav.leftSideBar = {
    activate: function () {

        var _this = this;

        var $body = $('body');
        var $overlay = $('.overlay');

        //Close sidebar
        $(window).click(function (e) {
            var $target = $(e.target);
            if (e.target.nodeName.toLowerCase() === 'i') {
                $target = $(e.target).parent();
            }

            if (!$target.hasClass('bars') && _this.isOpen() && $target.parents('#leftsidebar').length === 0) {
                if (!$target.hasClass('js-right-sidebar')) $overlay.fadeOut();
                $body.removeClass('overlay-open');
            }
        });

        if (leftnav.options.mobileView) {
            //adds the bars icon for the mobile
            $(".leftnav-container").before("<a href=\"javascript:void(0)\" class=\"leftnav-mobileview bars\"></a>");
        }

        //add menu-toggled class to all the parent li
        $(".leftnav .list li:has(ul.ml-menu)").each(function (index, item) {

            $(item).find('a').first().addClass('menu-toggle');
            // $(item).find('a:first-child').addClass('menu-toggle');
        });

        $.each($('.menu-toggle.toggled'), function (i, val) {
            $(val).next().slideToggle(0);
        });

        //When page load
        $.each($('.leftnav .list li.active'), function (i, val) {
            var $activeAnchors = $(val).find('a:eq(0)');

            $activeAnchors.addClass('toggled');
            $activeAnchors.next().show();
        });

        //Collapse or Expand Menu
        $('.menu-toggle').on('click', function (e) {
            var $this = $(this);
            var $content = $this.next();

            if ($($this.parents('ul')[0]).hasClass('list')) {
                var $not = $(e.target).hasClass('menu-toggle') ? e.target : $(e.target).parents('.menu-toggle');

                $.each($('.menu-toggle.toggled').not($not).next(), function (i, val) {
                    if ($(val).is(':visible')) {
                        $(val).prev().toggleClass('toggled');
                        $(val).slideUp();
                    }
                });
            }

            $this.toggleClass('toggled');
            $content.slideToggle(320);
        });

        //Set menu height
        _this.setMenuHeight(true);
        _this.checkStatuForResize(true);
        $(window).resize(function () {
            _this.setMenuHeight(false);
            _this.checkStatuForResize(false);
        });

        if (leftnav.options.enableWavesPlugin) {
            this.addWaveseffect();
        }

    },
    addWaveseffect: function () {
        let effectType = leftnav.options.wavesType == 'default' ? '' : leftnav.options.wavesType;
        let config = ['waves-effect', effectType, leftnav.options.wavesEffect];
        //Set Waves
        Waves.attach('.leftnav .list a', config);
        Waves.init();
    },
    setMenuHeight: function (isFirstTime) {

        if (typeof $.fn.slimScroll != 'undefined') {

            var configs = leftnav.options.leftnav.slimScroll;
            var height = $(window).height() *(0.85);
            var $el = $('.list');

            if (!isFirstTime) {
                $el.slimscroll({
                    destroy: true
                });
            }

            $el.slimscroll({
                height: height + "px",
                color: configs.scrollColor,
                size: configs.scrollWidth,
                alwaysVisible: configs.scrollAlwaysVisible,
                borderRadius: configs.scrollBorderRadius,
                railBorderRadius: configs.scrollRailBorderRadius
            });
            //Scroll active menu item when page load, if option set = true
            if (leftnav.options.leftnav.slimScroll.scrollActiveItemWhenPageLoad) {
                if ($('.leftnav .list li.active')[0]) {
                    var activeItemOffsetTop = $('.leftnav .list li.active')[0].offsetTop;
                    if (activeItemOffsetTop > 150) {
                        $el.slimscroll({
                            scrollTo: activeItemOffsetTop + 'px'
                        });
                    }
                }
            }
        }
    },
    checkStatuForResize: function (firstTime) {
        var $body = $('body');
        var $openCloseBar = $('.navbar .navbar-header .bars');
        var width = $body.width();

        if (firstTime) {
            $body.find('.leftnav-container').addClass('no-animate').delay(1000).queue(function () {
                $(this).removeClass('no-animate').dequeue();
            });
        }

        if (width < leftnav.options.mobileBreakPoint) {
            $body.addClass('ls-closed');
            $openCloseBar.fadeIn();
        } else {
            $body.removeClass('ls-closed');
            $openCloseBar.fadeOut();
        }
    },
    isOpen: function () {
        return $('body').hasClass('overlay-open');
    }
};

leftnav.navbar = {
    activate: function () {
        var $body = $('body');
        var $overlay = $('.overlay');

        //Open left sidebar panel
        $('.bars').on('click', function () {
            $body.toggleClass('overlay-open');
            if ($body.hasClass('overlay-open')) {
                $overlay.fadeIn();
            } else {
                $overlay.fadeOut();
            }
        });

        //Close collapse bar on click event
        $('.nav [data-close="true"]').on('click', function () {
            var isVisible = $('.navbar-toggle').is(':visible');
            var $navbarCollapse = $('.navbar-collapse');

            if (isVisible) {
                $navbarCollapse.slideUp(function () {
                    $navbarCollapse.removeClass('in').removeAttr('style');
                });
            }
        });
    }
};

leftnav.init = function () {
    this.leftSideBar.activate();
    this.navbar.activate();
    this.browser.activate();
}