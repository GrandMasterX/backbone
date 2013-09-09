/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'text!templates/modal/page.html',
    'models/send_modal',
    'backboneBUI',
    'jquery',
    'underscore',
    'backbone'
], function (Marionette, ModalTemplate, SendModel, App,$, _, Backbone) {

    return Backbone.Model.extend({

        template: ModalTemplate,

        events:{
            'click .send_modal' : 'send'
        },

        initialize:function () {
            this.model = new SendModel();
            this.model.on('error', this.error);
            this.model.on('success', this.success);
        },

        send:function(e) {
            //e.preventDefault();
            this.model.url = 'site/modal';
            this.model.set({
                name:this.$('input[name=name]').val(),
                company:this.$('input[name=company]').val(),
                url:this.$('input[name=link]').val(),
                phone:this.$('input[name=phone]').val(),
                email:this.$('input[name=mail]').val(),
                text:this.$('textarea').val()
            });
            this.model.save();
        },

        error:function (model, response) {
            if(response.status ==200)
                var type = Backbone.BUI.Config.Alert.SUCCESS;
            else
                var type = Backbone.BUI.Config.Alert.ERROR;
            if (response.responseText) {
                var alertError = new Backbone.BUI.Alert({
                    ctype: type,
                    title:'Here we go!',
                    message:response.responseText,
                    renderTo:$('.modal_slogan'), /* change to whatever */
                    timeout:3000
                });
                alertError.render();
            }
        }
    });
});
