Ditsnews.panel.Settings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'ditsnews-panel-settings'
        ,layout: 'form'
        ,url: Ditsnews.config.connectorUrl
        ,baseCls: 'modx-formpanel'
        ,baseParams: { action: 'mgr/settings/get' }
        ,buttonAlign: 'left'
        ,buttons: [{
            text:  _('save'),
            scope: this,
            handler: function() {
                var postData = {
                    formData: Ext.encode(this.getForm().getFieldValues()),
                    action: 'mgr/settings/save'
                }
                MODx.Ajax.request({
                    url: Ditsnews.config.connectorUrl
                    ,params: postData
                    ,scope: this,
                    listeners: {
                        success: {fn:function(response) {
                                var status = response;
                                if(status.success == true) {
                                    MODx.msg.status({title: _('ditsnews.settings.saved')});
                                } else {
                                    MODx.msg.status({title: _('ditsnews.settings.error')});
                                }
                            }
                        }
                    }
                });
            }
        }]
        ,items: [{
            layout: 'form'
            ,items: [
                {
                    xtype: 'textfield',
                    fieldLabel: _('ditsnews.settings.name'),
                    name: 'name',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    fieldLabel: _('ditsnews.settings.email'),
                    name: 'email',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    fieldLabel: _('ditsnews.settings.bounceemail'),
                    name: 'bounceemail',
                    allowBlank: false
                }
            ]
        }]
        ,border: false
    });
    Ditsnews.panel.Settings.superclass.constructor.call(this,config);
};
Ext.extend(Ditsnews.panel.Settings,MODx.FormPanel, {});
Ext.reg('ditsnews-panel-settings',Ditsnews.panel.Settings);