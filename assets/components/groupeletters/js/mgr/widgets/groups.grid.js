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
        ,fields: ['id','name','public','members']
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
        },publicCheckColumn,{
            header: _('groupeletters.groups.members')
            ,dataIndex: 'members'
            ,sortable: true
            ,width: 10
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
                xtype: 'checkbox'
                ,fieldLabel: _('groupeletters.groups.public')
                ,name: 'public'
                ,width: 300
                ,inputValue: 1
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
                xtype: 'checkbox'
                ,fieldLabel: _('groupeletters.groups.public')
                ,name: 'public'
                ,width: 300
                ,inputValue: 1
            }
        ]
    });
    GroupEletters.window.UpdateGroup.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.window.UpdateGroup,MODx.Window);
Ext.reg('groupeletters-window-group-update',GroupEletters.window.UpdateGroup);