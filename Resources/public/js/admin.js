pimcore.registerNS("pimcore.plugin.divantetracking.admin");

pimcore.plugin.divantetracking.admin = Class.create({
    refreshInterval : 5,

    searchParams: {},
    initialize: function () {
        this.getTabPanel();
    },

    activate: function () {
        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
        tabPanel.setActiveItem("pimcore_plugin_divantetracking_admin");
    },

    getTabPanel: function () {
        if(!this.panel) {
            this.panel = new Ext.Panel({
                id: "pimcore_plugin_divantetracking_admin",
                title: "User Tracking",
                border: false,
                layout: "fit",
                iconCls: "pimcore_icon_log_admin",
                closable:true
            });

            this.autoRefreshTask = {
                run: function(){
                    this.store.reload();
                }.bind(this),
                interval: (this.refreshInterval*1000)
            };

            this.intervalInSeconds = {
                xtype: "numberfield",
                name: "interval",
                width: 70,
                value: 5,
                listeners: {
                    change: function (item, value) {
                        if(value < 1){
                            value = 1;
                        }
                        Ext.TaskManager.stop(this.autoRefreshTask);
                        if(this.autoRefresh.getValue()){
                            this.autoRefreshTask.interval = value*1000;
                            Ext.TaskManager.start(this.autoRefreshTask);
                        }

                    }.bind(this)
                }
            }

            this.autoRefresh = new Ext.form.Checkbox({
                stateful: true,
                stateId: 'log_auto_refresh',
                stateEvents: ['click'],
                checked : false,
                boxLabel: t('log_refresh_label'),
                listeners: {
                    change: function (cbx, checked) {
                        if (checked) {
                            // this.resultpanel.view.loadMask.destroy();
                            Ext.TaskManager.start(this.autoRefreshTask);
                        } else {
                            //Todo: enable load mask
                            Ext.TaskManager.stop(this.autoRefreshTask);
                        }
                    }.bind(this)
                }
            });



            var tabPanel = Ext.getCmp("pimcore_panel_tabs");
            tabPanel.add(this.panel);
            tabPanel.setActiveItem("pimcore_plugin_divantetracking_admin");

            this.panel.on("destroy", function () {
                pimcore.globalmanager.remove("pimcore_plugin_divantetracking_admin");
            }.bind(this));

            var itemsPerPage = pimcore.helpers.grid.getDefaultPageSize();
            this.store = pimcore.helpers.grid.buildDefaultStore(
                '/admin/user-tracking/find?',
                [
                    'id', 'createdAt', 'userId', 'controller', 'route', 'routeParams', 'params'
                ],
                itemsPerPage
            );
            var reader = this.store.getProxy().getReader();
            reader.setRootProperty('p_results');
            reader.setTotalProperty('p_totalCount');

            this.pagingToolbar = pimcore.helpers.grid.buildDefaultPagingToolbar(this.store);
            //auto reload items
            this.pagingToolbar.insert(11,"-");
            this.pagingToolbar.insert(12,this.autoRefresh);
            this.pagingToolbar.insert(13,this.intervalInSeconds);
            this.pagingToolbar.insert(14,t("log_refresh_seconds"));

            this.resultpanel = new Ext.grid.GridPanel({
                store: this.store,
                title: "User Tracking",
                trackMouseOver:false,
                disableSelection:true,
                autoScroll: true,
                region: "center",
                columns:[{
                    header: "Created",
                    dataIndex: 'createdAt',
                    flex: true,
                    sortable: true
                },{
                    header: "User",
                    dataIndex: 'userId',
                    flex: true,
                    sortable: true                    
                },{
                    header: "Controller",
                    dataIndex: 'controller',
                    flex: true,
                    sortable: true
                },{
                    header: "Route",
                    dataIndex: 'route',
                    flex: true,
                    sortable: true                    
                },{
                    header: "Route params",
                    dataIndex: 'routeParams',
                    flex: true,
                    sortable: false,
                    hidden: true
                },{
                    header: "Params",
                    dataIndex: 'params',
                    flex: true,
                    sortable: false,
                    hidden: true                    
                }],

                listeners: {
                    rowdblclick : function(grid, record, tr, rowIndex, e, eOpts ) {
                        //TODO
                        new pimcore.plugin.divantetracking.detailwindow(this.store.getAt(rowIndex).data);
                    }.bind(this)
                },

                // paging bar on the bottom
                bbar: this.pagingToolbar

            });

            this.fromDate = new Ext.form.DateField({
                // id: 'from_date',
                name: 'from_date',
                width: 130,
                xtype: 'datefield'
            });

            this.fromTime = new Ext.form.TimeField({
                // id: 'from_time',
                name: 'from_time',
                width: 100,
                xtype: 'timefield'
            });

            this.toDate = new Ext.form.DateField({
                // id: 'to_date',
                name: 'to_date',
                width: 130,
                xtype: 'datefield'
            });

            this.toTime = new Ext.form.TimeField({
                // id: 'to_time',
                name: 'to_time',
                width: 100,
                xtype: 'timefield'
            });

            var formSearch = this.find.bind(this);
            this.searchpanel = new Ext.FormPanel({
                region: "east",
                title: t("log_search_form"),
                width: 370,
                height: 500,
                border: false,
                autoScroll: true,
                buttons: [{
                    text: t("log_reset_search"),
                    handler: this.clearValues.bind(this),
                    iconCls: "pimcore_icon_stop"
                },{
                    text: t("log_search"),
                    handler: this.find.bind(this),
                    iconCls: "pimcore_icon_search"
                }],
                listeners: {
                    afterRender: function(formCmp) {
                        this.keyNav = Ext.create('Ext.util.KeyNav', formCmp.el, {
                            enter: formSearch,
                            scope: this
                        });
                    }
                },
                items: [ {
                    xtype:'fieldset',
                    // id:'log_search_form',
                    autoHeight:true,
                    labelWidth: 150,
                    items :[
                        {
                            xtype: 'fieldcontainer',
                            layout: 'hbox',
                            fieldLabel: t('log_search_from'),
                            combineErrors: true,
                            name: 'from',
                            items: [this.fromDate, this.fromTime]
                        },{
                            xtype: 'fieldcontainer',
                            layout: 'hbox',
                            fieldLabel: t('log_search_to'),
                            combineErrors: true,
                            name: 'to',
                            items: [this.toDate, this.toTime]
                        },{
                            xtype:'numberfield',
                            name: 'userId',
                            fieldLabel: "User",
                            width: 335,
                            listWidth: 150                            
                        },{
                            xtype:'textfield',
                            name: 'controller',
                            fieldLabel: "Controller",
                            width: 335,
                            listWidth: 150                            
                        },{
                            xtype:'textfield',
                            name: 'route',
                            fieldLabel: 'Route',
                            width: 335,
                            listWidth: 150                            
                        },{
                            xtype:'textfield',
                            name: 'routeParams',
                            fieldLabel: "Route params",
                            width: 335,
                            listWidth: 150                            
                        },{
                            xtype:'textfield',
                            name: 'params',
                            fieldLabel: 'Params',
                            width: 335,
                            listWidth: 150                            
                        }]
                }]});

            this.layout = new Ext.Panel({
                border: false,
                layout: "border",
                items: [this.searchpanel, this.resultpanel],
            });


            this.panel.add(this.layout);
            this.store.load();
            pimcore.layout.refresh();
        }
        return this.panel;
    },

    clearValues: function(){
        this.searchpanel.getForm().reset();

        this.searchParams.fromDate = null;
        this.searchParams.fromTime = null;
        this.searchParams.toDate = null;
        this.searchParams.toTime = null;
        this.searchParams.userId = null;
        this.searchParams.controller = null;
        this.searchParams.route = null;
        this.searchParams.routeParams = null;
        this.searchParams.params = null;                
        this.store.baseParams = this.searchParams;
        this.store.reload({
            params:this.searchParams
        });
    },


    find: function(){
        var formValues = this.searchpanel.getForm().getFieldValues();

        this.searchParams.fromDate = this.fromDate.getValue();
        this.searchParams.fromTime = this.fromTime.getValue();
        this.searchParams.toDate = this.toDate.getValue();
        this.searchParams.toTime = this.toTime.getValue();
        this.searchParams.userId = formValues.userId;
        this.searchParams.controller = formValues.controller;
        this.searchParams.route = formValues.route;
        this.searchParams.routeParams = formValues.routeParams;
        this.searchParams.params = formValues.params;
        
        var proxy = this.store.getProxy();
        proxy.extraParams = this.searchParams;
        //this.store.baseParams = this.searchParams;

        this.pagingToolbar.moveFirst();
    }


});
