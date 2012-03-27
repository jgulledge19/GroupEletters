Ext.onReady(function() {
    MODx.load({ xtype: 'ditsnews-page-home'});
});

Ditsnews.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'ditsnews-panel-home'
            ,renderTo: 'ditsnews-panel-home-div'
        }]
    });
    Ditsnews.page.Home.superclass.constructor.call(this,config);
};

Ext.extend(Ditsnews.page.Home,MODx.Component);
Ext.reg('ditsnews-page-home',Ditsnews.page.Home);