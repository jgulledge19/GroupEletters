var Ditsnews = function(config) {
    config = config || {};
    Ditsnews.superclass.constructor.call(this,config);
};
Ext.extend(Ditsnews,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},form: {}
});
Ext.reg('ditsnews',Ditsnews);

Ditsnews = new Ditsnews();