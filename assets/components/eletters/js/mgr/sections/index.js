Ext.onReady(function() {
    MODx.load({ xtype: 'eletters-page-home'});
});

Eletters.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'eletters-panel-home'
            ,renderTo: 'eletters-panel-home-div'
        }]
    });
    Eletters.page.Home.superclass.constructor.call(this,config);
};

Ext.extend(Eletters.page.Home,MODx.Component);
Ext.reg('eletters-page-home',Eletters.page.Home);