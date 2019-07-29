$.multimenu = {};
$.multimenu.dropup = {
    activate: function () {
        //adds the bars icon for the mobile
        $(".dropup").before("<a href=\"#\" class=\"dropup-mobile\">Navigation</a>");

        //adds class to li if it has child ul
        $(".dropup  li:has( > ul)").addClass("has-children");

        //for normal menu
        if ($(window).width() > 960) {
            $('.dropup > ul > li ul').addClass('sub-menu');
        } else {
            //activate the mobile script
            this.activateMobileScript();
        }

        //enable the mobile menu anchor
        this.enableMobileMenu();
        
        //Set Waves
        Waves.attach('.dropup-menu a', ['waves-block']);
        Waves.init();
    },
    activateMobileScript: function () {
        this.bindMenuNavigation();
    },
    bindMenuNavigation:function(){
        $(".dropup >ul li").on('click', function (e) {
            if ($(window).width() < 943) {
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
    },
  
    enableMobileMenu:function(){
         //the following hides the menu when a click is registered outside
         $(document).on('click', function (e) {
            if ($(e.target).siblings('.dropup').length === 0)
                $(".dropup > ul").removeClass('show-on-mobile');
        });

        $(".dropup-mobile").on('click', function (e) {
            $(".dropup > ul").toggleClass('show-on-mobile');
            e.preventDefault();
        });
    }
};

$(document).ready(function () {
    $.multimenu.dropup.activate();
});