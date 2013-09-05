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
    'backboneBUI'
], function (Marionette, ModalTemplate, SendModel, App) {
    return Marionette.ItemView.extend({

        template: ModalTemplate,

        events:{
            'click .send_modal' : 'send'
        },

        initialize:function () {
            //_.bindAll(this, 'logout', 'checkAuth', 'error');


            // setup global events
            //App.vent.on('site:logout', this.logout, this);
            this.model = new SendModel();
            //console.log(this.model);
            this.model.on('error', this.error);
            this.model.on('success', this.success);

            // fire checkAuth event when the attribute authenticated of
            // the LoginModel has been changed
            //this.model.on('change:authenticated', this.checkAuth);

        },

        send:function(e) {
            //e.preventDefault();
            this.model.url = 'http://localhost/my_git/site/modal';
            this.model.save({
                name:this.$('input[name=name]').val(),
                company:this.$('input[name=company]').val(),
                url:this.$('input[name=link]').val(),
                phone:this.$('input[name=phone]').val(),
                email:this.$('input[name=mail]').val(),
                text:this.$('textarea').val()
            });
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
        },
    });
});
