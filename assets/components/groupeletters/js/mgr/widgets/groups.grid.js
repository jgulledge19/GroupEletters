GroupEletters.grid.Groups = function(config) {
    config = config || {};

    var publicCheckColumn = new Ext.ux.grid.CheckColumn({
        header: _('groupeletters.groups.public')
        ,dataIndex: 'public'
        ,width: 10
        ,sortable: false
    });

    Ext.applyIf(config,{
        id: 'groupeletters-grid-groups'
        ,url: GroupEletters.config.connectorUrl
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
            header: _('groupeletters.groups.name')
            ,dataIndex: 'name'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('groupeletters.groups.members')
            ,dataIndex: 'members'
            ,sortable: false
            ,width: 30
        },{
            header: _('groupeletters.groups.active')
            ,dataIndex: 'active'
            ,sortable: true
            //,editor: { xtype: 'textfield' }
            //,width: 50
            ,allowBlank : false
            ,editor: { xtype: 'combo-boolean' ,renderer: 'boolean' /*'boolean'*/ }
        },{
            header: _('groupeletters.groups.description')
            ,dataIndex: 'description'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('groupeletters.groups.department')
            ,dataIndex: 'department'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('groupeletters.groups.allow_signup')
            ,dataIndex: 'allow_signup'
            ,sortable: true
            //,editor: { xtype: 'textfield' }
            //,width: 50
            ,allowBlank : false
            ,editor: { xtype: 'combo-boolean' ,renderer: 'boolean' /*'boolean'*/ }
        }]
        ,tbar: [{
            text: _('groupeletters.groups.new')
            ,handler: { xtype: 'groupeletters-window-group-create', blankValues: true }
        }]
    });
    GroupEletters.grid.Groups.superclass.constructor.call(this,config)
};
Ext.extend(GroupEletters.grid.Groups,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
                text: _('groupeletters.groups.remove')
                ,handler: this.removeGroup
            },
            {
                text: _('groupeletters.groups.update')
                ,handler: this.updateGroup
            }
        ];
        this.addContextMenuItem(m);
        return true;
    }
    ,removeGroup: function() {
        MODx.msg.confirm({
            title: _('groupeletters.groups.remove')
            ,text: _('groupeletters.groups.remove.confirm')
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
                xtype: 'groupeletters-window-group-update'
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
Ext.reg('groupeletters-grid-groups',GroupEletters.grid.Groups);

GroupEletters.window.CreateGroup = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('groupeletters.groups.new')
        ,url: GroupEletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/groups/create'
        }
        ,fields: [
            {
                xtype: 'textfield'
                ,fieldLabel: _('groupeletters.groups.name')
                ,name: 'name'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'combo-boolean'
                ,renderer: 'boolean'
                ,value: 1
                ,fieldLabel: _('groupeletters.groups.active')
                ,name: 'active'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textarea'
                ,fieldLabel: _('groupeletters.groups.description')
                ,name: 'description'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('groupeletters.groups.department')
                ,name: 'department'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'combo-boolean'
                ,renderer: 'boolean'
                //,value: 1
                ,fieldLabel: _('groupeletters.groups.allow_signup')
                ,name: 'allow_signup'
                ,width: 300
                ,allowBlank: false
            }
        ]
    });
    GroupEletters.window.CreateGroup.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.window.CreateGroup,MODx.Window);
Ext.reg('groupeletters-window-group-create',GroupEletters.window.CreateGroup);

GroupEletters.window.UpdateGroup = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('groupeletters.groups.edit')
        ,url: GroupEletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/groups/update'
        }
        ,fields: [
            {
                xtype: 'hidden'
                ,name: 'id'
            },{
                xtype: 'textfield'
                ,fieldLabel: _('groupeletters.groups.name')
                ,name: 'name'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'combo-boolean'
                ,renderer: 'boolean'
                ,fieldLabel: _('groupeletters.groups.active')
                ,name: 'active'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textarea'
                ,fieldLabel: _('groupeletters.groups.description')
                ,name: 'description'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'textfield'
                ,fieldLabel: _('groupeletters.groups.department')
                ,name: 'department'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'combo-boolean'
                ,renderer: 'boolean'
                ,fieldLabel: _('groupeletters.groups.allow_signup')
                ,name: 'allow_signup'
                ,width: 300
                ,allowBlank: false
            }/*{
                xtype: 'checkbox'
                ,fieldLabel: _('groupeletters.groups.public')
                ,name: 'public'
                ,width: 300
                ,inputValue: 1
            }*/
        ]
    });
    GroupEletters.window.UpdateGroup.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.window.UpdateGroup,MODx.Window);
Ext.reg('groupeletters-window-group-update',GroupEletters.window.UpdateGroup);