Eletters.grid.Newsletters = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'eletters-grid-newsletters'
        ,url: Eletters.config.connectorUrl
        ,baseParams: { action: 'mgr/newsletters/list' }
        ,fields: ['id','title','date','delivered','sent', 'bounced', 'opened', 'clicks']
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
            header: _('eletters.newsletters.date')
            ,dataIndex: 'date'
            ,sortable: true
            ,width: 120
        },{
            header: _('eletters.newsletters.subject')
            ,dataIndex: 'title'
            ,sortable: true
            ,width: 140
        },{
            header: _('eletters.newsletters.sent')
            ,dataIndex: 'sent'
            ,sortable: false
        },{
            header: _('eletters.newsletters.delivered')
            ,dataIndex: 'delivered'
            ,sortable: true
        },{
            header: _('eletters.newsletters.bounced')
            ,dataIndex: 'bounced'
            ,sortable: false
        },{
            header: _('eletters.newsletters.opened')
            ,dataIndex: 'opened'
            ,sortable: false
        },{
            header: _('eletters.newsletters.clicks')
            ,dataIndex: 'clicks'
            ,sortable: false
        }]/*
        ,tbar: [{
            text: _('eletters.newsletters.new')
            ,handler: this.createNewsletter
        }]*/
    });
    Eletters.grid.Newsletters.superclass.constructor.call(this,config)
};
Ext.extend(Eletters.grid.Newsletters,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
            text: _('eletters.newsletters.remove')
            ,handler: this.removeNewsletter
        }];
        this.addContextMenuItem(m);
        return true;
    }
    ,createNewsletter: function(btn,e) {
        if (!this.CreateNewsletterWindow) {
            this.CreateNewsletterWindow = MODx.load({
                xtype: 'eletters-window-newsletter-create'
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.getGroups('eletters-window-newsletter-create');
        this.CreateNewsletterWindow.show(e.target);
    }
    ,removeNewsletter: function() {
        MODx.msg.confirm({
            title: _('eletters.newsletters.remove')
            ,text: _('eletters.newsletters.remove.confirm')
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
            url: Eletters.config.connectorUrl,
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
                                            boxLabel: item.name+' ('+item.members+' '+_('eletters.groups.members')+')',
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
Ext.reg('eletters-grid-newsletters',Eletters.grid.Newsletters);

Eletters.window.CreateNewsletter = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('eletters.newsletters.new')
        ,url: Eletters.config.connectorUrl
        ,baseParams: {
            action: 'mgr/newsletters/create'
        }
        ,fields: [
            {
                xtype: 'textfield'
                ,fieldLabel: _('eletters.newsletters.subject')
                ,name: 'title'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'numberfield'
                ,fieldLabel: _('eletters.newsletters.document')
                ,name: 'document'
                ,width: 300
                ,allowBlank: false
            },{
                xtype: 'fieldset'
                ,id: 'newslettergroups'
                ,fieldLabel: _('eletters.newsletters.groups')
                ,items: []
            }
        ]
    });
    Eletters.window.CreateNewsletter.superclass.constructor.call(this,config);
};
Ext.extend(Eletters.window.CreateNewsletter,MODx.Window);
Ext.reg('eletters-window-newsletter-create',Eletters.window.CreateNewsletter);