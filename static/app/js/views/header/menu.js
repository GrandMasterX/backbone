/**
 * FooterPageView
 *
 * Renders footer
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 */
define([
    'backboneMarionette',
    'text!templates/header/menu.html',
    'models/menu',
    'backboneBUI'
], function (Marionette, HeaderTemplate, MenuModel, App) {

    return Marionette.ItemView.extend({
        template: HeaderTemplate,

        events:{
            'click a' : 'main'
        },

        initialize:function () {
            //_.bindAll(this, 'logout', 'checkAuth', 'error');


            // setup global events
            //App.vent.on('site:logout', this.logout, this);
            this.model = new MenuModel();
            //console.log(this.model);
            this.model.on('error', this.error);
            this.model.on('success', this.success);

            // fire checkAuth event when the attribute authenticated of
            // the LoginModel has been changed
            //this.model.on('change:authenticated', this.checkAuth);

        },

        main: function(e, response) {
            this.model.url = 'http://localhost/my_git/site/Getmenu';
            this.model.save('data');

        },

        error:function (model, response) {
            console.log(response.responseText);
            if(response.status ==200)
                var type = Backbone.BUI.Config.Alert.SUCCESS;
            else
                var type = Backbone.BUI.Config.Alert.ERROR;
            if (response.responseText) {
                var alertError = new Backbone.BUI.Alert({
                    ctype: type,
                    title:'Here we go!',
                    message:response.responseText,
                    renderTo:$('.menu'), /* change to whatever */
                    timeout:3000
                });
                alertError.render();
            }
        },

    });
});
