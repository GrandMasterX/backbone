/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'models/know_more',
    'backboneBUI'
], function (Marionette, SendModel, App) {
    return Marionette.ItemView.extend({

        el:'.know_more_about_us',

        events:{
            'click' : 'send'
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
            e.preventDefault();
            this.model.url = 'site/knowmore';
            console.log($('input[name=know_emeil]').val());
            this.model.save({
                email:$('input[name=know_emeil]').val()
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
