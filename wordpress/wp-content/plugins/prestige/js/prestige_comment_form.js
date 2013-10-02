
    /*****************************************************************/
    /*****************************************************************/

    function submitCommentForm()
    {
        blockForm('prestige_comment_form','block');
		jQuery("#prestige_comment_form [name='paged']").val(jQuery("#prestige_comments .prestige_pagination .prestige_current").html());
        jQuery.post(config.ajaxurl,jQuery('#prestige_comment_form').serialize(),submitCommentFormResponse,'json');
    }

    /*****************************************************************/

    function submitCommentFormResponse(response)
    {
		jQuery("#cancel_comment").css('display', 'none');
		jQuery("#prestige_comment_form [name='comment_parent_id']").val(0);
        blockForm('prestige_comment_form','unblock');
        jQuery('#comment-user-name,#comment-user-email,#comment-message,#comment-send').qtip('destroy');

        var tPosition=
        {
            'comment-send':{'my':'right center','at':'left center'},
            'comment-message':{'my':'right center','at':'left center'},
            'comment-user-name':{'my':'right center','at':'left center'},
            'comment-user-email':{'my':'right center','at':'left center'}
        };

        if(typeof(response.info)!='undefined')
        {	
            if(response.info.length)
            {	
                for(var key in response.info)
                {
                    var id=response.info[key].fieldId;
                    jQuery('#'+response.info[key].fieldId).qtip(
                    {
                            style:      { classes:(response.error==1 ? 'ui-tooltip-error' : 'ui-tooltip-success')},
                            content: 	{ text:response.info[key].message },
                            position: 	{ my:tPosition[id]['my'],at:tPosition[id]['at'] }
                    }).qtip('show');				
                }
				if(typeof(response.html)!='undefined')
				{
					jQuery("#prestige_comments").html(response.html);
					jQuery(".prestige_pagination a").click(function(event){
						event.preventDefault();
						var History = window.History;
						var url = jQuery(this).attr("href");
						if(history.pushState)
							History.pushState(null, null, config.home_url + "/" + url.replace("#!/", "").replace(new RegExp(config.home_url + "/", 'g'), ""));
						else
							History.pushState(null, null, config.home_url + "/?" + url);
					});
					if(typeof(response.change_url)!='undefined')
					{
						var History = window.History;
						if(history.pushState)
							History.pushState(null, null, config.home_url + "/" + response.change_url);
						else
							History.pushState(null, null, config.home_url + "/?" + response.change_url);
							//window.location.href = response.change_url;
					}
					if(config.animation=="swipe")
						api = jQuery("#prestige_comments").parentsUntil(".carousel").last().jScrollPane({maintainPosition:true,autoReinitialise:false,showArrows:true}).data('jsp');
					else
						api =  jQuery('#prestige-window-scroll').jScrollPane({maintainPosition:true,autoReinitialise:false}).data('jsp');
					api.reinitialise();
					setTimeout(function(){
						jQuery('#comment-send').qtip('destroy');
					}, 5000);
				}
				if(response.error==0)
					jQuery('#prestige_comment_form')[0].reset();
            }
        }
    }

    /*****************************************************************/
    /*****************************************************************/