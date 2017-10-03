pimcore.registerNS("pimcore.plugin.divantetracking.detailwindow");

pimcore.plugin.divantetracking.detailwindow = Class.create({
    getClassName: function (){
        return "pimcore.plugin.divantetracking.detailwindow";
    },

    initialize: function (data) {
        this.data = data;
        this.getInputWindow();
        this.detailWindow.show();
    },


    getInputWindow: function () {

        if(!this.detailWindow) {
            this.detailWindow = new Ext.Window({
                width: 600,
                height: 420,
                iconCls: "pimcore_icon_log",
                title: t('log_detailinformation'),
                closeAction:'close',
                plain: true,
                maximized: false,
                autoScroll: true,
                modal: true,
                buttons: [
                    {
                        text: t('close'),
                        handler: function(){
                            this.detailWindow.hide();
                            this.detailWindow.destroy();
                        }.bind(this)
                    }
                ]
            });

            this.createPanel();
        }
        return this.detailWindow;
    },


    createPanel: function() {
        var items = [];
        items.push({
            xtype: "textfield",
            fieldLabel: "Created",
            name: "createdAt",
            readOnly: true,
            value: this.data.createdAt,
            width: 540
        });
        items.push({
            xtype: "textfield",
            fieldLabel: "User",
            name: "userId",
            readOnly: true,
            value: this.data.userId,
            width: 540
        });   
        items.push({
            xtype: "textfield",
            fieldLabel: "Controller",
            name: "controller",
            readOnly: true,
            value: this.data.controller,
            width: 540
        });         
        items.push({
            xtype: "textfield",
            fieldLabel: "Route",
            name: "route",
            readOnly: true,
            value: this.data.route,
            width: 540
        });         
        items.push({
            xtype: "textarea",
            fieldLabel: "Route params",
            name: "routeParams",
            readOnly: true,
            value: this.data.routeParams,
            width: 540,
            height: 200
        });
        items.push({
            xtype: "textarea",
            fieldLabel: "Params",
            name: "params",
            readOnly: true,
            value: this.data.params,
            width: 540,
            height: 200
        });        

        var panel = new Ext.form.FormPanel({
            border: false,
            frame:false,
            bodyStyle: 'padding:10px',
            items: items,
            labelWidth: 130,
            collapsible: false,
            autoScroll: true
        });

        this.detailWindow.add(panel);
    }

});