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
], function (Marionette) {

    return Marionette.ItemView.extend({

        events:{
            'click #getIn':'getin',
            'click #Modal_invite' : 'getout',
            'click .close': 'getout'
        },

        getin:function (e) {
            var target = e.target;
            e.preventDefault();
            $('.modal').show();
            $('.modal-body').css('max-height','100%');
        },

        getout:function(e) {
            var target = e.target;
            $('.modal').hide();
            $('.modal-header, .modal-body').css('max-height','0%');
        },
    });
});
