Ditsnews.grid.Newsletters = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'ditsnews-grid-newsletters'
        ,url: Ditsnews.config.connectorUrl
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
            header: _('ditsnews.newsletters.subject')
            ,dataIndex: 'title'
            ,sortable: true
        },{
            header: _('date')
            ,dataIndex: 'date'
            ,sortable: true
        },{
            header: _('ditsnews.newsletters.total')
            ,dataIndex: 'total'
            ,sortable: true
        },{
            header: _('ditsnews.newsletters.sent')
            ,dataIndex: 'sent'
            ,sortable: false
        }]
        ,tbar: [{
            text: _('ditsnews.newsletters.new')
            ,handler: this.createNewsletter
        }]
    });
    Ditsnews.grid.Newsletters.superclass.constructor.call(this,config)
};
Ext.extend(Ditsnews.grid.Newsletters,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
            text: _('ditsnews.newsletters.remove')
            ,handler: this.removeNewsletter
        }];
        this.addContextMenuItem(m);
        return true;
    }
    ,createNewsletter: function(btn,e) {
        if (!this.CreateNewsletterWindow) {
            this.CreateNewsletterWindow = MODx.load({
                xtype: 'ditsnews-window-newsletter-create'
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.getGroups('ditsnews-window-newsletter-create');
        this.CreateNewsletterWindow.show(e.target);
    }
    ,removeNewsletter: function() {
        MODx.msg.confirm({
            title: _('ditsnews.newsletters.remove')
            ,text: _('ditsnews.newsletters.remove.confirm')
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
            url: Ditsnews.config.connectorUrl,
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
                                            boxLabel: item.name+' ('+item.members+' '+_('ditsnews.groups.members')+')',
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
Ext.reg('ditsnews-grid-newsletters',Ditsnews.grid.Newsletters);

Ditsnews.window.CreateNewsletter = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('ditsnews.newsletters.new')
        ,url: Ditsnews.config.connectorUrl
        ,baseParams: {
            action: 'mgr/newsletters/create'
        }
        ,fields: [
            {
                xtype: 'textfield'
                ,fieldLabel: _('ditsnews.newsletters.subject')
                ,name: 'title'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'numberfield'
                ,fieldLabel: _('ditsnews.newsletters.document')
                ,name: 'document'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'fieldset'
                ,id: 'newslettergroups'
                ,fieldLabel: _('ditsnews.newsletters.groups')
                ,items: []
            }
        ]
    });
    Ditsnews.window.CreateNewsletter.superclass.constructor.call(this,config);
};
Ext.extend(Ditsnews.window.CreateNewsletter,MODx.Window);
Ext.reg('ditsnews-window-newsletter-create',Ditsnews.window.CreateNewsletter);