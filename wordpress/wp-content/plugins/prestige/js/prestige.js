
(function($)
{	
    /**********************************************************************/

    var Prestige=function(prestige,page)
    {
        /******************************************************************/

        var $this=this;

        this.prestige=$(prestige);

        this.prestigeWindow=$('#prestige-window');
        this.prestigeWindowContent=$('#prestige-window-content');

        this.prestigeMenu=$('#prestige-menu');
        this.prestigeMenuElement=$this.prestigeMenu.find('li');

        this.prestigeNavigationNext=$('#prestige-navigation-next');
        this.prestigeNavigationPrev=$('#prestige-navigation-prev');

        this.page=page;

        this.currentHash='';
        this.previousHash='';

        this.currentPage=-1;
        this.previousPage=-1;

        this.scrollbar='';

        this.enable=true;

        this.maxWidth=parseInt(this.prestige.css('width'));
        this.minWidth=parseInt(this.prestigeWindow.css('width'));

        /******************************************************************/
        /******************************************************************/

        this.load=function()
        {
            $this.handleHash();
        };

        /******************************************************************/
		
		this.pushState=function(event)
		{
			event.preventDefault();
			var History = window.History;
			var url = $(this).attr("href");
			if(typeof(url)!="undefined")
			{
				var hashSplit = url.split("#");
				var data = null;
				if(hashSplit.length==2)
				{
					data = {hash: hashSplit[1]}
					url = url.replace("#" + hashSplit[1], "");
				}
				var title = config.blog_name + " | " + url.replace("#!/", "").replace(new RegExp(config.home_url + "/", 'g'), "").replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); });
				if(history.pushState)
					History.pushState(data, (title.substr(-1)=="/" ? title.substr(0, title.length-1) : title), config.home_url + "/" + url.replace("#!/", "").replace(new RegExp(config.home_url + "/", 'g'), ""));
				else
					History.pushState(data, (title.substr(-1)=="/" ? title.substr(0, title.length-1) : title), config.home_url + "/?" + (url.substr(0,1)=="?" ? url.substr(1) : url));
			}
		};
		
		/******************************************************************/
			
        this.handleHash=function()
        {
			var History = window.History;
			var currentUrl = (window.location.href.substr(-1)=="/" ? window.location.href : window.location.href + "/");
			if(currentUrl==config.home_url + "/")
			{
				var data = null;
				if(history.pushState)
					History.pushState(data, config.blog_name + " | " + config.blog_desc, config.home_url + "/" + $this.getDefaultPage() + "/");
				else
					History.pushState(data, config.blog_name + " | " + config.blog_desc, config.home_url + "/?" + $this.getDefaultPage() + "/");
			}
			
			$this.currentHash=window.location.hash;
			/*$(document).bind("swipeleft", function(){
				$("#prestige-navigation-next").click();
			});
			$(document).bind("swiperight", function(){
				$("#prestige-navigation-prev").click();
			});*/
			$(".link, #prestige-menu a:not('.custom_url'), #prestige-navigation-prev, #prestige-navigation-next, .menu-item a").click($this.pushState);
			History.Adapter.bind(window,'statechange',function(){
				var state = History.getState();
				var hrefSplit = state.url.replace("?", "").replace(new RegExp(config.home_url, 'g'), "").split("/");
				hrefSplit = $.grep(hrefSplit,function(n){
					return(n);
				});
				$this.currentHash = "#!/";
				for(i in hrefSplit)
					$this.currentHash += hrefSplit[i] + ((parseInt(i)+1)<hrefSplit.length ? "/" : "");
				if($this.currentHash!="#!/")
				{
					if(typeof(state.data.hash)!="undefined")
						$this.currentHash += "#" + state.data.hash;
					$this.doHash();
					$this.previousHash=$this.currentHash;
				}
			});
			setTimeout(function(){History.Adapter.trigger(window,'statechange');},1);
        };

        /******************************************************************/
                        
        this.doHash=function()
        {
			//if(!$this.isEnable()) return(false);
            //$this.enable=false;   

            var isOpen=$this.isOpen();
            var currentPage=$this.checkHash();

            if(currentPage==false) 
            {
                //$this.enable=true;
                return(false);
            };

            $this.currentPage=currentPage;
            if($this.previousPage==-1) 
                $this.previousPage=$this.currentPage;

            if(isOpen) $this.close({onComplete:function() { $this.open(); }});
            else $this.open();

            return(true);
        };

        /******************************************************************/

        this.checkHash=function()
        {
			var splittedHash = $this.currentHash.split("/");
			var splittedHashScroll = $this.currentHash.split("#");
			if($this.previousHash!='')
				var splittedHashPrevious = $this.previousHash.split("#");
			if(($this.previousHash=='' && splittedHashScroll.length==3 && $this.isOpen()) || ($this.previousHash!='' && splittedHashScroll.length==3 && splittedHashPrevious[0]+splittedHashPrevious[1]==splittedHashScroll[0]+splittedHashScroll[1]))
			{
				if($("#" + splittedHashScroll[2]).length)
				{
					$this.destroyScrollbar();
					if(config.animation=="swipe")
						$this.scrollbar = $("#prestige-window-content-" + (splittedHash[1].indexOf("#")!=-1 ? splittedHash[1].substr(0, splittedHash[1].indexOf("#")) : splittedHash[1])).jScrollPane({maintainPosition:false,autoReinitialise:false,showArrows:true}).data('jsp');
					else
						$this.scrollbar = $('#prestige-window-scroll').jScrollPane({maintainPosition:true,autoReinitialise:false}).data('jsp');
					$this.scrollbar.scrollToElement($("#" + splittedHashScroll[2]), true);
				}
			}
			else
			{
				//inside tab pagination
				if(typeof(splittedHash[2])!="undefined" && splittedHash[2].substr(0,4)=="page")
				{
					if($this.isOpen())
						return $this.getPageContent({
							name: (splittedHash[1].indexOf("#")!=-1 ? splittedHash[1].substr(0, splittedHash[1].indexOf("#")) : splittedHash[1]),
							paged: parseInt(splittedHash[2].split("-")[1])
						}, false);
				}
				//blog category
				else if(typeof(splittedHash[2])!="undefined" && splittedHash[2].substr(0,8)=="category")
				{
					if($this.isOpen())
					{
						var	data = {
							name: (splittedHash[1].indexOf("#")!=-1 ? splittedHash[1].substr(0, splittedHash[1].indexOf("#")) : splittedHash[1]),
							category_id: parseInt(splittedHash[2].split("-")[1])
						};
						if(typeof(splittedHash[3])!="undefined" && splittedHash[3].substr(0,4)=="page")
							data.paged = parseInt(splittedHash[3].split("-")[1]);
						return $this.getPageContent(data, false);
					}
				}
				//child page pagination
				else if(typeof(splittedHash[2])!="undefined" && splittedHash[2]!="" && typeof(splittedHash[3])!="undefined" && splittedHash[3].substr(0,4)=="page")
				{
					if($this.isOpen())
						return $this.getPageContent({
							name: (splittedHash[2].indexOf("#")!=-1 ? splittedHash[2].substr(0, splittedHash[2].indexOf("#")) : splittedHash[2]),
							parent_name: splittedHash[1],
							paged: parseInt(splittedHash[3].split("-")[1]),
							type: 'get_comments'
						}, false);
				}
				//child page
				else if(typeof(splittedHash[2])!="undefined" && splittedHash[2]!=""/* && $this.currentHash.indexOf($this.previousHash)!=-1*/)
				{
					if($this.isOpen())
						return $this.getPageContent({
							name: (splittedHash[2].indexOf("#")!=-1 ? splittedHash[2].substr(0, splittedHash[2].indexOf("#")) : splittedHash[2]),
							parent_name: splittedHash[1]
						}, false);
				}
				for(var id in $this.page)
				{
					if(id==splittedHash[1] || decodeURIComponent(id)==splittedHash[1])
						return(id);
				};
			}
            return(false);
        };
		
        /******************************************************************/
		
		this.getPageContent=function(data, expand)
		{
			if((parseInt(config.ajax) && config.animation=="expand") || typeof(data.parent_name)!="undefined" || typeof(data.paged)!="undefined" || typeof(data.category_id)!="undefined" || $("#prestige-window-content-" + data.name).hasClass("overwritten"))
			{
				data.action = 'prestige_get_content';
				var selector = $this.prestigeWindowContent;
				if(!expand)
				{
					if(data.type!='get_comments')
						selector.fadeOut(500);
				}
				if(config.animation=="swipe")
				{
					selector = $("#prestige-window-content-" + (typeof(data.parent_name)!="undefined" ? data.parent_name : data.name) + " .jspPane");
					if(typeof(data.parent_name)!="undefined" || typeof(data.paged)!="undefined" || typeof(data.category_id)!="undefined")
						$("#prestige-window-content-" + (typeof(data.parent_name)!="undefined" ? data.parent_name : data.name)).addClass("overwritten");
					else
						$("#prestige-window-content-" + (typeof(data.parent_name)!="undefined" ? data.parent_name : data.name)).removeClass("overwritten");
					if(!expand && data.type!='get_comments')
						selector.fadeOut(500);
				}
				$.get(config.ajaxurl, data, function(json) 
				{
					if(data.type=='get_comments')
						$this.fillPage(json.html, expand, $("#prestige_comments"), true, data);
					else
					{
						$this.fillPage(json.html, expand, selector, false, data);
						if(typeof(json.cf7)!="undefined" && json.cf7!="")
						{
							$.getScript(json.cf7, function(){
								if(expand)
									$this.expand({'onComplete':function() 
									{
										$this.setTabContent(false,data);
									}});
								return(false);
							});
						}
						else
						{
							if(expand)
								$this.expand({'onComplete':function() 
								{
									$this.setTabContent(false,data);
								}});
							return(false);
						}
					}
				},
				'json');
			}
			else
			{
				if(config.animation=="swipe" && $this.prestigeWindow.width()==this.maxWidth)
					$(".carousel").trigger("slideTo", "#prestige-window-content-" + data.name);
				else
					$this.fillPage($("#prestige-window-content-" + data.name).html(), expand, $this.prestigeWindowContent, false);
				if(expand)
					$this.expand({'onComplete':function() 
					{
						$(".carousel").trigger("slideTo", "#prestige-window-content-" + data.name);
						$this.setTabContent(false);
					}});
				return(false);
			}
			return(false);
		}
		
		/******************************************************************/
		
		this.setValueInTime=function(element, finalLevel, currentLevel)
		{
			element.css("display", "block");
			if(finalLevel==currentLevel)
				return false;
			else
			{	
				element.children(".skill_level_value").html(currentLevel+1);
				setTimeout(function(){
					$this.setValueInTime(element, finalLevel, currentLevel+1)
				}, 160);
			}
		}
		
		/******************************************************************/
		this.setTabContent=function(maintainPosition, data)
		{
			if(config.animation=="swipe" && typeof(data)!="undefined")
				$(".carousel").trigger("slideTo", "#prestige-window-content-" + (typeof(data.parent_name)!="undefined" ? data.parent_name : data.name));
			var splittedHash = $this.currentHash.split("#");
			if(splittedHash.length==3 && $("#" + splittedHash[2]).length)
			{
				if(config.animation=="swipe")
					$this.scrollbar = $("#prestige-window-content-" + (typeof(data.parent_name)!="undefined" ? data.parent_name : data.name)).jScrollPane({maintainPosition:false,autoReinitialise:false,showArrows:true}).data('jsp');
				else	
					$this.scrollbar =  $('#prestige-window-scroll').jScrollPane({maintainPosition:true,autoReinitialise:false}).data('jsp');
				$this.scrollbar.scrollToElement($("#" + splittedHash[2]), true);
			}
			else
				$this.createScrollbar(maintainPosition,data);
			$this.createNavigation();
			
			//$this.enable=true;
			$this.previousPage=$this.currentPage;
			
			if(config.animation!="swipe" || (typeof(data)!="undefined" && (typeof(data.parent_name)!="undefined" || typeof(data.paged)!="undefined" || typeof(data.category_id)!="undefined")))
			{
				var selector = (config.animation=="swipe" ? '#prestige-window-content-' + (typeof(data.parent_name)!="undefined" ? data.parent_name : data.name) : '#prestige-window-content');
				//slider
				$('#prestige-window-content .slider').nivoSlider({directionNav:false});
				
				//social icons tooltip
				$('#prestige-window-content ul.social-links li .social_icon[title]').qtip(
				{
						content:    { text:false },
						style:      { classes:'ui-tooltip-prestige' },
						position: 	{'my':'top center','at':'bottom center'}
				});	
				
				//portfolio
			
				/**************************************************************************/
				$(selector + ' .fancybox-image a').attr("rel", (config.animation=="swipe" ? (typeof(data.parent_name)!="undefined" ? data.parent_name : data.name) + "-gallery" : "gallery"));
				$(selector + ' .fancybox-image a').fancybox({
					'titleShow': false
				});
				
				/**************************************************************************/
				
				$(selector + ' .fancybox-video a').bind('click',function() 
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
				
				/**************************************************************************/
				
				$(selector + ' .fancybox-iframe a').fancybox({
					'width' : '75%',
					'height' : '75%',
					'autoScale' : false,
					'titleShow': false,
					'type' : 'iframe'
				});

				/**************************************************************************/
			}
		}
		
		/******************************************************************/
		
        this.expand=function(event)
        {
			if(config.animation=="swipe" && $this.prestigeWindow.width()==this.maxWidth)
			{
				$this.doEvent(event);
			}
			else
				$this.prestigeWindow.animate({width:this.maxWidth},1000,'easeOutQuint',function() 
				{
					$this.doEvent(event);
				});              
        };

        /******************************************************************/

        this.collapse=function(event)
        {
			if(config.animation=="swipe")
				$this.doEvent(event);
			else
				$this.prestigeWindow.animate({width:this.minWidth},300,'easeOutQuint',function() 
				{
					$this.doEvent(event);
				});
        };

        /******************************************************************/
        /******************************************************************/

        this.open=function()
        {
            $this.selectMenuElement();
            $this.selectWindowClass();
			//move menu if needed
			if(Math.abs(Math.abs(topDis/100)-$('#'+$this.getPageData($this.currentPage,'tab')).index("#prestige-menu li"))>=5)
			{
				$("#prestige-menu").css("height", "auto");
				topDis = -($('#'+$this.getPageData($this.currentPage,'tab')).index("#prestige-menu li")*100);
				if(topDis<-($("#prestige-menu").height()-500))
					topDis = -($("#prestige-menu").height()-500);
				$(".prestige-scroll-menu .prestige-menu-goup, .prestige-scroll-menu .prestige-menu-godown").removeClass("prestige-hidden");
				if(topDis==-($("#prestige-menu").height()-500))
					$(".prestige-scroll-menu .prestige-menu-godown").addClass("prestige-hidden");
				$("#prestige-menu").animate({
					top: topDis + "px"
				}, (config.animation=="swipe" ? parseInt(config.duration) : 1000), (config.animation=="swipe" ? config.animation_transition : "easeInOutCirc"));
			}
			else if(Math.abs(topDis/100)>$('#'+$this.getPageData($this.currentPage,'tab')).index("#prestige-menu li"))
			{
				$("#prestige-menu").css("height", "auto");
				$(".prestige-menu-goup").trigger("click");
			}
			
			//inside tab pagination
			var splittedHash = $this.currentHash.split("/");
			if(typeof(splittedHash[2])!="undefined" && splittedHash[2].substr(0,4)=="page")
				$this.getPageContent({
					name: (splittedHash[1].indexOf("#")!=-1 ? splittedHash[1].substr(0, splittedHash[1].indexOf("#")) : splittedHash[1]),
					paged: parseInt(splittedHash[2].split("-")[1])
				}, true);
			//blog category
			else if(typeof(splittedHash[2])!="undefined" && splittedHash[2].substr(0,8)=="category")
			{
				var	data = {
					name: (splittedHash[1].indexOf("#")!=-1 ? splittedHash[1].substr(0, splittedHash[1].indexOf("#")) : splittedHash[1]),
					category_id: parseInt(splittedHash[2].split("-")[1])
				};
				if(typeof(splittedHash[3])!="undefined" && splittedHash[3].substr(0,4)=="page")
					data.paged = parseInt(splittedHash[3].split("-")[1]);
				$this.getPageContent(data, true);
			}
			//child page pagination
			else if(typeof(splittedHash[2])!="undefined" && splittedHash[2]!="" && typeof(splittedHash[3])!="undefined" && splittedHash[3].substr(0,4)=="page")
				$this.getPageContent({
					name: (splittedHash[2].indexOf("#")!=-1 ? splittedHash[2].substr(0, splittedHash[2].indexOf("#")) : splittedHash[2]),
					parent_name: splittedHash[1],
					paged: parseInt(splittedHash[3].split("-")[1])
				}, true);
			//child page
			else if(typeof(splittedHash[2])!="undefined" && splittedHash[2]!="")
				$this.getPageContent({
					name: (splittedHash[2].indexOf("#")!=-1 ? splittedHash[2].substr(0, splittedHash[2].indexOf("#")) : splittedHash[2]),
					parent_name: splittedHash[1]
				}, true);
			else
				$this.getPageContent({
					name: splittedHash[1]
				}, true);
        };

        /******************************************************************/

        this.close=function(event)
        {
			if(config.animation!="swipe")
			{
				$(':input,a,span').qtip('destroy');
				$this.fillPage('', true, $this.prestigeWindowContent, false);
            }
			$this.destroyScrollbar();

            $this.collapse({'onComplete':function() 
            {
                $this.doEvent(event);
            }});
        };

        /******************************************************************/
        /******************************************************************/

        this.getPageData=function(key,property)
        {
            return($this.page[key][property]);
        };

        /******************************************************************/

        this.getDefaultPage=function()
        {
            for(var key in $this.page)
                if($this.page[key]['defaultPage']==1) return(key);

            return($this.getFirstPage());
        };

        /******************************************************************/
		
		this.timeoutFadeIn=function(content, selector, maintainPosition, data)
		{
			if(!selector.is(":animated"))
			{
				selector.html(content).fadeIn(500);
				$(".link, .menu-categories-container .menu-item a").click($this.pushState);
				$('.skill-list .skill_level').each(function() 
				{
					var width=parseInt($(this).css('width'));
					$(this).css('width','0px').css("background", "#ffffff");
					var level = $(this).attr("class").substr($(this).attr("class").indexOf("level-")+6);
					$(this).animate({width:level*25},level*200,function() {});
					$this.setValueInTime($(this).siblings(".skill_level_value_container"), level, 0);				
				});
				$('.skill-list .skill_content').each(function() 
				{
					$(this).animate({opacity:1},getRandom(100,1500),'easeOutQuint',function() {});
				});
				$this.setTabContent(maintainPosition, data);
				return false;
			}
			else
				setTimeout(function(){
					$this.timeoutFadeIn(content, selector, maintainPosition, data);
				}, 50);
		}
		
		/******************************************************************/
		
        this.fillPage=function(content, expand, selector, maintainPosition, data)
        {
			if(expand /*&& config.animation!="swipe"*/)
			{
				selector.html(content);
				$(".link, .menu-categories-container .menu-item a").click($this.pushState);
				$('.skill-list .skill_level').each(function() 
				{
					var width=parseInt($(this).css('width'));
					$(this).css('width','0px').css("background", "#ffffff");
					var level = $(this).attr("class").substr($(this).attr("class").indexOf("level-")+6);
					$(this).animate({width:level*25},level*200,function() {});
					$this.setValueInTime($(this).siblings(".skill_level_value_container"), level, 0);				
				});
				$('.skill-list .skill_content').each(function() 
				{
					$(this).animate({opacity:1},getRandom(100,1500),'easeOutQuint',function() {});
				});
			}
			else
				$this.timeoutFadeIn(content, selector, maintainPosition, data);
        }

        /******************************************************************/

        this.getFirstPage=function()
        {
            for(var key in $this.page) 
            {
                if($this.page[key]['main']==1) return(key);
            };

            return('');
        };

        /******************************************************************/

        this.getPrevPage=function()
        {
            var prev='';
            for(var key in $this.page)
            {
                if(key==$this.currentPage && prev!='') return(prev);
                else if($this.page[key]['main']==1) prev=key;
            };

            return(prev);
        };

        /******************************************************************/

        this.getNextPage=function()
        {
            var n=false;
            var next=$this.getFirstPage();

            for(var key in $this.page)
            {
                if(n) 
                {
                    if($this.page[key]['main']==1) return(key);
                };
                if(key==$this.currentPage) n=key;
            };

            return(next);
        };

        /******************************************************************/
        /******************************************************************/

        this.isOpen=function()
        {
            return($this.currentPage==-1 ? false : true);
        };

        /******************************************************************/

        this.isEnable=function()
        {
            if(!$this.enable)
            {
                if($this.previousHash!='')
                    window.location.href=$this.previousHash;
                else window.location.href=$this.currentHash;

                return(false);
            }  

            return(true);
        };

        /******************************************************************/
        /******************************************************************/

        this.createScrollbar=function(maintainPosition,data)
        {
			if(config.animation=="swipe" && typeof(data)!="undefined" && (typeof(data.name)!="undefined" || typeof(data.parent_name)!="undefined"))
				$(".carousel #prestige-window-content-"+(typeof(data.parent_name)!="undefined" ? data.parent_name : data.name)).jScrollPane({maintainPosition:maintainPosition,autoReinitialise:false,showArrows:true}).data('jsp').reinitialise();
			else
			{
				if(maintainPosition)
				{
					$this.scrollbar =  $('#prestige-window-scroll').jScrollPane({maintainPosition:maintainPosition,autoReinitialise:false}).data('jsp');
					$this.scrollbar.reinitialise();
				}
				else
					$this.scrollbar=$('#prestige-window-scroll').jScrollPane({maintainPosition:maintainPosition,autoReinitialise:false}).data('jsp');
			}
		};

        /******************************************************************/

        this.destroyScrollbar=function()
        {
            if($this.scrollbar!='' && typeof($this.scrollbar)!="undefined") 
            {
                $this.scrollbar.destroy();
                $this.scrollbar='';
            };              
        };

        /******************************************************************/
        /******************************************************************/

        this.selectMenuElement=function()
        {
            $this.prestigeMenuElement.removeClass('selected');
			$this.prestigeMenuElement.css({'background-color': 'transparent'});
            $('#'+$this.getPageData($this.currentPage,'tab')).addClass('selected').css({'background-color': '#' + $this.getPageData($this.currentPage,'color')});
        }

        /******************************************************************/

        this.selectWindowClass=function()
        {
            $this.prestigeWindow.attr('class','prestige-window ' + $('#'+$this.getPageData($this.currentPage,'tab')).attr('class'));
			$this.prestigeWindow.find('#prestige-window-background').css({'background-color': '#' + $this.getPageData($this.currentPage,'color')});
        }

        /******************************************************************/

        this.createNavigation=function()
        {
            var prev=$this.getPrevPage();				
            var next=$this.getNextPage();

            $this.prestigeNavigationPrev.attr('href',prev);
            $this.prestigeNavigationNext.attr('href',next);
        };

        /******************************************************************/
        /******************************************************************/

        this.doEvent=function(event)
        {
            if(typeof(event)!='undefined')
            {
                if(typeof(event.onComplete)!='undefined') event.onComplete.apply();
            };                  
        };

        /******************************************************************/
    };

    /**************************************************************/

    $.fn.prestige=function(page)
    {
        /***********************************************************/

        var prestige=new Prestige(this,page);
        prestige.load();

        /***********************************************************/
    };

    /**************************************************************/

})(jQuery);