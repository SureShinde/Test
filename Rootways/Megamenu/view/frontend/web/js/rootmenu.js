function rootFunction() {
	document.getElementById("megamenu_contact_form").reset();
}
require(['jquery','Rootways_Megamenu/js/masonry.pkgd.min'],function($,Masonry){
    
    jQuery(document).ready(function(){
        if ( ('ontouchstart' in window) ) {
		
            $('.rootmenu-list li a').click(function(e) {

                if( ($(this).closest("li").children(".halfmenu").length) || 
                    ($(this).closest("li").children(".megamenu").length) || 
                    ($(this).closest("li").children("ul").length) || 
                    ($(this).closest("li").children(".verticalopen").length) ||
                    ($(this).closest("li").children(".verticalopen02").length)
                  )
                {
                    var clicks = $(this).data('clicks');
                    if (clicks) {
                        //alert('odd number of clicks');
                    } else {
                        e.preventDefault();
                        //alert('even number of clicks');
                    }
                    $(this).data("clicks", !clicks);
                }
            });
        }
        
        jQuery('.rootmenu-list li').has('.rootmenu-submenu, .rootmenu-submenu-sub, .rootmenu-submenu-sub-sub').prepend('<span class="rootmenu-click"><i class="rootmenu-arrow"></i></span>');
        jQuery('.rootmenu-list li').has('.megamenu').prepend('<span class="rootmenu-click"><i class="rootmenu-arrow"></i></span>');
        jQuery('.rootmenu-list li').has('.halfmenu').prepend('<span class="rootmenu-click"><i class="rootmenu-arrow"></i></span>');
       
        jQuery('.rootmenu-click').click(function(){
            jQuery(this).siblings('.rootmenu-submenu').slideToggle('slow');
            jQuery(this).children('.rootmenu-arrow').toggleClass('rootmenu-rotate');
            jQuery(this).siblings('.rootmenu-submenu-sub').slideToggle('slow');
            jQuery(this).siblings('.rootmenu-submenu-sub-sub').slideToggle('slow');
            jQuery(this).siblings('.megamenu').slideToggle('slow');		
            jQuery(this).siblings('.halfmenu').slideToggle('slow');
            loadMasonry();
        });
		jQuery('.level2-popup .rootmenu-click').click(function(){
			jQuery(this).closest('li').find('.level3-popup').slideToggle('slow');
		});
		jQuery('.level3-popup .rootmenu-click').click(function(){
			jQuery(this).closest('li').find('.level4-popup').slideToggle('slow');
		});
     
        jQuery( ".nav-toggle" ).click(function() {
            if (jQuery("html").hasClass("nav-open")) { 
                jQuery( "html" ).removeClass('nav-before-open nav-open');
            } else {
                jQuery( "html" ).addClass('nav-before-open nav-open');  
            } 
        });
		
		setmenuheight();
        setmenuheight_horizontal();
		jQuery(window).bind("load resize", function() {
			var w_height = jQuery( window ).width();
			if(w_height <= 900){
				jQuery(".tabmenu").css('height','100%');
                jQuery(".tabmenu02").css('height','100%');
				jQuery(".verticalopen").css('height','100%');
			} else {
				setmenuheight();
			}
		});
		
		jQuery( ".rootmenu-list > li" ).hover(
			function() {
				jQuery( this ).addClass( "hover" );
				setmenuheight();
			}, function() {
				jQuery( this ).removeClass( "hover" );
			}
		);
        
        jQuery( ".vertical-menu02 > li > a" ).hover(
            function() {
                setmenuheight_horizontal();
            }, function() {

            }
        );
        var event = ('ontouchstart' in window) ? 'click' : 'mouseenter mouseleave';
        jQuery('.vertical-menu02 > li').on(event, function () {
            jQuery('.vertical-menu02 > li').removeClass('main_openactive02');
            jQuery(this).addClass('main_openactive02');
        });
     
        jQuery("#megamenu_submit").click(function(){
            var name = jQuery("#name").val();
            var menuemail = document.getElementById('menuemail');
                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!filter.test(menuemail.value)) {
                alert('Please provide a valid email address');
                menuemail.focus;
                return false;
            }
             
            var menuemail = jQuery("#menuemail").val();
            var comment = jQuery("#comment").val();
            var telephone = jQuery("#telephone").val();
            var hideit = jQuery("#hideit").val();
            var base_url = jQuery("#base_url").val();
            
            var dataString = 'name='+ name + '&email='+ menuemail + '&comment='+ comment + '&telephone='+ telephone + '&hideit='+ hideit;
            if(name==''||menuemail==''||comment==''){
                alert("Please Fill All Fields");
            } else {
                jQuery('#megamenu_submit').attr('id','menu_submit_loader');
                jQuery.ajax({
                    type: "POST",
                    url: base_url+"contact/index/post/",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        alert('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.');
                        jQuery('#menu_submit_loader').attr('id','megamenu_submit');
                    }
                });
            }
            return false;
        });
        /*
        jQuery( ".categoriesmenu li > a" ).hover(
			function() {
                var content_img = jQuery(this).attr('data-src');
                jQuery('.categoriesmenu .rootmegamenu_block img').attr('src',content_img);
			}, function() {
				//jQuery( this ).removeClass( "hover" );
			}
		);
        */
        jQuery( ".categoriesmenu li > a" ).hover(
			function() {
                var c_block = jQuery(this).closest('li').find('.categoryblockcontent').html();
                var m_c_block = jQuery(this).closest('.megamenu').find('.main_categoryblockcontent').html();
                if (c_block){
                    jQuery(this).closest('.megamenu').find('.rootmegamenu_block').html(c_block);   
                } else {
                    jQuery(this).closest('.megamenu').find('.rootmegamenu_block').html(m_c_block);
                }
                
			}, function() {
				//jQuery( this ).removeClass( "hover" );
			}
		);
        
        
        
        
        
        
        /*
        var wrapper_width =  jQuery(".nav-sections .page-main").innerWidth();
        var left_side_width =  jQuery(".verticalmenu02").innerWidth();
        var left_side_height =  jQuery(".verticalmenu02").innerHeight();
        if(jQuery( window ).width() < 901){
            jQuery(".varticalmenu_main.fullwidth").css('margin-left',0);
            jQuery(".varticalmenu_main.fullwidth").css('width','100%');
            //jQuery(".varticalmenu_main.fullwidth").css('min-height',left_side_height);

            jQuery(".varticalmenu_main.halfwidth").css('margin-left',0);
            jQuery(".varticalmenu_main.halfwidth").css('width','100%');
            //jQuery(".varticalmenu_main.halfwidth").css('min-height',left_side_height);
        }
        else{
            jQuery(".varticalmenu_main.fullwidth").css('margin-left',left_side_width);
            jQuery(".varticalmenu_main.fullwidth").css('width',wrapper_width-left_side_width);
            //jQuery(".varticalmenu_main.fullwidth").css('min-height',left_side_height);

            jQuery(".varticalmenu_main.halfwidth").css('margin-left',left_side_width);
            jQuery(".varticalmenu_main.halfwidth").css('width',wrapper_width/2);
            //jQuery(".varticalmenu_main.halfwidth").css('min-height',left_side_height);    
        }

        jQuery( window ).resize(function() {

            var wrapper_width =  jQuery(".main-container .main").innerWidth();
            var left_side_width =  jQuery(".verticalmenu02").innerWidth();
            var left_side_height =  jQuery(".verticalmenu02").innerHeight();

            if(jQuery( window ).width() < 901){
                jQuery(".varticalmenu_main.fullwidth").css('margin-left',0);
                jQuery(".varticalmenu_main.fullwidth").css('width','100%');
                //jQuery(".varticalmenu_main.fullwidth").css('min-height',left_side_height);

                jQuery(".varticalmenu_main.halfwidth").css('margin-left',0);
                jQuery(".varticalmenu_main.halfwidth").css('width','100%');
                //jQuery(".varticalmenu_main.halfwidth").css('min-height',left_side_height);
            }
            else{
                jQuery(".varticalmenu_main.fullwidth").css('margin-left',left_side_width);
                jQuery(".varticalmenu_main.fullwidth").css('width',wrapper_width-left_side_width);
                //jQuery(".varticalmenu_main.fullwidth").css('min-height',left_side_height);

                jQuery(".varticalmenu_main.halfwidth").css('margin-left',left_side_width);
                jQuery(".varticalmenu_main.halfwidth").css('width',wrapper_width/2);
                //jQuery(".varticalmenu_main.halfwidth").css('min-height',left_side_height);    
            }

        });
        
        */
        
        
        
        
        
        
    });
    
    function loadMasonry() {
        //jQuery('.grid div').load(document.URL +  ' .grid div');
        var elem = document.getElementsByClassName('grid');
        var msnry;
        var n = elem.length;
        for(var i = 0; i < n; i++){
            msnry = new Masonry( elem[i], {
                
            });
        }
    }
    loadMasonry();
});

function setmenuheight() {
    var w_inner_width = window.innerWidth;
    if(w_inner_width <= 900){
        jQuery(".tabmenu").css('height','100%');
        jQuery(".tabmenu02").css('height','100%');
        jQuery(".verticalopen").css('height','100%');
    } else {
        var tabMaxHeight = jQuery(".hover .tabmenu .vertical-menu").innerHeight() + 10;
        jQuery(".hover .tabmenu .vertical-menu > li").each(function() {
            var h = jQuery(this).find(".verticalopen").innerHeight();
            tabMaxHeight = h > tabMaxHeight ? h : tabMaxHeight;
            jQuery(this).find(".verticalopen").css('height',tabMaxHeight);
        });
        jQuery(".hover .tabmenu").css('height',tabMaxHeight+10);
    }
}

function setmenuheight_horizontal() {
	var w_inner_width = window.innerWidth;
	if(w_inner_width <= 900){
		jQuery(".tabmenu02").css('height','100%');
		jQuery(".verticalopen02").css('height','100%');
	} else {
		var final_hor_width = jQuery('.main_openactive02 .verticalopen02').innerHeight();
		//console.log('hegith--'+final_hor_width);
		jQuery(".main_openactive02 .verticalopen02").css('height',final_hor_width);
		jQuery(".hover .tabmenu02").css('height',final_hor_width+80);
	}
}

