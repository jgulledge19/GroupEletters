Eletters.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [
            {
                html: '<h2>'+_('eletters')+' - '+_('eletters.desc')+'</h2>'
                ,border: false
                ,cls: 'modx-page-header'
            },{
                xtype: 'modx-tabs'
                ,bodyStyle: 'padding: 10px'
                ,defaults: { border: false ,autoHeight: true }
                ,border: true
                ,items: [
                    {
                        title: _('eletters.groups')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'eletters-grid-groups'
                            ,preventRender: true
                        }]
                    },{
                        title: _('eletters.subscribers')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'eletters-grid-subscribers'
                            ,preventRender: true
                        }]
                    },{
                        title: _('eletters.newsletters')
                        ,defaults: { autoHeight: true }
                        ,items: [
                            {
                                xtype: 'eletters-grid-newsletters'
                                ,preventRender: true
                            }
                        ]
                    }/*,
                    {
                        title: _('eletters.settings')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'eletters-panel-settings'
                            ,preventRender: true
                        }]
                        ,listeners: {
                             activate: {
                                fn: function() {
                                    MODx.Ajax.request({
                                        scope: this,
                                        url: Eletters.config.connectorUrl,
                                        params: {
                                            action: 'mgr/settings/get'
                                        }
                                        ,listeners: {
                                            success: {fn:function(reply) {
                                                var settingsConfig = reply;
                                                settingsConfig = settingsConfig.object;
                                                Ext.getCmp('eletters-panel-settings').getForm().setValues(settingsConfig);
                                            }, scope:this}
                                        }
                                    });
                                }
                            }
                        }
                    }*/
                ]
            }
        ]
    });
    Eletters.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Eletters.panel.Home,MODx.Panel);
Ext.reg('eletters-panel-home',Eletters.panel.Home);
