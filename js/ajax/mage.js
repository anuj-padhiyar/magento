var Base = function(){};

Base.prototype = {
    method : 'post',
    url : null,
    params : {},

    alert : function(){
        alert(1234);
    },
    setMethod : function(method){
        this.method = method;
        return this;
    },
    getMethod : function(){
        return this.method;
    },
    setUrl : function(url){
        this.url=url;
        return this;
    },
    getUrl : function(){
        return this.url;
    },
    setParams : function(params){
        this.params=params;
        return params;
    },
    getParams : function(){
        return this.params;
    },
    resetParams : function(){
        this.params = {};
        return this;
    },
    addParam : function(key, value){
        this.params[key] = value;
        return this;
    },
    removeParam : function(key){
        if(typeof this.params[key] != undefined){
            delete this.params[key];
        }
        return this;
    },
    load : function(){
        var self = this;
        var request = jQuery.ajax({
            url:this.getUrl(),
            method:this.getMethod(),
            data:this.getParams(),
            success:function(response){
                self.manageHtml(response);
            }
        });
    },
    manageHtml:function(response){
        if(typeof response.element == 'undefined'){
            return false;
        }
        if(typeof response.element == 'object'){
            jQuery(response.element).each(function(i,element){
                jQuery(element.selector).html(element.html);
            })
        }else{
            jQuery(response.element.selector).html(response.element.html);
        }
    },
    setForm:function(id){
        this.setParams(jQuery('#'+id).serializeArray());
        this.setMethod(jQuery('#'+id).attr('method'));
        this.setUrl(jQuery('#'+id).attr('action'));
        this.load();
    },
    changeAction:function(formId,value){    
        jQuery('#'+formId).attr('action',value);
        return this;
    },
    setImage:function(){
        var self = this;
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('image',files);
        
        var id = $('#form').attr('id');
        $.ajax({
            url:$(id).attr('action'),
            type:$(id).attr('method'),
            data: formData,
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
                self.manageHtml(data);
            }
        });
    },
    showCartItems:function(){
        var id = $('#customers').val();
        $('#form').attr('action',id);
        return this;
    }
}

var mage = new Base();
// mage.setUrl('http://localhost/phpCode/Session3_Php/MVC/index.php?c=category&a=grid');
// mage.load();