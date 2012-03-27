Ditsnews.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [
            {
                html: '<h2>'+_('ditsnews')+' - '+_('ditsnews.desc')+'</h2>'
                ,border: false
                ,cls: 'modx-page-header'
            },{
                xtype: 'modx-tabs'
                ,bodyStyle: 'padding: 10px'
                ,defaults: { border: false ,autoHeight: true }
                ,border: true
                ,items: [
                    {
                        title: _('ditsnews.newsletters')
                        ,defaults: { autoHeight: true }
                        ,items: [
                            {
                                xtype: 'ditsnews-grid-newsletters'
                                ,preventRender: true
                            }
                        ]
                    },{
                        title: _('ditsnews.groups')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'ditsnews-grid-groups'
                            ,preventRender: true
                        }]
                    },{
                        title: _('ditsnews.subscribers')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'ditsnews-grid-subscribers'
                            ,preventRender: true
                        }]
                    },
                    {
                        title: _('ditsnews.settings')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'ditsnews-panel-settings'
                            ,preventRender: true
                        }]
                        ,listeners: {
                             activate: {
                                fn: function() {
                                    MODx.Ajax.request({
                                        scope: this,
                                        url: Ditsnews.config.connectorUrl,
                                        params: {
                                            action: 'mgr/settings/get'
                                        }
                                        ,listeners: {
                                            success: {fn:function(reply) {
                                                var settingsConfig = reply;
                                                settingsConfig = settingsConfig.object;
                                                Ext.getCmp('ditsnews-panel-settings').getForm().setValues(settingsConfig);
                                            }, scope:this}
                                        }
                                    });
                                }
                            }
                        }
                    }
                ]
            }
        ]
    });
    Ditsnews.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Ditsnews.panel.Home,MODx.Panel);
Ext.reg('ditsnews-panel-home',Ditsnews.panel.Home);
