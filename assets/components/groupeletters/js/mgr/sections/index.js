Ext.onReady(function() {
    MODx.load({ xtype: 'groupeletters-page-home'});
});

GroupEletters.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'groupeletters-panel-home'
            ,renderTo: 'groupeletters-panel-home-div'
        }]
    });
    GroupEletters.page.Home.superclass.constructor.call(this,config);
};

Ext.extend(GroupEletters.page.Home,MODx.Component);
Ext.reg('groupeletters-page-home',GroupEletters.page.Home);