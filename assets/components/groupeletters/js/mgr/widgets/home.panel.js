GroupEletters.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [
            {
                html: '<h2>'+_('groupeletters')+' - '+_('groupeletters.desc')+'</h2>'
                ,border: false
                ,cls: 'modx-page-header'
            },{
                xtype: 'modx-tabs'
                ,bodyStyle: 'padding: 10px'
                ,defaults: { border: false ,autoHeight: true }
                ,border: true
                ,items: [
                    {
                        title: _('groupeletters.groups')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'groupeletters-grid-groups'
                            ,preventRender: true
                        }]
                    },{
                        title: _('groupeletters.subscribers')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'groupeletters-grid-subscribers'
                            ,preventRender: true
                        }]
                    },{
                        title: _('groupeletters.newsletters')
                        ,defaults: { autoHeight: true }
                        ,items: [
                            {
                                xtype: 'groupeletters-grid-newsletters'
                                ,preventRender: true
                            }
                        ]
                    }/*,
                    {
                        title: _('groupeletters.settings')
                        ,defaults: { autoHeight: true }
                        ,items: [{
                            xtype: 'groupeletters-panel-settings'
                            ,preventRender: true
                        }]
                        ,listeners: {
                             activate: {
                                fn: function() {
                                    MODx.Ajax.request({
                                        scope: this,
                                        url: GroupEletters.config.connectorUrl,
                                        params: {
                                            action: 'mgr/settings/get'
                                        }
                                        ,listeners: {
                                            success: {fn:function(reply) {
                                                var settingsConfig = reply;
                                                settingsConfig = settingsConfig.object;
                                                Ext.getCmp('groupeletters-panel-settings').getForm().setValues(settingsConfig);
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
    GroupEletters.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.panel.Home,MODx.Panel);
Ext.reg('groupeletters-panel-home',GroupEletters.panel.Home);
