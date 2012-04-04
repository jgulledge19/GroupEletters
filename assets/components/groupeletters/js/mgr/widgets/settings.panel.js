GroupEletters.panel.Settings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'groupeletters-panel-settings'
        ,layout: 'form'
        ,url: GroupEletters.config.connectorUrl
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
                    url: GroupEletters.config.connectorUrl
                    ,params: postData
                    ,scope: this,
                    listeners: {
                        success: {fn:function(response) {
                                var status = response;
                                if(status.success == true) {
                                    MODx.msg.status({title: _('groupeletters.settings.saved')});
                                } else {
                                    MODx.msg.status({title: _('groupeletters.settings.error')});
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
                    fieldLabel: _('groupeletters.settings.name'),
                    name: 'name',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    fieldLabel: _('groupeletters.settings.email'),
                    name: 'email',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    fieldLabel: _('groupeletters.settings.bounceemail'),
                    name: 'bounceemail',
                    allowBlank: false
                }
            ]
        }]
        ,border: false
    });
    GroupEletters.panel.Settings.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.panel.Settings,MODx.FormPanel, {});
Ext.reg('groupeletters-panel-settings',GroupEletters.panel.Settings);