var topDis = 0;
jQuery(document).ready(function($) 
{
	var page = new Object();
	for(var i=0; i<config.link.length; i++)
		page[config["link"][i]] = {tab:"prestige-menu-element-" + config["post_id"][i], color: config["color"][i], main:1}
			   
	$('#prestige').prestige(page);
	
	if(config.twitter_login!="" && config.twitts_number>0)
		$('#latest-tweets ul').bxSlider(
		{
			auto:true,
			pause:5000,
			nextText:null,
			prevText:null,
			mode:'vertical',
			displaySlideQty:1
		});  
	if(config.animation=="swipe")
	{
		var hrefSplit = window.location.href.replace("?", "").replace(new RegExp(config.home_url, 'g'), "").split("/");
		hrefSplit = $.grep(hrefSplit,function(n){
			return(n);
		});
		$(".carousel").carouFredSel({
			//direction: "up",
			//height: 500,
			items: {
				start: "#prestige-window-content-" + hrefSplit[0]
			},
			prev: {
				fx: config.animation_effect,
				easing: config.animation_transition,
				duration: parseInt(config.duration)
			},
			next: {
				fx: config.animation_effect,
				easing: config.animation_transition,
				duration: parseInt(config.duration)
			},
			auto: {
				play: false,
				fx: config.animation_effect,
				easing: config.animation_transition,
				duration: parseInt(config.duration)
			},
			swipe: {
				onTouch: (config.on_touch==1 ? true : false),
				onMouse: (config.on_mouse==1 ? true : false),
				options: {
					allowPageScroll: "none",
					threshold: parseInt(config.threshold)
				},
				onBefore: function(data){
					$("#prestige-navigation-" + data.scroll.direction).click();
					return false;
				},
				fx: config.animation_effect,
				easing: config.animation_transition,
				duration: parseInt(config.duration)
			}
		});
		$(".carousel .prestige-window-background").jScrollPane({maintainPosition:false,autoReinitialise:false,showArrows:true}).data('jsp');
		//slider
		$('.slider').nivoSlider({directionNav:false});
		
		//social icons tooltip
		$('ul.social-links li .social_icon[title]').qtip(
		{
				content:    { text:false },
				style:      { classes:'ui-tooltip-prestige' },
				position: 	{'my':'top center','at':'bottom center'}
		});
		
		$('.fancybox-image a').attr("rel", "gallery");
		$('.fancybox-image a').fancybox({
			'titleShow': false
		});
		
		$('.fancybox-video a').bind('click',function() 
		{
			$.fancybox(
			{
				//'padding':0,
				'autoScale':false,
				'titleShow': false,
				'transitionIn':'none',
				'transitionOut':'none',
				'width':(this.href.indexOf("vimeo")!=-1 ? 600 : 680),
				'height':(this.href.indexOf("vimeo")!=-1 ? 338 : 495),
				'href':(this.href.indexOf("vimeo")!=-1 ? this.href.replace(new RegExp("([0-9])","i"),'moogaloop.swf?clip_id=$1') : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/')),
				'type':'swf',
				'swf':
				{
					'wmode':'transparent',
					'allowfullscreen':'true'
				}
			});
			return false;
		});
		
		$('.fancybox-iframe a').fancybox({
			'width' : '75%',
			'height' : '75%',
			'autoScale' : false,
			'titleShow': false,
			'type' : 'iframe'
		});
	}
	$(".prestige-scroll-menu .prestige-menu-goup, .prestige-scroll-menu .prestige-menu-godown").click(function(event){
		event.preventDefault();
		$("#prestige-menu").css("height", "auto");
		var newTop = topDis;
		if($(this).hasClass("prestige-menu-goup"))
		{
			newTop = topDis+500;
			if(newTop>0)
				newTop = 0; 
		}
		else
		{	
			newTop = topDis-500;
			if(newTop<-($("#prestige-menu").height()-500))
				newTop = -($("#prestige-menu").height()-500);
		}
		if(newTop!=topDis)
		{
			topDis = newTop;
			$(".prestige-scroll-menu .prestige-menu-goup, .prestige-scroll-menu .prestige-menu-godown").removeClass("prestige-hidden");
			if(topDis==0)
				$(".prestige-scroll-menu .prestige-menu-goup").addClass("prestige-hidden");
			if(topDis==-($("#prestige-menu").height()-500))
				$(".prestige-scroll-menu .prestige-menu-godown").addClass("prestige-hidden");
			$("#prestige-menu").animate({
				top: topDis + "px"
			}, (config.animation=="swipe" ? parseInt(config.duration) : 1000), (config.animation=="swipe" ? config.animation_transition : "easeInOutCirc"));
		}
	});
	
	$(window).load(function() {
$('#loader').fadeOut(2000);
});
});

