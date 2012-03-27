Ditsnews.grid.Subscribers = function(config) {
    config = config || {};

    var activeCheckColumn = new Ext.ux.grid.CheckColumn({
        header: _('ditsnews.subscribers.active')
        ,dataIndex: 'active'
        ,width: 30
        ,sortable: false
    });

    Ext.applyIf(config,{
        id: 'ditsnews-grid-subscribers'
        ,url: Ditsnews.config.connectorUrl
        ,baseParams: { action: 'mgr/subscribers/list' }
        ,fields: ['id','active','email','firstname','lastname','company','signupdate']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'email'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 10
        },activeCheckColumn,{
            header: _('ditsnews.subscribers.email')
            ,dataIndex: 'email'
            ,sortable: true
        },{
            header: _('ditsnews.subscribers.firstname')
            ,dataIndex: 'firstname'
            ,sortable: true
        },{
            header: _('ditsnews.subscribers.lastname')
            ,dataIndex: 'lastname'
            ,sortable: true
        },{
            header: _('ditsnews.subscribers.company')
            ,dataIndex: 'company'
            ,sortable: true
        },{
            header: _('ditsnews.subscribers.signupdate')
            ,dataIndex: 'signupdate'
            ,sortable: true
        }]
        ,tbar: [{
            text: _('ditsnews.subscribers.new')
            ,handler: this.createSubscriber
        },'-',{
            xtype: 'textfield'
            ,id: 'subscribers-search-filter'
            ,emptyText: _('ditsnews.search...')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        },'-',{
            xtype: 'modx-combo'
            ,fieldLabel: _('ditsnews.groups')
            ,url: Ditsnews.config.connectorUrl
            ,baseParams: {
                action: 'mgr/groups/list'
                ,includeAll: 1
            }
            ,listeners: {
                'select': {fn:this.filterByGroup,scope:this}
            }
        }]
    });
    Ditsnews.grid.Subscribers.superclass.constructor.call(this,config)
};
Ext.extend(Ditsnews.grid.Subscribers,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterByGroup: function(combo) {
        var s = this.getStore();
        s.baseParams.groupfilter = combo.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        var m = [{
                text: _('ditsnews.subscribers.remove')
                ,handler: this.removeSubscriber
            },
            {
                text: _('ditsnews.subscribers.update')
                ,handler: this.updateSubscriber
            }
        ];
        this.addContextMenuItem(m);
        return true;
    }
    ,removeSubscriber: function() {
        MODx.msg.confirm({
            title: _('ditsnews.subscribers.remove')
            ,text: _('ditsnews.subscribers.remove.confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/subscribers/remove'
                ,subscriberId: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    ,createSubscriber: function(btn,e) {
        if (!this.CreateSubscriberWindow) {
            this.CreateSubscriberWindow = MODx.load({
                xtype: 'ditsnews-window-subscriber-create'
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.getGroups(0, 'ditsnews-window-subscriber-create');
        this.CreateSubscriberWindow.show(e.target);
    }
    ,updateSubscriber: function(btn,e) {
        if (!this.UpdateSubscriberWindow) {
            this.UpdateSubscriberWindow = MODx.load({
                xtype: 'ditsnews-window-subscriber-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        } else {
            this.UpdateSubscriberWindow.setValues(this.menu.record);
        }
        this.getGroups(this.menu.record.id, 'ditsnews-window-subscriber-update');
        this.UpdateSubscriberWindow.show(e.target);
    },
    getGroups: function(subscriberId, formId) {
        MODx.Ajax.request({
            url: Ditsnews.config.connectorUrl,
            scope: this,
            params: {
                action: 'mgr/groups/getgrouplist',
                subscriberId: subscriberId
            },
            listeners: {
                success: {fn:function(response) {
                        groups = response.object;
                        Ext.getCmp('subscribergroups').removeAll();

                        if(groups.length > 0) {
                            Ext.each(groups, function(item, key) {
                                        Ext.getCmp('subscribergroups').add({
                                            xtype: 'checkbox',
                                            name: 'groups_'+item.id,
                                            boxLabel: item.name,
                                            hideLabel: true,
                                            inputValue: true,
                                            checked: item.checked
                                        });
                            }, this);
                        }
                        Ext.getCmp(formId).doLayout(false, true);
                    }
                }
            }
        });
    }
});
Ext.reg('ditsnews-grid-subscribers',Ditsnews.grid.Subscribers);

Ditsnews.window.CreateSubscriber = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'ditsnews-window-subscriber-create'
        ,title: _('ditsnews.subscribers.new')
        ,url: Ditsnews.config.connectorUrl
        ,baseParams: {
            action: 'mgr/subscribers/create'
        }
        ,fields: [
            {
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.subscribers.email')
                ,name: 'email'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.subscribers.firstname')
                ,name: 'firstname'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.subscribers.lastname')
                ,name: 'lastname'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.subscribers.company')
                ,name: 'company'
                ,width: 300
                ,allowBlank: true
            },{
                xtype: 'checkbox'
                ,fieldLabel: _('ditsnews.subscribers.active')
                ,name: 'active'
                ,width: 300
                ,inputValue: 1
            },{
                xtype: 'fieldset',
                id: 'subscribergroups',
                fieldLabel: _('ditsnews.subscribers.groups'),
                items: []
            }
        ]
    });
    Ditsnews.window.CreateSubscriber.superclass.constructor.call(this,config);
};
Ext.extend(Ditsnews.window.CreateSubscriber,MODx.Window);
Ext.reg('ditsnews-window-subscriber-create',Ditsnews.window.CreateSubscriber);

Ditsnews.window.UpdateSubscriber = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'ditsnews-window-subscriber-update'
        ,title: _('ditsnews.subscribers.update')
        ,url: Ditsnews.config.connectorUrl
        ,baseParams: {
            action: 'mgr/subscribers/update'
        }
        ,fields: [
            {
                xtype: 'hidden'
                ,name: 'id'
            },{
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.subscribers.email')
                ,name: 'email'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.subscribers.firstname')
                ,name: 'firstname'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.subscribers.lastname')
                ,name: 'lastname'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.subscribers.company')
                ,name: 'company'
                ,width: 300
                ,allowBlank: true
            },{
                xtype: 'checkbox'
                ,fieldLabel: _('ditsnews.subscribers.active')
                ,name: 'active'
                ,width: 300
                ,inputValue: 1
            },{
                xtype: 'fieldset',
                id: 'subscribergroups',
                fieldLabel: _('ditsnews.subscribers.groups'),
                items: []
            }
        ]
    });
    Ditsnews.window.UpdateSubscriber.superclass.constructor.call(this,config);
};
Ext.extend(Ditsnews.window.UpdateSubscriber,MODx.Window);
Ext.reg('ditsnews-window-subscriber-update',Ditsnews.window.UpdateSubscriber);