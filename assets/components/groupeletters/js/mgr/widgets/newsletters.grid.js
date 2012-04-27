GroupEletters.grid.Newsletters = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'groupeletters-grid-newsletters'
        ,url: GroupEletters.config.connectorUrl
        ,baseParams: { action: 'mgr/newsletters/list' }
        ,fields: ['id','title','date','total','sent']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'title'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 10
        },{
            header: _('groupeletters.newsletters.subject')
            ,dataIndex: 'title'
            ,sortable: true
        },{
            header: _('date')
            ,dataIndex: 'date'
            ,sortable: true
        },{
            header: _('groupeletters.newsletters.total')
            ,dataIndex: 'total'
            ,sortable: true
        },{
            header: _('groupeletters.newsletters.sent')
            ,dataIndex: 'sent'
            ,sortable: false
        }]/*
        ,tbar: [{
            text: _('groupeletters.newsletters.new')
            ,handler: this.createNewsletter
        }]*/
    });
    GroupEletters.grid.Newsletters.superclass.constructor.call(this,config)
};
Ext.extend(GroupEletters.grid.Newsletters,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
            text: _('groupeletters.newsletters.remove')
            ,handler: this.removeNewsletter
        }];
        this.addContextMenuItem(m);
        return true;
    }
    ,createNewsletter: function(btn,e) {
        if (!this.CreateNewsletterWindow) {
            this.CreateNewsletterWindow = MODx.load({
                xtype: 'groupeletters-window-newsletter-create'
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.getGroups('groupeletters-window-newsletter-create');
        this.CreateNewsletterWindow.show(e.target);
    }
    ,removeNewsletter: function() {
        MODx.msg.confirm({
            title: _('groupeletters.newsletters.remove')
            ,text: _('groupeletters.newsletters.remove.confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/newsletters/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    ,getGroups: function(formId) {
        MODx.Ajax.request({
            url: GroupEletters.config.connectorUrl,
            scope: this,
            params: {
                action: 'mgr/groups/getgrouplist'
                ,memberCount: 1
            },
            listeners: {
                success: {fn:function(response) {
                        groups = response.object;
                        Ext.getCmp('newslettergroups').removeAll();

                        if(groups.length > 0) {
                            Ext.each(groups, function(item, key) {
                                if(item.members > 0) {
                                        Ext.getCmp('newslettergroups').add({
                                            xtype: 'checkbox',
                                            name: 'groups_'+item.id,
                                            boxLabel: item.name+' ('+item.members+' '+_('groupeletters.groups.members')+')',
                                            inputValue: true,
                                            hideLabel: true,
                                            checked: item.checked
                                        });
                                }
                            }, this);
                        }
                        Ext.getCmp(formId).doLayout(false, true);
                    }
                }
            }
        });
    }
});
Ext.reg('groupeletters-grid-newsletters',GroupEletters.grid.Newsletters);

GroupEletters.window.CreateNewsletter = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('groupeletters.newsletters.new')
        ,url: GroupEletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/newsletters/create'
        }
        ,fields: [
            {
                xtype: 'textfield'
                ,fieldLabel: _('groupeletters.newsletters.subject')
                ,name: 'title'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'numberfield'
                ,fieldLabel: _('groupeletters.newsletters.document')
                ,name: 'document'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'fieldset'
                ,id: 'newslettergroups'
                ,fieldLabel: _('groupeletters.newsletters.groups')
                ,items: []
            }
        ]
    });
    GroupEletters.window.CreateNewsletter.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters.window.CreateNewsletter,MODx.Window);
Ext.reg('groupeletters-window-newsletter-create',GroupEletters.window.CreateNewsletter);