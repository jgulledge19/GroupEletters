Eletters.grid.Subscribers = function(config) {
    config = config || {};

    var activeCheckColumn = new Ext.ux.grid.CheckColumn({
        header: _('eletters.subscribers.active')
        ,dataIndex: 'active'
        ,width: 30
        ,sortable: false
        ,editor: { xtype: 'xcheckbox' }
    });

    Ext.applyIf(config,{
        id: 'eletters-grid-subscribers'
        ,url: Eletters.config.connectorUrl
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
        }, activeCheckColumn,
       /*{
            header: _('eletters.subscribers.active')
            ,dataIndex: 'active'
            ,width: 30
            ,sortable: false
            ,editor: { xtype: 'xcheckbox' }
       },*/{
            header: _('eletters.subscribers.last_name')
            ,dataIndex: 'last_name'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('eletters.subscribers.first_name')
            ,dataIndex: 'first_name'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('eletters.subscribers.email')
            ,dataIndex: 'email'
            ,sortable: true
        },{
            header: _('eletters.subscribers.company')
            ,dataIndex: 'company'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('eletters.subscribers.signupdate')
            ,dataIndex: 'date_created'
            ,sortable: true
        }]
        ,tbar: [{
            text: _('eletters.subscribers.new')
            ,handler: this.createSubscriber
        },{
            text: _('eletters.subscribers.importcsv')
            ,handler: this.importSubscribers
        },'-',{
            xtype: 'textfield'
            ,id: 'subscribers-search-filter'
            ,emptyText: _('eletters.search...')
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
            ,fieldLabel: _('eletters.groups')
            ,url: Eletters.config.connectorUrl
            ,baseParams: {
                action: 'mgr/groups/list'
                ,includeAll: 1
            }
            ,listeners: {
                'select': {fn:this.filterByGroup,scope:this}
            }
        }]
    });
    Eletters.grid.Subscribers.superclass.constructor.call(this,config)
};
Ext.extend(Eletters.grid.Subscribers,MODx.grid.Grid,{
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
                text: _('eletters.subscribers.remove')
                ,handler: this.removeSubscriber
            },
            {
                text: _('eletters.subscribers.update')
                ,handler: this.updateSubscriber
            }
        ];
        this.addContextMenuItem(m);
        return true;
    }
    ,removeSubscriber: function() {
        MODx.msg.confirm({
            title: _('eletters.subscribers.remove')
            ,text: _('eletters.subscribers.remove.confirm')
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
                xtype: 'eletters-window-subscriber-import'
                ,listeners: {
                    'success': {
                        //fn:this.importMessage
                        fn: function(xhr) {
                            /**
                            var output = '';
                            for (property in xhr) {
                              output += property + ': ' + xhr[property]+'; ';
                            }
                            console.log(xhr);
                            console.log(xhr.f.getValues());
                            console.log(xhr.a.result);
                            */
                            var m = xhr.a.result.message.split("<br>");
                            var o = '';
                            for(i = 0; i < m.length; i++){
                                // console.log(m[i]);
                                var tmp = m[i].split(":");
                                o += '<tr><td>' + tmp[0] + ' </td><td>' + tmp[1] + '</td></tr>';
                            }
                            if ( o.length > 1 ) {
                                o = '<table>' + o + '</table>';
                            } else {
                                o = xhr.a.result.message;
                            }
                            Ext.MessageBox.alert(_('eletters.subscribers.importcsv.results'), o );
                            
                        },scope:this
                        
                        }
                }
            });
        }
        this.getGroups(0, 'eletters-window-subscriber-import', 'subscribergroups-import');
        this.ImportSubscriberWindow.show(e.target);
    }
    ,createSubscriber: function(btn,e) {
        if (!this.CreateSubscriberWindow) {
            this.CreateSubscriberWindow = MODx.load({
                xtype: 'eletters-window-subscriber-create'
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.getGroups(0, 'eletters-window-subscriber-create', 'subscribergroups-create');
        this.CreateSubscriberWindow.show(e.target);
    }
    ,updateSubscriber: function(btn,e) {
        if (!this.UpdateSubscriberWindow) {
            this.UpdateSubscriberWindow = MODx.load({
                xtype: 'eletters-window-subscriber-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.UpdateSubscriberWindow.setValues(this.menu.record);
        
        this.getGroups(this.menu.record.id, 'eletters-window-subscriber-update', 'subscribergroups-update');
        this.UpdateSubscriberWindow.show(e.target);
    },
    getGroups: function(subscriberId, formId, groupsId) {
        MODx.Ajax.request({
            url: Eletters.config.connectorUrl,
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
Ext.reg('eletters-grid-subscribers',Eletters.grid.Subscribers);

function getSubscriberWindowObject(config, type) {
    config = config || {};
    this.ident = config.ident || 'cmp'+Ext.id();
    var hidden = '';
    if ( type == 'update') {
        hidden = 'id';
    }
    
    var object = {
        id: 'eletters-window-subscriber-' + type
        ,title: _('eletters.subscribers.'+type)
        ,url: Eletters.config.connectorUrl
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
                title: _('eletters.subscribers.basic_info')
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
                    xtype: 'xcheckbox'
                    ,fieldLabel: _('eletters.subscribers.active')
                    ,name: 'active'
                    /* ,width: 300 */
                    ,inputValue: 1
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('eletters.subscribers.crm_id')
                    ,name: 'crm_id'
                    ,width: 300
                    ,maxLength: 11
                    ,anchor: '100%'
                    ,allowBlank: true
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('eletters.subscribers.email')
                    ,name: 'email'
                    ,width: 300
                    ,maxLength: 128
                    ,anchor: '100%'
                    ,allowBlank: false
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('eletters.subscribers.first_name')
                    ,name: 'first_name'
                    ,width: 300
                    ,maxLength: 32
                    ,anchor: '100%'
                    ,allowBlank: false
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('eletters.subscribers.m_name')
                    ,name: 'm_name'
                    ,width: 300
                    ,maxLength: 32
                    ,anchor: '100%'
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('eletters.subscribers.last_name')
                    ,name: 'last_name'
                    ,width: 300
                    ,anchor: '100%'
                    ,maxLength: 32
                    ,allowBlank: false
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('eletters.subscribers.company')
                    ,name: 'company'
                    ,width: 300
                    ,anchor: '100%'
                    ,maxLength: 255
                    ,allowBlank: true
                }
                ]
            },{
                id: 'modx-'+this.ident+'-group'
                ,title: _('eletters.subscribers.groups_info')
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
                        fieldLabel: _('eletters.subscribers.groups'),
                        items: []
                    }
                ]
            },{
                id: 'modx-'+this.ident+'-settings'
                ,title: _('eletters.subscribers.address_info')
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
                        ,fieldLabel: _('eletters.subscribers.phone')
                        ,name: 'phone'
                        ,width: 300
                        ,anchor: '100%'
                        ,maxLength: 16
                        ,allowBlank: true
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('eletters.subscribers.cell')
                        ,name: 'cell'
                        ,width: 300
                        ,maxLength: 16
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('eletters.subscribers.address')
                        ,name: 'address'
                        ,maxLength: 128
                        ,width: 300
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('eletters.subscribers.city')
                        ,name: 'city'
                        ,maxLength: 64
                        ,width: 300
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('eletters.subscribers.state')
                        ,name: 'state'
                        ,maxLength: 64
                        ,width: 300
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('eletters.subscribers.zip')
                        ,name: 'zip'
                        ,maxLength: 16
                        ,width: 300
                        ,anchor: '100%'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('eletters.subscribers.country')
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

Eletters.window.UpdateSubscriber = function(config) {
    config = config || {};
    var locObject = getSubscriberWindowObject(config, 'update');
    Ext.applyIf(config,locObject);
    Eletters.window.UpdateSubscriber.superclass.constructor.call(this,config);
};
Ext.extend(Eletters.window.UpdateSubscriber,MODx.Window);
Ext.reg('eletters-window-subscriber-update',Eletters.window.UpdateSubscriber);

Eletters.window.CreateSubscriber = function(config) {
    config = config || {};
    
    var locObject = getSubscriberWindowObject(config, 'create');
    Ext.applyIf(config,locObject);
    Eletters.window.CreateSubscriber.superclass.constructor.call(this,config);
};
Ext.extend(Eletters.window.CreateSubscriber,MODx.Window);
Ext.reg('eletters-window-subscriber-create',Eletters.window.CreateSubscriber);

/**
 * Import CSV
 */
Eletters.window.ImportSubscribers = function(config) {
    config = config || {};
    var locObject = {
        id: 'eletters-window-subscriber-import'
        ,title: _('eletters.subscribers.importcsv')
        ,url: Eletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/subscribers/import'
        }
        ,fileUpload: true
        ,fields: [
            {
                html: '<p><a href="' + Eletters.config.assetsUrl + 'example-import.csv">' 
                    +  _('eletters.subscribers.importcsv.example') + '</a> | ' +
                    '<a href="' + Eletters.config.assetsUrl + 'example-full-import.csv">'
                    +  _('eletters.subscribers.importcsv.completeExample') + '</a></p>'
                ,border: false
                ,bodyStyle: 'padding-bottom: 10px'
            },{
                xtype: 'textfield',
                inputType: 'file',
                fieldLabel: _('eletters.subscribers.importcsv.file'),
                name: 'csv',
                allowBlank: false
            },{
                xtype: 'xcheckbox'
                ,fieldLabel: _('eletters.subscribers.active')
                ,name: 'active'
                ,width: 300
                ,inputValue: 1
            },{
                xtype: 'fieldset',
                id: 'subscribergroups-import',
                fieldLabel: _('eletters.subscribers.import'),
                items: []
            }
        ]
    };
    Ext.applyIf(config,locObject);
    Eletters.window.ImportSubscribers.superclass.constructor.call(this,config);
};
Ext.extend(Eletters.window.ImportSubscribers,MODx.Window);
Ext.reg('eletters-window-subscriber-import',Eletters.window.ImportSubscribers);