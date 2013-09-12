/**
 * Created by AstraFit on 28.08.13.
 */
/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'backbone',
    'app',
], function (Marionette, Backbone, App) {

    return Backbone.View.extend({

        el:'.magic_button',

        events:{
            'click':'slide',
        },

        initialize:function () {

        },

        slide:function (e) {
            var target = $(e.target);
            if(!target.hasClass('fadeInLeft')) {
                target.addClass('fadeInLeft');
                $('.menu,.main_page,.footer,.how_it_works,.service,.partners,.contacts')
                    .animate({
                            opacity: 0
                        }, 400
                    );
                setTimeout(function() {
                    $('.main_page,.footer,.how_it_works,.service,.partners,.contacts').hide();
                },400);
                $('.magic')
                    .show()
                    .animate({
                            opacity: 1,
                        }, 400
                    );
            } else {
                target.addClass('fadeInRight');
                $('.magic').hide()
                    .animate({
                        opacity: 0
                    },400
                    );
                $('.main_page,.footer,.how_it_works,.service,.partners,.contacts').show();
                $('.menu,.main_page,.footer,.how_it_works,.service,.partners,.contacts')
                    .animate(
                        {
                            opacity: 1
                        },400
                    );

                setTimeout(function() {
                    target.removeClass('fadeInLeft');
                    target.removeClass('fadeInRight');
                }, 420);
            }

        },

    });
});
