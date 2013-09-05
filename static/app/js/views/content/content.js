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
    'text!templates/content/content.html'
], function (Marionette, ContentTemplate) {

    return Marionette.ItemView.extend({

        events:{
            'click #getIn':'getin',
            'click #Modal_invite' : 'getout'
        },

        getin:function (e) {
            var target = e.target;
            e.preventDefault();
            $('.modal_template').show();
            $('.modal-body').css('max-height','100%')
           // console.log('changing ' + target.id + ' from: ' + target.defaultValue + ' to: ' + target.value);
            // You could change your model on the spot, like this:
            // var change = {};
            // change[target.name] = target.value;
            // this.model.set(change);
        },

        getout:function(e) {
            var target = e.target;
            //target.hide();
        },

        template: ContentTemplate
    });
});
