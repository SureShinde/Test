categoryAttributeDependency = Class.create();

categoryAttributeDependency.prototype = {
 
    initialize: function (htmlId) {
        this.element = $(htmlId);
        this.dependentElements = $$("[id^="+htmlId+"]");
        this.refreshView();
        this.bindEvents();
    },
 
    bindEvents: function () {
        Event.observe(this.element, "change", this.refreshView.bind(this));
        Event.observe(this.element, "keyup", this.refreshView.bind(this));
        Event.observe(this.element, "keydown", this.refreshView.bind(this));
    },
     
    refreshView: function () {
        var that = this;
        var simple_img = '';
        var showheader = '';
        var showfooter = '';
        var verticalmenu_img = '';
        var verticalmenu_header = '';
        var verticalmenu_footer = '';
        this.dependentElements.each(function(el){
            if (that.element.id != el.id) {
                
                 if (that.element.value == '0') {
                    el.up(1).hide();
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_showimg]'){
                        el.up(1).show();
                    }
                }
                else if (that.element.value == '1111' || that.element.value == '2' || that.element.value == '4' || that.element.value == '5' || that.element.value == '6' || that.element.value == '7' || that.element.value == '3' || that.element.value == '8' || that.element.value == '9' || that.element.value == '10' || that.element.value == '11' || that.element.value == '12' || that.element.value == '13' || that.element.value == '14' || that.element.value == '15' || that.element.value == '16' || that.element.value == '17' || that.element.value == '18' || that.element.value == '19' || that.element.value == '20' || that.element.value == '1') {
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_showimg]'){
                        el.up(1).show();
                        if(el.value == 1){ simple_img = 'yes';} else {simple_img = 'no';}
                    }
                    
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_showimg_width]' && simple_img == 'yes'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_showimg_height]' && simple_img == 'yes'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'megamenu_type_showimg_img' && simple_img == 'yes'){
                        el.up(1).show();
                    }
                    
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_showheader]'){
                        el.up(1).show();
                        if(el.value == 1){ showheader = 'yes';} else { showheader = 'no';}
                    }
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_showheader_txt]' && showheader == 'yes'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_showfooter]'){
                        el.up(1).show();
                        if(el.value == 1){ showfooter = 'yes';}else { showfooter = 'no';}
                    }
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_showfooter_txt]' && showfooter == 'yes'){
                        el.up(1).show();
                    }
                    
                    if(that.element.name == 'general[megamenu_type]' && el.name == 'general[megamenu_type_customclass]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && (el.name == 'general[megamenu_type_proid]' || el.name == 'general[megamenu_type_secstaticblock]')){
                        el.up(1).hide();
                    }
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '1111' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '1111' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '1111' && el.name == 'general[megamenu_type_showheader]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '1111' && el.name == 'general[megamenu_type_showheader_txt]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '1111' && el.name == 'general[megamenu_type_showfooter]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '1111' && el.name == 'general[megamenu_type_showfooter_txt]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '1111' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).show();
                    }
                    
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '2' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '2' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '2' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '3' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '3' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '3' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '4' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '4' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '4' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '5' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '5' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '5' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '6' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '6' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '6' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '6' && el.name == 'general[megamenu_type_showheader]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '6' && el.name == 'general[megamenu_type_showheader_txt]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '6' && el.name == 'general[megamenu_type_showfooter]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '6' && el.name == 'general[megamenu_type_showfooter_txt]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_proid]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_showimg]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_showimg_width]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_showimg_height]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_showheader]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_showheader_txt]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_showfooter]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '7' && el.name == 'general[megamenu_type_showfooter_txt]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '8' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '8' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '8' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '9' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '9' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '9' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '10' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '10' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '10' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '11' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '11' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '11' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '12' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '12' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '12' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '13' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '13' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '13' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '14' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '14' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '14' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '15' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '15' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '15' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_proid]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_showimg]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_showimg_width]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_showimg_height]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'megamenu_type_showimg_img'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_showheader]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_showheader_txt]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_showfooter]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '16' && el.name == 'general[megamenu_type_showfooter_txt]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_proid]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_showimg]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_showimg_width]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_showimg_height]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'megamenu_type_showimg_img'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_showheader]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_showheader_txt]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_showfooter]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '17' && el.name == 'general[megamenu_type_showfooter_txt]'){
                        el.up(1).hide();
                    }
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '18' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '18' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '18' && el.name == 'general[megamenu_type_secstaticblock]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '18' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '19' && el.name == 'general[megamenu_type_proid]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '19' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '19' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '19' && el.name == 'general[megamenu_type_secstaticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '19' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
					
					if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_showheader]'){
                        el.up(1).hide();
                    }
					if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_showheader_txt]'){
                        el.up(1).hide();
                    }
					if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_showfooter]'){
                        el.up(1).hide();
                    }
					if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_showfooter_txt]'){
                        el.up(1).hide();
                    }
					if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_proid]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_secstaticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '20' && el.name == 'general[megamenu_type_simposition]'){
                        el.up(1).hide();
                    }
                    
                    
                    
                    
                    
                    
                    
                    
                    if(that.element.name == 'general[megamenu_type]' && that.element.value == '1'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type_showimg]' && that.element.value == '1'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type_img]' && that.element.value == '1'){
                        el.up(1).show();
                    }
                    
                    
                    if(that.element.name == 'general[megamenu_type_showheader]' && that.element.value == '1'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[megamenu_type_showfooter]' && that.element.value == '1'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type_header]' && that.element.value == '1'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type_footer]' && that.element.value == '1'){
                        el.up(1).show();
                    }
                    
                    if(that.element.name == 'general[verticalmenu]' && el.name == 'general[verticalmenu_type]' && that.element.value == '1'){
                        el.up(1).show();
                    }
                } 
                
                
                
                
                else if (that.element.value == '101' || that.element.value == '102' || that.element.value == '103' || that.element.value == '104' || that.element.value == '105' || that.element.value == '106' || that.element.value == '107' || that.element.value == '108' || that.element.value == '109' || that.element.value == '110' || that.element.value == '111' || that.element.value == '112' || that.element.value == '113' || that.element.value == '114' || that.element.value == '1') {
                
                    
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                        if(el.value == 1){ verticalmenu_img = 'yes';} else {verticalmenu_img = 'no';}
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_img_width]' && verticalmenu_img == 'yes'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_img_height]' && verticalmenu_img == 'yes'){
                        el.up(1).show();
                    }
                    
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                        if(el.value == 1){ verticalmenu_header = 'yes';}else {verticalmenu_header = 'no';}
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_header_txt]' && verticalmenu_header == 'yes'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                        if(el.value == 1){ verticalmenu_footer = 'yes';}else { verticalmenu_footer = 'no';}
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_footer_txt]' && verticalmenu_footer == 'yes'){
                        el.up(1).show();
                    }
                    
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_custclass]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && el.name == 'general[verticalmenu_type_pid]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '101' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '101' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '101' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '101' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '101' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();

                    }*/
                    
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '102' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '102' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '102' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '102' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '102' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '103' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '103' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '103' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '103' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '103' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '104' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '104' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '104' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '104' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '104' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '105' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '105' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '105' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '105' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '105' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '106' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '106' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '106' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }*/
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '106' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '106' && el.name == 'general[verticalmenu_type_header_txt]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '106' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '106' && el.name == 'general[verticalmenu_type_footer_txt]'){
                        el.up(1).hide();
                    }
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_pid]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_custclass]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_img_width]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_img_height]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_header_txt]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).hide();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '107' && el.name == 'general[verticalmenu_type_footer_txt]'){
                        el.up(1).hide();
                    }
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '108' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '108' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '108' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '108' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '108' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '109' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '109' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '109' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '109' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '109' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '110' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '110' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '110' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '110' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '110' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '111' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '111' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '111' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '111' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '111' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '112' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '112' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).hide();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '112' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '112' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '112' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '113' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '113' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '113' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '113' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '113' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                    
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '114' && el.name == 'general[verticalmenu_type_numofcolumns]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '114' && el.name == 'general[verticalmenu_type_staticblock]'){
                        el.up(1).show();
                    }
                    /*if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '114' && el.name == 'general[verticalmenu_type_img]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '114' && el.name == 'general[verticalmenu_type_header]'){
                        el.up(1).show();
                    }
                    if(that.element.name == 'general[verticalmenu_type]' && that.element.value == '114' && el.name == 'general[verticalmenu_type_footer]'){
                        el.up(1).show();
                    }*/
                    
                }
                else {
                    el.up(1).hide();
                }
            }
        });
    }
};