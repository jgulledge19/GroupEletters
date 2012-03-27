Ditsnews.grid.Groups = function(config) {
    config = config || {};

    var publicCheckColumn = new Ext.ux.grid.CheckColumn({
        header: _('ditsnews.groups.public')
        ,dataIndex: 'public'
        ,width: 10
        ,sortable: false
    });

    Ext.applyIf(config,{
        id: 'ditsnews-grid-groups'
        ,url: Ditsnews.config.connectorUrl
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
            header: _('ditsnews.groups.name')
            ,dataIndex: 'name'
            ,sortable: true
        },publicCheckColumn,{
            header: _('ditsnews.groups.members')
            ,dataIndex: 'members'
            ,sortable: true
            ,width: 10
        }]
        ,tbar: [{
            text: _('ditsnews.groups.new')
            ,handler: { xtype: 'ditsnews-window-group-create', blankValues: true }
        }]
    });
    Ditsnews.grid.Groups.superclass.constructor.call(this,config)
};
Ext.extend(Ditsnews.grid.Groups,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
                text: _('ditsnews.groups.remove')
                ,handler: this.removeGroup
            },
            {
                text: _('ditsnews.groups.update')
                ,handler: this.updateGroup
            }
        ];
        this.addContextMenuItem(m);
        return true;
    }
    ,removeGroup: function() {
        MODx.msg.confirm({
            title: _('ditsnews.groups.remove')
            ,text: _('ditsnews.groups.remove.confirm')
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
                xtype: 'ditsnews-window-group-update'
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
Ext.reg('ditsnews-grid-groups',Ditsnews.grid.Groups);

Ditsnews.window.CreateGroup = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('ditsnews.groups.new')
        ,url: Ditsnews.config.connectorUrl
        ,baseParams: {
            action: 'mgr/groups/create'
        }
        ,fields: [
            {
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.groups.name')
                ,name: 'name'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'checkbox'
                ,fieldLabel: _('ditsnews.groups.public')
                ,name: 'public'
                ,width: 300
                ,inputValue: 1
            }
        ]
    });
    Ditsnews.window.CreateGroup.superclass.constructor.call(this,config);
};
Ext.extend(Ditsnews.window.CreateGroup,MODx.Window);
Ext.reg('ditsnews-window-group-create',Ditsnews.window.CreateGroup);

Ditsnews.window.UpdateGroup = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('ditsnews.groups.edit')
        ,url: Ditsnews.config.connectorUrl
        ,baseParams: {
            action: 'mgr/groups/update'
        }
        ,fields: [
            {
                xtype: 'hidden'
                ,name: 'id'
            },{
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.groups.name')
                ,name: 'name'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'checkbox'
                ,fieldLabel: _('ditsnews.groups.public')
                ,name: 'public'
                ,width: 300
                ,inputValue: 1
            }
        ]
    });
    Ditsnews.window.UpdateGroup.superclass.constructor.call(this,config);
};
Ext.extend(Ditsnews.window.UpdateGroup,MODx.Window);
Ext.reg('ditsnews-window-group-update',Ditsnews.window.UpdateGroup);