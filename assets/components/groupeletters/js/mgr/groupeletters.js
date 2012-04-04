var GroupEletters = function(config) {
    config = config || {};
    GroupEletters.superclass.constructor.call(this,config);
};
Ext.extend(GroupEletters,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},form: {}
});
Ext.reg('groupeletters',GroupEletters);

GroupEletters = new GroupEletters();