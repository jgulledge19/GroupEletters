var Eletters = function(config) {
    config = config || {};
    Eletters.superclass.constructor.call(this,config);
};
Ext.extend(Eletters,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},form: {}
});
Ext.reg('eletters',Eletters);

Eletters = new Eletters();