Eletters.panel.Settings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'eletters-panel-settings'
        ,layout: 'form'
        ,url: Eletters.config.connectorUrl
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
                    url: Eletters.config.connectorUrl
                    ,params: postData
                    ,scope: this,
                    listeners: {
                        success: {fn:function(response) {
                                var status = response;
                                if(status.success == true) {
                                    MODx.msg.status({title: _('eletters.settings.saved')});
                                } else {
                                    MODx.msg.status({title: _('eletters.settings.error')});
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
                    fieldLabel: _('eletters.settings.name'),
                    name: 'name',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    fieldLabel: _('eletters.settings.email'),
                    name: 'email',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    fieldLabel: _('eletters.settings.bounceemail'),
                    name: 'bounceemail',
                    allowBlank: false
                }
            ]
        }]
        ,border: false
    });
    Eletters.panel.Settings.superclass.constructor.call(this,config);
};
Ext.extend(Eletters.panel.Settings,MODx.FormPanel, {});
Ext.reg('eletters-panel-settings',Eletters.panel.Settings);