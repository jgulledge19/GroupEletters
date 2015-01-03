Eletters.grid.Groups = function(config) {
    config = config || {};

    var publicCheckColumn = new Ext.ux.grid.CheckColumn({
        header: _('eletters.groups.public')
        ,dataIndex: 'public'
        ,width: 10
        ,sortable: false
    });

    Ext.applyIf(config,{
        id: 'eletters-grid-groups'
        ,url: Eletters.config.connectorUrl
        ,baseParams: { action: 'mgr/groups/list' }
        ,save_action: 'mgr/groups/updateFromGrid'
        ,fields: ['id','name', 'parent','description','department','allow_signup','date_created','active','date_inactive','members']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 10
        },{
            header: _('eletters.groups.name')
            ,dataIndex: 'name'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('eletters.groups.members')
            ,dataIndex: 'members'
            ,sortable: false
            ,width: 30
        },{
            header: _('eletters.groups.active')
            ,dataIndex: 'active'
            ,sortable: true
            //,editor: { xtype: 'textfield' }
            //,width: 50
            ,allowBlank : false
            ,editor: { xtype: 'combo-boolean' ,renderer: 'boolean' /*'boolean'*/ }
        },{
            header: _('eletters.groups.description')
            ,dataIndex: 'description'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('eletters.groups.department')
            ,dataIndex: 'department'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('eletters.groups.allow_signup')
            ,dataIndex: 'allow_signup'
            ,sortable: true
            //,editor: { xtype: 'textfield' }
            //,width: 50
            ,allowBlank : false
            ,editor: { xtype: 'combo-boolean' ,renderer: 'boolean' /*'boolean'*/ }
        }]
        ,tbar: [{
            text: _('eletters.groups.new')
            ,handler: { xtype: 'eletters-window-group-create', blankValues: true }
        }]
    });
    Eletters.grid.Groups.superclass.constructor.call(this,config)
};
Ext.extend(Eletters.grid.Groups,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
                text: _('eletters.groups.remove')
                ,handler: this.removeGroup
            },
            {
                text: _('eletters.groups.update')
                ,handler: this.updateGroup
            }
        ];
        this.addContextMenuItem(m);
        return true;
    }
    ,removeGroup: function() {
        MODx.msg.confirm({
            title: _('eletters.groups.remove')
            ,text: _('eletters.groups.remove.confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/groups/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    ,updateGroup: function(btn,e) {
        if (!this.UpdateGroupWindow) {
            this.UpdateGroupWindow = MODx.load({
                xtype: 'eletters-window-group-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        } else {
            this.UpdateGroupWindow.setValues(this.menu.record);
        }
        this.UpdateGroupWindow.show(e.target);
    }
});
Ext.reg('eletters-grid-groups',Eletters.grid.Groups);

Eletters.window.CreateGroup = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('eletters.groups.new')
        ,url: Eletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/groups/create'
        }
        ,fields: [
            {
                xtype: 'textfield'
                ,fieldLabel: _('eletters.groups.name')
                ,name: 'name'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'combo-boolean'
                ,renderer: 'boolean'
                ,value: 1
                ,fieldLabel: _('eletters.groups.active')
                ,name: 'active'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textarea'
                ,fieldLabel: _('eletters.groups.description')
                ,name: 'description'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('eletters.groups.department')
                ,name: 'department'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'combo-boolean'
                ,renderer: 'boolean'
                //,value: 1
                ,fieldLabel: _('eletters.groups.allow_signup')
                ,name: 'allow_signup'
                ,width: 300
                ,allowBlank: false
            }
        ]
    });
    Eletters.window.CreateGroup.superclass.constructor.call(this,config);
};
Ext.extend(Eletters.window.CreateGroup,MODx.Window);
Ext.reg('eletters-window-group-create',Eletters.window.CreateGroup);

Eletters.window.UpdateGroup = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('eletters.groups.edit')
        ,url: Eletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/groups/update'
        }
        ,fields: [
            {
                xtype: 'hidden'
                ,name: 'id'
            },{
                xtype: 'textfield'
                ,fieldLabel: _('eletters.groups.name')
                ,name: 'name'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'combo-boolean'
                ,renderer: 'boolean'
                ,fieldLabel: _('eletters.groups.active')
                ,name: 'active'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textarea'
                ,fieldLabel: _('eletters.groups.description')
                ,name: 'description'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('eletters.groups.department')
                ,name: 'department'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'combo-boolean'
                ,renderer: 'boolean'
                ,fieldLabel: _('eletters.groups.allow_signup')
                ,name: 'allow_signup'
                ,width: 300
                ,allowBlank: false
            }/*{
                xtype: 'checkbox'
                ,fieldLabel: _('eletters.groups.public')
                ,name: 'public'
                ,width: 300
                ,inputValue: 1
            }*/
        ]
    });
    Eletters.window.UpdateGroup.superclass.constructor.call(this,config);
};
Ext.extend(Eletters.window.UpdateGroup,MODx.Window);
Ext.reg('eletters-window-group-update',Eletters.window.UpdateGroup);