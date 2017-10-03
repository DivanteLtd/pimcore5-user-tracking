pimcore.registerNS("pimcore.plugin.divantetracking.plugin");

pimcore.plugin.divantetracking.plugin = Class.create(pimcore.plugin.admin, {

    getClassName: function () {
        return "pimcore.plugin.divantetracking.plugin";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // add a sub-menu item under "Extras" in the main menu
        var toolbar = pimcore.globalmanager.get("layout_toolbar");

        var action = new Ext.Action({
            id: "divantetracking_menu_item",
            text: "User Tracking",
            iconCls:"pimcore_icon_log_admin",
            handler: this.divanteTracking
        });

        toolbar.extrasMenu.add(action);
    },

    divanteTracking: function () {
        try {
            pimcore.globalmanager.get("pimcore_plugin_divantetracking_admin").activate();
        }
        catch (e) {
            pimcore.globalmanager.add(
                "pimcore_plugin_divantetracking_admin",
                new pimcore.plugin.divantetracking.admin()
            );
        }
    }
});

var divantetrackingPlugin = new pimcore.plugin.divantetracking.plugin();