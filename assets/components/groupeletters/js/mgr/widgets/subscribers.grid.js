GroupEletters.grid.Subscribers = function(config) {
    config = config || {};

    var activeCheckColumn = new Ext.ux.grid.CheckColumn({
        header: _('groupeletters.subscribers.active')
        ,dataIndex: 'active'
        ,width: 30
        ,sortable: false
    });

    Ext.applyIf(config,{
        id: 'groupeletters-grid-subscribers'
        ,url: GroupEletters.config.connectorUrl
        ,baseParams: { action: 'mgr/subscribers/list' }
        ,save_action: 'mgr/subscribers/updateFromGrid'
        ,fields: ['id','crm_id','active','email','first_name','m_name','last_name','company', 'address','city','state','zip','country','phone','cell','date_created']
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
            header: _('groupeletters.subscribers.email')
            ,dataIndex: 'email'
            ,sortable: true
        },{
            header: _('groupeletters.subscribers.first_name')
            ,dataIndex: 'first_name'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('groupeletters.subscribers.last_name')
            ,dataIndex: 'last_name'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('groupeletters.subscribers.company')
            ,dataIndex: 'company'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('groupeletters.subscribers.signupdate')
            ,dataIndex: 'date_created'
            ,sortable: true
        }]
        ,tbar: [{
            text: _('groupeletters.subscribers.new')
            ,handler: this.createSubscriber
        },{
            text: _('groupeletters.subscribers.importcsv')
            ,handler: this.importSubscribers
        },'-',{
            xtype: 'textfield'
            ,id: 'subscribers-search-filter'
            ,emptyText: _('groupeletters.search...')
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
            ,fieldLabel: _('groupeletters.groups')
            ,url: GroupEletters.config.connectorUrl
            ,baseParams: {
                action: 'mgr/groups/list'
                ,includeAll: 1
            }
            ,listeners: {
                'select': {fn:this.filterByGroup,scope:this}
            }
        }]
    });
    GroupEletters.grid.Subscribers.superclass.constructor.call(this,config)
};
Ext.extend(GroupEletters.grid.Subscribers,MODx.grid.Grid,{
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
                text: _('groupeletters.subscribers.remove')
                ,handler: this.removeSubscriber
            },
            {
                text: _('groupeletters.subscribers.update')
                ,handler: this.updateSubscriber
            }
        ];
        this.addContextMenuItem(m);
        return true;
    }
    ,removeSubscriber: function() {
        MODx.msg.confirm({
            title: _('groupeletters.subscribers.remove')
            ,text: _('groupeletters.subscribers.remove.confirm')
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
    ,importSubscribers: function(btn,e) {
        if (!this.ImportSubscriberWindow) {
            this.ImportSubscriberWindow = MODx.load({
                xtype: 'groupeletters-window-subscriber-import'
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.getGroups(0, 'groupeletters-window-subscriber-import', 'subscribergroups-import');
        this.ImportSubscriberWindow.show(e.target);
    }
    ,createSubscriber: function(btn,e) {
        if (!this.CreateSubscriberWindow) {
            this.CreateSubscriberWindow = MODx.load({
                xtype: 'groupeletters-window-subscriber-create'
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.getGroups(0, 'groupeletters-window-subscriber-create', 'subscribergroups-create');
        this.CreateSubscriberWindow.show(e.target);
    }
    ,updateSubscriber: function(btn,e) {
        if (!this.UpdateSubscriberWindow) {
            this.UpdateSubscriberWindow = MODx.load({
                xtype: 'groupeletters-window-subscriber-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.UpdateSubscriberWindow.setValues(this.menu.record);
        
        this.getGroups(this.menu.record.id, 'groupeletters-window-subscriber-update', 'subscribergroups-update');
        this.UpdateSubscriberWindow.show(e.target);
    },
    getGroups: function(subscriberId, formId, groupsId) {
        MODx.Ajax.request({
            url: GroupEletters.config.connectorUrl,
            scope: this,
            params: {
                action: 'mgr/groups/getgrouplist',
                subscriberId: subscriberId
            },
            listeners: {
                success: {fn:function(response) {
                        groups = response.object;
                        
                        Ext.getCmp(groupsId).removeAll();

                        if(groups.length > 0) {
                            Ext.each(groups, function(item, key) {
                                        Ext.getCmp(groupsId).add({
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
Ext.reg('groupeletters-grid-subscribers',GroupEletters.grid.Subscribers);

function getSubscriberWindowObject(config, type) {
    config = config || {};
    this.ident = config.ident || 'cmp'+Ext.id();
    var hidden = '';
    if ( type == 'update') {
        hidden = 'id';
    }
    
    var object = {
        id: 'groupeletters-window-subscriber-' + type
        ,title: _('groupeletters.subscribers.'+type)
        ,url: GroupEletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/subscribers/'+type
        }
        
        ,width: 620
        ,action: type
        ,autoHeight: true
        ,shadow: false
        ,fields: [{
            xtype: 'modx-tabs'
            ,bodyStyle: { background: 'transparent' }
            ,autoHeight: true
            ,deferredRender: false
            ,items: [{
                title: _('groupeletters.subscribers.basic_info')
                ,layout: 'form'
                ,cls: 'modx-panel'
                ,forceLayout: true
                ,bodyStyle: { background: 'transparent', padding: '10px' }
                ,autoHeight: true
                ,labelWidth: 130
                ,items: [
                // basic info
                {
                    xtype: 'hidden'
                    ,name: hidden
                },{
                    xtype: 'checkbox'
                    ,fieldLabel: _('groupeletters.subscribers.active')
                    ,name: 'active'
                    /* ,width: 300 */
                    ,inputValue: 1
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('groupeletters.subscribers.crm_id')
                    ,name: 'crm_id'
                    ,width: 300
                    ,maxLength: 11
                    ,anchor: '100%'
                    ,allowBlank: true
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('groupeletters.subscribers.email')
                    ,name: 'email'
                    ,width: 300
                    ,maxLength: 128
                    ,anchor: '100%'
                    ,allowBlank: false
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('groupeletters.subscribers.first_name')
                    ,name: 'first_name'
                    ,width: 300
                    ,maxLength: 32
                    ,anchor: '100%'
                    ,allowBlank: false
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('groupeletters.subscribers.m_name')
                    ,name: 'm_name'
                    ,width: 300
                    ,maxLength: 32
                    ,anchor: '100%'
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('groupeletters.subscribers.last_name')
                    ,name: 'last_name'
                    ,width: 300
                    ,anchor: '100%'
                    ,maxLength: 32
                    ,allowBlank: false
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('groupeletters.subscribers.company')
                    ,name: 'company'
                    ,width: 300
                    ,anchor: '100%'
                    ,maxLength: 255
                    ,allowBlank: true
                }
                ]
            },{
                id: 'modx-'+this.ident+'-group'
                ,title: _('groupeletters.subscribers.groups_info')
                ,layout: 'form'
                ,cls: 'modx-panel'
                ,autoHeight: true
                ,forceLayout: true
                ,labelWidth: 130
                ,defaults: {autoHeight: true ,border: false}
                ,style: 'background: transparent;'
                ,bodyStyle: { background: 'transparent', padding: '10px' }
                ,items: //MODx.getQRSettings(this.ident,config.record)
                [
                    {
                        xtype: 'fieldset',
                        id: 'subscribergroups-'+type,
                        fieldLabel: _('groupeletters.subscribers.groups'),
                        items: []
                    }
                ]
            },{
                id: 'modx-'+this.ident+'-settings'
                ,title: _('groupeletters.subscribers.address_info')
                ,layout: 'form'
                ,cls: 'modx-panel'
                ,autoHeight: true
                ,forceLayout: true
                ,labelWidth: 130
                ,defaults: {autoHeight: true ,border: false}
                ,style: 'background: transparent;'
                ,bodyStyle: { background: 'transparent', padding: '10px' }
                ,items: //MODx.getQRSettings(this.ident,config.record)
                [
                    {
                        xtype: 'textfield'
                        ,fieldLabel: _('groupeletters.subscribers.phone')
                        ,name: 'phone'
                        ,width: 300
                        ,anchor: '100%'
                        ,maxLength: 16
                        ,allowBlank: true
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('groupeletters.subscribers.cell')
                        ,name: 'cell'
                        ,width: 300
                        ,maxLength: 16
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('groupeletters.subscribers.address')
                        ,name: 'address'
                        ,maxLength: 128
                        ,width: 300
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('groupeletters.subscribers.city')
                        ,name: 'city'
                        ,maxLength: 64
                        ,width: 300
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('groupeletters.subscribers.state')
                        ,name: 'state'
                        ,maxLength: 64
                        ,width: 300
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('groupeletters.subscribers.zip')
                        ,name: 'zip'
                        ,maxLength: 16
                        ,width: 300
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('groupeletters.subscribers.country')
                        ,name: 'country'
                        ,maxLength: 64
                        ,width: 300
                        ,anchor: '100%'
                    }
                ]
            }]
        }]
    };
    return object;
}

GroupEletters.window.UpdateSubscriber = function(config) {
    config = config || {};
    var locObject = getSubscriberWindowObject(config, 'update');
    Ext.applyIf(config,locObject);
    GroupEletters.window.UpdateSubscriber.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.window.UpdateSubscriber,MODx.Window);
Ext.reg('groupeletters-window-subscriber-update',GroupEletters.window.UpdateSubscriber);

GroupEletters.window.CreateSubscriber = function(config) {
    config = config || {};
    
    var locObject = getSubscriberWindowObject(config, 'create');
    Ext.applyIf(config,locObject);
    GroupEletters.window.CreateSubscriber.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.window.CreateSubscriber,MODx.Window);
Ext.reg('groupeletters-window-subscriber-create',GroupEletters.window.CreateSubscriber);

/**
 * Import CSV
 */
GroupEletters.window.ImportSubscribers = function(config) {
    config = config || {};
    var locObject = {
        id: 'groupeletters-window-subscriber-import'
        ,title: _('groupeletters.subscribers.importcsv')
        ,url: GroupEletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/subscribers/import'
        }
        ,fileUpload: true
        ,fields: [
            {
                xtype: 'textfield',
                inputType: 'file',
                fieldLabel: _('groupeletters.subscribers.importcsv.file'),
                name: 'csv',
                allowBlank: false
            },{
                xtype: 'checkbox'
                ,fieldLabel: _('groupeletters.subscribers.active')
                ,name: 'active'
                ,width: 300
                ,inputValue: 1
            },{
                xtype: 'fieldset',
                id: 'subscribergroups-import',
                fieldLabel: _('groupeletters.subscribers.import'),
                items: []
            }
        ]
    };
    Ext.applyIf(config,locObject);
    GroupEletters.window.ImportSubscribers.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.window.ImportSubscribers,MODx.Window);
Ext.reg('groupeletters-window-subscriber-import',GroupEletters.window.ImportSubscribers);