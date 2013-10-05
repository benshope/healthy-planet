(function ($) {
	"use strict";
	window.requestAnimFrame = (function(){
		return  window.requestAnimationFrame ||
			window.webkitRequestAnimationFrame ||
			window.mozRequestAnimationFrame    ||
			window.oRequestAnimationFrame      ||
			window.msRequestAnimationFrame     ||
			function(callback) {
				window.setTimeout(callback, 1000 / 60);
			};
	})();
	
	// Resize videos
	$.fn.resizeVideos = function() {
		var theVideos = this.find('.video-wrap iframe, video');
		theVideos.each(function() {
			var theVideo = $(this),
				ratio = theVideo.data('aspectRatio');
				
			if (typeof ratio === "undefined") {
				var height = ( this.tagName.toLowerCase() === 'object' || (theVideo.attr('height') && !isNaN(parseInt(theVideo.attr('height'), 10))) ) ? parseInt(theVideo.attr('height'), 10) : theVideo.height(),
					width = !isNaN(parseInt(theVideo.attr('width'), 10)) ? parseInt(theVideo.attr('width'), 10) : theVideo.width();
				ratio = width / height;
			}
			
			var	newWidth = theVideo.css('width', '100%').width(),
				newHeight = newWidth/ratio;
			theVideo.height(newHeight);
		});
	};

	//Media Players Video - Youtube & Vimeo
	$(window).load(function() {

		var fillerBar = $('.nav-filler');

		var vimeoPlayers = jQuery('.homepage-slider').find('iframe.vimeo_frame'), player;
		for (var i = 0, length = vimeoPlayers.length; i < length; i++) {
			player = $f(vimeoPlayers[i]);
			player.addEvent('ready', ready);
		}

		function addEvent(element, eventName, callback) {
			if (element.addEventListener) {
				element.addEventListener(eventName, callback, false);
			} else {
				element.attachEvent(eventName, callback, false);
			}
		}

		function ready(player_id) {

			var froogaloop = $f(player_id);
			froogaloop.addEvent('play', function(id) {
				jQuery('.homepage-slider').flexslider('pause');
				fillerBar
					.removeClass('s-loading')
					.css('width', '0');
			});
			froogaloop.addEvent('pause', function(id) {
				jQuery('.homepage-slider').flexslider('play');
				fillerBar
					.addClass('s-loading')
					.css('width', '100%');
			});
			froogaloop.addEvent('finish', function(id) {
				jQuery('.homepage-slider').flexslider('play');
			});
		}

		function create_youtube_player(self){
			var this_player = new YT.Player(jQuery(self).attr('id'), {
				videoId: jQuery(self).data('ytid'),
				playerVars: { 'controls': 1, 'modestbranding': 1, 'showinfo': 0, 'html5': 1 },
				events: {

					'onStateChange': function (event) {
						if (event.data == YT.PlayerState.PLAYING ) {
							// Pause Slider while Playing the Video
							jQuery('.homepage-slider').flexslider("pause");
							fillerBar
								.removeClass('s-loading')
								.css('width', '0');
						}
						if (event.data === YT.PlayerState.PAUSED ) {
							// Play Slider while Video is paused
							jQuery('.homepage-slider').flexslider("play");
							fillerBar
								.addClass('s-loading')
								.css('width', '100%');
						}
					}
				}
			});
		}

		//function onYouTubeIframeAPIReady() {
		jQuery('.youtube_frame').each(function(){
			var self = this;
			create_youtube_player(self);
			//jQuery(".video-wrap").fitVids();
		});
		
		jQuery('body').resizeVideos();

	});

	$(document).ready(function(){
		$('html').removeClass('no-js').addClass('js');

		var useTransform = true;
		var transform;
		var ua = navigator.userAgent;
		var winLoc = window.location.toString();

		var is_webkit = ua.match(/webkit/i);
		var is_firefox = ua.match(/gecko/i);
		var is_newer_ie = ua.match(/msie (9|([1-9][0-9]))/i);
		var is_older_ie = ua.match(/msie/i) && !is_newer_ie;
		var is_ancient_ie = ua.match(/msie 6/i);
		var is_mobile = ua.match(/mobile/i);
		var is_OSX = (ua.match(/(iPad|iPhone|iPod|Macintosh)/g) ? true : false);

		var use2DTransform = (ua.match(/msie 9/i) || winLoc.match(/transform\=2d/i));
		var $elements, offset;
		var lastScroll = 0;
		var is_touch_device = !!('ontouchstart' in window) || !!('onmsgesturechange' in window); // works on ie10

		if (is_touch_device) {
			$('html').addClass('touch');
		}

		// setting up transform prefixes
		var prefixes = {
			webkit: 'webkitTransform',
			firefox: 'MozTransform',
			ie: 'msTransform',
			w3c: 'transform'
		};
		if (useTransform) {
			if (is_webkit) {
				transform = prefixes.webkit;
			} else if (is_firefox) {
				transform = prefixes.firefox;
			} else if (is_newer_ie) {
				transform = prefixes.ie;
			}
		}

		function parallax() {
			var $container = $('.parallax-container'),
				$parent = $container.parent(),
				$elements = $container.find('.parallax-item');

			var containerWidth = typeof $container.data('width') !== 'undefined' ? $container.data('width') : $container.width();
			var containerHeight = $container.data('height');
			var imgRatio = $('.parallax-item img').width() / $('.parallax-item img').height();

			var $wrapper = $('.wrapper-featured-image'),
				wrapperWidth, wrapperHeight, wrapperRatio,
				$image = $('.parallax-item img'),
				imageWidth, imageHeight, imageRatio;

			if (typeof containerHeight !== 'undefined') {
				wrapperHeight = containerHeight;
				var newHeight = $(window).width() * containerHeight / containerWidth;
				$parent.height(newHeight);
				$container.css({
					'width': '100%',
					'overflow': 'hidden'
				});

				if (is_touch_device) {
					$container.css({
						'position': 'absolute'
					});
				} else {
					$container.css({
						'position': 'fixed'
					});
				}
			}

			$(window).on('resize', function() {

				$image.css({
					'width': 'auto',
					'height': 'auto',
					'max-width': 'none',
					'position': 'relative',
					'top': '0',
					'left': '0'
				});

				imageWidth = $image.data('imgwidth');
				imageHeight = $image.data('imgheight');
				imageRatio = imageWidth / imageHeight;
				
				wrapperWidth = $wrapper.width();
				wrapperHeight = $wrapper.height();

				wrapperRatio = wrapperWidth / wrapperHeight;

				if (wrapperRatio > imageRatio) {
					// landscape
					$image.css({
						'width': '100%',
						'height': wrapperWidth / imageRatio
					});
				} else {
					// portrait
					$image.css({
						'width': wrapperHeight * imageRatio,
						'height': wrapperHeight
					});
				}

				imageWidth = $image.width();
				imageHeight = $image.height();

				
				// horizontal centering
				if (imageWidth > wrapperWidth) {
					$image.css({'left': (wrapperWidth - imageWidth) / 2});
				} else {
					$image.css({'left': 0});
				}

				// vertical centering
				if (imageHeight > wrapperHeight) {
					$image.css({'top': (wrapperHeight - imageHeight) / 2});
				} else {
					$image.css({'top': 0});
				}
			});

			$(window).trigger('resize');

			// the actual parallax moving function
			function refresh() {
				$elements.each(function(i, self) {
					var transformParam, $element = $(self);
					offset = -1 * lastScroll / 3;
					if (!is_touch_device) {
						if (!use2DTransform) {
							transformParam = 'translate3d(0px,' + offset + 'px, 0px)';
						} else {
							transformParam = 'translateY(' + offset + 'px)';
						}
						if (transform && transformParam) {
							$element.css(transform, transformParam);
							$element.css(prefixes.w3c, transformParam);
						} else {
							$element.css('marginTop', offset + 'px');
						}
					}
				});
			}

			$(window).on('scroll', function(e) {
				lastScroll = $(document).scrollTop();
				requestAnimFrame(refresh);
			});
		}

		parallax();

		//MediaPlayerJS plugin for audio and video
		var media_elements = $('audio, video');
		if(media_elements.length) {
			media_elements.mediaelementplayer({
				videoWidth: '100%',
				videoHeight: '100%',
				audioWidth: '100%',
				features: ['playpause','progress','tracks','volume','fullscreen'],
				videoVolume: 'horizontal',
				enableAutosize: true,
				success: function(mediaElement, domObject){

					var slider = $(domObject).parents('.homepage-slider');
					if ( slider.length > 0 ) {
						$(mediaElement).on('playing' , function(){
							slider.flexslider('pause');
							fillerBar
								.addClass('s-loading')
								.css('width', '100%');
						});

						$(mediaElement).on('pause' , function(){
							slider.flexslider('play');
							fillerBar
								.addClass('s-loading')
								.css('width', '100%');
						});
					}
				}
			});
		}

		$('.block-inner.block-middle').each(function() {
			var self = $(this),
				parent = self.parent(),
				newDiv = $("<div />", {
					"css": {
						"width": "100%",
						"display": "table-cell",
						"vertical-align": "middle"
					}
				});

			setTimeout(function() {
				self.css('display', 'table').wrapInner(newDiv);
				setTimeout(function() {
					self.height(parent.height() - parseInt(self.css('padding-top')) - parseInt(self.css('padding-bottom')));
				}, 20);
			}, 500);
		});

		$('.testimonials-slider, .widget-area .widget_wpgrade_twitter_widget, .latest-posts-slider').each(function() {
			var self = $(this),
				slides = self.find('.slide'),
				slidesNo = slides.length;

			if (slidesNo == 1) {
				slides.addClass('flex-active-slide');
			} else {
				self.flexslider({
					animation: "fadecss",
					directionNav: false,
					initDelay: 5000
				});
			}
		});

		$('.twitter-footer_slider').flexslider({
			animation: "fadecss",
			controlNav: false,
			initDelay: 5000
		});

		//Smooth Scrolling
		function niceScrollInit() {
			$("html").niceScroll({
				zindex: 9999,
				cursoropacitymin: 0.3,
				cursorwidth: 7,
				cursorborder: 0,
				mousescrollstep: 60,
				horizrailenabled: false,
				scrollspeed: 80
			});
		}

		var smoothScroll = $('html').attr('data-smooth-scroll');
		if (smoothScroll == 'on' && $(window).width() > 680 && !is_touch_device && !is_OSX) {niceScrollInit();}

		// Homepage slider ----------------------------------------------------
		var sliderWrapper = $('.homepage-slider'),
			slidesNo = $('.homepage-slider .slides').children().length,
			currentSlideNo = $('.homepage-slider .slides .flex-active-slide').index(),
			fillerBar = $('.nav-filler');

		//One Slide Case - add flex-active-slide class
		if(sliderWrapper.length) {
			sliderWrapper.each( function(index) {
				if (($(this).find('.slides').children().length) == 1) {
					$(this).find('.slide').addClass('flex-active-slide');
				}
			});
		}

		function frontpage_slider() {
			var self = $('.homepage-slider'),
				slides = self.find('.slide'),
				slidesNo = slides.length,
				slideshowSpeed = 6000,
				animationSpeed = 1000,
				slideshowHeight = 0,
				directionNav = true,
				controlNav = true;

			if ( typeof self.data('slideshow_speed' ) !== "undefined" ) {
				slideshowSpeed = self.data('slideshow_speed');
			}

			if ( typeof self.data('animation_speed' ) !== "undefined" ) {
				animationSpeed = self.data('animation_speed');
			}

			if ( typeof self.data('direction_nav' ) !== "undefined" ) {
				directionNav = self.data('direction_nav');
			}

			if ( typeof self.data('control_nav' ) !== "undefined" ) {
				controlNav = self.data('control_nav');
			}
			
			if ( typeof self.data('height' ) !== "undefined" ) {
				slideshowHeight = self.data('height');
			}

			if (slidesNo == 1) {
				slides.addClass('flex-active-slide');
				self.removeClass('loading');

				var $img = slides.find('img');
				
				$img.css({
					'width': '100%',
					'height': 'auto'
				});

				$(window).on('resize', function(e) {
					$img.css({
						'width': '100%',
						'height': 'auto'
					});

					if(self.height() < $img.height()) {
						$img.css({
							'top': (self.height() - $img.height()) / 2,
							'left': 0
						});
					} else {
						$img.css({
							'width': 'auto',
							'height': '100%',
							'left': (self.width() - $img.width()) / 2,
							'top': 0
						});
					}
				});

				$(window).trigger('resize');

			} else {
				self.flexslider({
					animation: "fadecss",
					controlNav: controlNav,
					directionNav: directionNav,
					controlsContainer: ".slider-front-page",
					manualControls: ".slider-control-nav li",
					useCSS: false,
					smoothHeight: true,
					slideshowSpeed: slideshowSpeed,
					animationSpeed: animationSpeed,
					video: true,
					pauseOnHover: false,
					pauseOnAction: true,
					slideshow: true,
					prevText: "",
					nextText: "",
					startAt: 0,
					before: function(slider){
						// when we change a slide we need to stop the playing video
						var vimeo_frame = slider.slides.eq(slider.currentSlide).find('iframe.vimeo_frame'),
							youtube = slider.slides.eq(slider.currentSlide).find('.youtube_frame'),
							mejs_container = slider.slides.eq(slider.currentSlide).find('.mejs-container');

						if (youtube.length !== 0){
							youtube[0].contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
						}
						if (vimeo_frame.length !== 0){
							$f(  vimeo_frame.attr('id') ).api('pause');
						}
						if (mejs_container.length !== 0) {
							$(mejs_container).find('video')[0].pause();
						}

						$(window).trigger('resize focus');
						self.css({'min-height':'0'});

						fillerBar
							.addClass('s-fast')
							.css('width', '0%');
						currentSlideNo = slider.animatingTo;
					},
					after: function(slider) {
						fillerBar
							.removeClass('s-fast')
							.css('width', '100%');
					},
					start: function(slider) {
						if (!slider.slides) {return;}

						fillerBar
							.addClass('s-loading')
							.css('width', '100%');

						var slideHeight = slider.find('.slide').first().height();

						// calculating smallest image height
						$(window).on('resize', function() {

							slider.find('.slide').height('auto');
							
							if (slider.data('fullscreen') && $(window).width() > 1023) {
								slideHeight = $(window).height();
							} else if (slideshowHeight !== 0 ) {
								slideHeight = slideshowHeight;
							} else {
								slider.find('.slide').each(function() {
									if ($(this).height() > slideHeight) {
										slideHeight = $(this).height();
									}
								});
							}

							slider.find('.slide').each(function() {
								var $slide = $(this),
										$image = $slide.children('img').width('auto').height('auto'),
										imageHeight = $image.height(),
										imageWidth = $image.width(),
										slideWidth = $(window).width(),
										imageRatio = imageWidth / imageHeight,
										slideRatio = slideWidth / slideHeight;

										$slide.height(slideHeight);

									if (slideRatio > imageRatio) {
										// landscape
										$image.css({
											'width': '100%',
											'height': slideWidth / imageRatio
										});
									} else {
										// portrait
										$image.css({
											'width': slideHeight * imageRatio,
											'height': slideHeight
										});
									}

									imageWidth = $image.width();
									imageHeight = $image.height();

									// horizontal centering
									if (imageWidth > slideWidth) {
										$image.css({'left': (slideWidth - imageWidth) / 2});
									} else {
										$image.css({'left': 0});
									}

									// vertical centering
									if (imageHeight > slideHeight) {
										$image.css({'top': (slideHeight - imageHeight) / 2});
									} else {
										$image.css({'top': 0});
									}

							});
							slider.animate({height: slideHeight}, 600);
						});
						$(window).trigger('resize');

						slider.removeClass('loading');
					}
				});
			}
		}

		frontpage_slider();

		//Gallery Post Format Slider
		var gallery_format = $('.gallery');
		function gallery_format_slideshow(e) {
			// create the specific markup for flexslider
			e.addClass('slides');
			$('.gallery-item').addClass('slide');
			$('.gallery > br').remove();

			$('.gallery_format_slider').flexslider({
				animation: "fadecss",
				selector: ".gallery > dl",
				useCSS: false,
				controlNav: false,
				directionNav: true,
				prevText: "",
				nextText: "",
				keyboard: false,
				slideshow: false,
				smoothHeight: true,
				start: function(slider){
					var maxHeight = slider.find('.slide').first().height('auto').height();

					// calculating smallest image height
					slider.find('.slide').each(function() {
						if ($(this).height('auto').height() < maxHeight) {
							maxHeight = $(this).height();
						}
					});

					// center images vertically based on the new set height
					slider.find('.slide').each(function() {
						$(this).css({
							'position': 'relative',
							'top': -1 * ($(this).height() - maxHeight)/2,
							'left': 0
						});
					});

					slider.find('.slide').height(maxHeight);
					slider.animate({height: maxHeight}, 300);
					setTimeout(function() {
						slider.removeClass('loading');
					}, 600);
				}
			});
		}

		if(gallery_format.length) { gallery_format_slideshow(gallery_format); }

		// Google+ like box fly-in effect
		$.fn.visible = function(partial) {
			var $t        = $(this),
				$w            = $(window),
				viewTop       = $w.scrollTop(),
				viewBottom    = viewTop + $w.height() + 100,
				_top          = $t.offset().top,
				_bottom       = _top + $t.height(),
				compareTop    = partial === true ? _bottom : _top,
				compareBottom = partial === true ? _top : _bottom;
			return (viewBottom > compareBottom);
		};

//		var allMods = $(".portfolio-rows .block");
//		allMods.each(function(i, el) {
//			var el = $(el);
//			if (el.offset().top < jQuery(window).height()) {
//				el.addClass("already-visible"); 
//			}
//		});

//		$(window).scroll(function(event) {
//			allMods.each(function(i, el) {
//				var el = $(el);
//				if (el.visible(true)) {
//					setTimeout(function() {
//						el.addClass("come-in"); 
//					}, 100 + Math.floor((Math.random()*4)+1) * 50);
//				} 
//			});
//		});

		// Scroll Monitor plugin ----------------------------------------------
		jQuery.fn.scroll_animate = function() {
			var self = this;
			this.addClass('s-monitor s-hidden');
			if(this.length) {
				var watcher = scrollMonitor.create( this, -0 );
				watcher.enterViewport(function() {
					jQuery.each(self, function(i, e) {
						setTimeout(function() {
							jQuery(e).removeClass('s-hidden').addClass('s-visible');
						}, 125*i);
					});
				});
			}
		};

		// Progressbar Shortcode ----------------------------------------------
		function progressbar_shortcode(e) {
			e.each(function() {
				var self = $(this).find('.progressbar-progress');
				self.css({'width': self.data('value')});
			});
		}
		var progressbar_shc = $('.progressbar');
		if(progressbar_shc.length) {
			progressbar_shortcode(progressbar_shc);
			progressbar_shc.scroll_animate();
		}

		// Tabs Shortcode
		$('.tab-titles-list a').click(function (e) {
			e.preventDefault();
			var self = $(this),
				target = $(self.attr('href'));
			self.tab('show');
			if ($(window).width() < 1024) {
				self.parent().siblings('.tabs-content-pane').height(0);
				var targetHeight = target.height('auto').height();
				target.height(targetHeight);

				$('body').animate({
					scrollTop: target.offset().top - self.outerHeight()
				}, '500', 'swing');

				self.parent().siblings('.tab-titles-list-item.active').removeClass('active');
				self.parent().addClass('active');
			} else {
			}

		});

		//Portfolio filtering -------------------------------------------------
		var is_portfolio_loaded = false,
			$container = $('.portfolio-rows');

		$('.filter-by_list a').click(function(){

			var filter = $(this).attr('data-filter');
			
			//make sure none is active
			$('.filter-by_list li.current-item').removeClass('current-item');
			
			//make the current filter active
			$(this).parent().addClass('current-item');

			if ( !is_portfolio_loaded ) {
				$container.children('.portfolio-archive').prepend('<div class="loading-gif"></div>');
				var offset = $container.find('div.portfolio-row').length,
					navigation = $container.children('div.portfolio-navigation');

				$.post(
					ajaxurl,
					{
						action: 'wpgrade_load_all_portfolio_projects',
						offset: offset
					},
					function(response)
					{

						var result = JSON.parse(response);

						$container.find('.portfolio-archive').append(result);
						is_portfolio_loaded = true;

						$('.portfolio-archive').find('div.portfolio-row').each(function(i,el){

							$(this).find(".video-wrap iframe").each(function() {
								$(this)
									.data('aspectRatio', this.width / this.height)
									// and remove the hard coded width/height
									.removeAttr('height')
									.removeAttr('width');
							});

							if ( filter === "*" || ( typeof $(el).data('terms') !== 'undefined' && $(el).data( 'terms' ).match(filter) ) ){
								$(el).show().removeClass('go-out').addClass('come-in');

							} else {
								$(el).removeClass('come-in').addClass('go-out');
								setTimeout(function(){
									$(el).hide();
								}, 400);
							}

						});

						$container.resizeVideos();

						navigation.remove();
						$('.loading-gif').fadeOut(400, function(){
								$(this).remove();
							});
					}
				);
			} else {

				$container.find('div.portfolio-row').each(function(i,el){

					if ( filter === "*" || ( typeof $(el).data('terms') !== 'undefined' && $(el).data( 'terms' ).match(filter) ) ){
						$(el).show().removeClass('go-out').addClass('come-in');

					} else {
						$(el).removeClass('come-in').addClass('go-out');
						setTimeout(function(){
							$(el).hide();
						}, 400);
					}

				});
			}

			return false;
		});

		//Portfolio AJAX Load More -------------------------------------------------
		var maxportfoliopages = $container.find('.portfolio-archive').data('maxpages');
		var $window = $(window);
		var pagecounter = 1;

		$container.infinitescroll({
				navSelector  : '#portfolio-nav',    // selector for the paged navigation
				nextSelector : '#portfolio-nav .previous-project-link a',  // selector for the NEXT link (to page 2)
				itemSelector : '.portfolio-row',     // selector for all items you'll retrieve
				loading: {
					finished: undefined,
					finishedMsg: "<em>These are all our projects.</em>",
					img: "",
					msg: null,
					msgText: "<em>Loading more projects...</em>",
					selector: null,
					speed: 'fast',
					start: undefined
				},
				debug: false
			},
			function( newElements ) {
				var $newElems = $(newElements).hide();
				// ensure that images load before adding to masonry layout
				$newElems.imagesLoaded(function(){
					pagecounter = pagecounter + 1;
					if (pagecounter == maxportfoliopages) {
						$('.load_more').addClass('hidden');
						$('.load_more').closest('.portfolio-navigation').addClass('hidden');
					} else {
						$('.load_more a').removeClass('loading');
					}

					// Figure out and save aspect ratio for each video
					$newElems.each(function() {
						$(this).find(".video-wrap iframe").each(function() {
							$(this)
								.data('aspectRatio', this.width / this.height)

								// and remove the hard coded width/height
								.removeAttr('height')
								.removeAttr('width');

						});
					});
					
					$container.find('.portfolio-archive').append(newElements);
					$newElems.addClass('come-in').fadeIn();
					$container.resizeVideos();
				});
			});

		// unbind normal behavior. needs to occur after normal infinite scroll setup.
		$window.unbind('.infscr');

		$('.load_more a').click(function(){
			$(this).addClass('loading');
			$container.infinitescroll('retrieve');
			return false;
		});

		// remove the paginator when we're done.
		$(document).ajaxError(function(e,xhr,opt){
			if (xhr.status == 404) {
				$('.load_more').fadeOut('slow');
				$('.load_more').closest('.block-inner').fadeOut('slow');
			}
		});


		// Smaller Header on Scroll -------------------------------------------
		var header = $('.wrapper-header-small'),
			didScroll = false,
			changeHeaderOn = 350,
			timer;

		function scrollPage() {
			var sy = $(document).scrollTop();
			if (sy >= changeHeaderOn) {
				header.addClass('is-visible');
			} else {
				header.removeClass('is-visible');
			}
			didScroll = false;
		}

		$(window).scroll(function() {
			if(!didScroll) {
				didScroll = true;
				setTimeout(scrollPage, 250);
			}
		});

		//Search Button
		var searchContainer = $('.header_search-form');
		var searchField = $('.header_search-form .field');
		var searchButton = $('.header_search-form .btn');
		searchField.on('blur', function() {
			setTimeout(function() {
				searchContainer.removeClass('is-visible');
			}, 500);
		});

		searchContainer.on('click', function(e, source) {
			// if (source != 'searchform') {
			// e.preventDefault();
			// e.returnValue = false;
			if (searchField.hasClass('is-visible')) {
				if (searchField.val().length != 0) {
					// searchButton.trigger('click', 'searchform');
				} else {
					searchContainer.removeClass('is-visible');
				}
			} else {
				searchContainer.addClass('is-visible').focus();
			}
			// return false;
			// }
		});

		// nav open
		$('.nav-btn').on('click', function(e) {
			e.preventDefault();
			$('html').toggleClass('js-nav');
		});

		// Magnific Pop-up for Projects
		function project_page_popup(e) {
			if (jQuery().magnificPopup) {
				e.magnificPopup({
					type: 'image',
					image: { titleSrc: '' },
					gallery: { enabled:true },
					removalDelay: 300,
					mainClass: 'pxg-slide-bottom',
					fixedContentPos: false,
					callbacks: {
						beforeOpen: function() {
							if (smoothScroll == 'on' && $(window).width() > 680 && !is_touch_device && !is_OSX) {this.scrollbarSize = 0;}
						}
					}
				});
			}
		}

		var project_single_gallery = $('.portfolio-rows a.popup');
		if(project_single_gallery.length) { project_page_popup(project_single_gallery); }

		// Magnific Pop-up for Gallery Post Format

		var post_format_gallery = $('.gallery_format_slider .gallery-icon a');
		if(post_format_gallery.length) { project_page_popup(post_format_gallery); }

		//Magnific Popup for any other <a> tag that link to an image in single posts and pages
		function blog_posts_popup(e) {
			if (jQuery().magnificPopup) {
				e.magnificPopup({
					type: 'image',
					closeOnContentClick: true,
					closeBtnInside: false,
					removalDelay: 300,
					mainClass: 'pxg-slide-bottom',
					image: { verticalFit: true },
					fixedContentPos: false,
					callbacks: {
						beforeOpen: function() {
							if (smoothScroll == 'on' && $(window).width() > 680 && !is_touch_device && !is_OSX) {this.scrollbarSize = 0;}
						}
					}
				});
			}
		}

		var blog_posts_images = $('.single .post a[href$=".jpg"], .single .post a[href$=".png"], .page a[href$=".jpg"], .page a[href$=".png"]');
		if(blog_posts_images.length) { blog_posts_popup(blog_posts_images); }
		
		// Find all videos
		var $allVideos = $(".video-wrap iframe");

		// Figure out and save aspect ratio for each video
		$allVideos.each(function() {
			$(this)
				.data('aspectRatio', this.width / this.height)

				// and remove the hard coded width/height
				.removeAttr('height')
				.removeAttr('width');

		});

		//resize the videos to fit the containter width
		$('body').resizeVideos();

		// Responsive menus
		var smallNav = $('.wrapper-header-small .site-navigation');
		// if (is_touch_device) {
			smallNav.find('li.menu-parent-item > a').on('click', function(e) {
				if ($(this).width() - e.pageX < 40 && $('html').hasClass('js-nav')) {
					e.preventDefault();
					$(this).parent().siblings().removeClass('active');
					$(this).parent().toggleClass('active');
				}
			});
		// }

		// Responsive tabs
		$('.tab-titles-list-item').each(function() {
			$(this).data('source', $(this).parent());
		});

		var timer;
		$(window).on('resize', function() {
			clearTimeout(timer);
			timer = setTimeout(function() {
				if ($(window).width() < 1024) {				
					$('.tab-titles-list-item').each(function() {
						var toggle = $(this),
							target = $(toggle.children().attr('href'));
						toggle.insertBefore(target);
					});
				} else {
					$('.tab-titles-list-item').each(function() {
						var toggle = $(this),
							target = $(toggle.children().attr('href'));
						toggle.appendTo(toggle.data('source'));
					});
				}
			}, 300);
		});

		$(window).trigger('resize');
	});
	
	//recalculate the videos width and height on window resize
	$(window).resize(function(){
		$('body').resizeVideos();
	});
	
})(jQuery);