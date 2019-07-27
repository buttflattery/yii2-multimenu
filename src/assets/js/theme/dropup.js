$.multimenu = {};
$.multimenu.dropup = {
    activate: function () {
        $('.dropup > ul > li ul').addClass('sub-menu');
           //Set Waves
           Waves.attach('.dropup-menu a', ['waves-block']);
           Waves.init();
    },

};

$(document).ready(function(){
    $.multimenu.dropup.activate();
});