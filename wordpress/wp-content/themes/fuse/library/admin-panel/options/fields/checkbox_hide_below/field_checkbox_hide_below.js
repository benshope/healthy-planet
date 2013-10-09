jQuery(document).ready(function(){
	jQuery('.redux-opts-checkbox-hide-below').each(function(){
		var amount = jQuery(this).data('amount');
		if(!jQuery(this).is(':checked')){
			jQuery(this).closest('tr').nextAll('tr').slice(0,amount).hide();
		}
	});
	jQuery('.redux-opts-checkbox-hide-below').click(function(){
		
		var amount = jQuery(this).data('amount');
		if (jQuery(this).prop('checked')) {
			jQuery(this).closest('tr').nextAll('tr').slice(0,amount).fadeIn('slow');
		} else {
			jQuery(this).closest('tr').nextAll('tr').slice(0,amount).fadeOut('slow');
		}
		
		//check to see if we need to hide something
		//this is about the child_of option where we hide the options that are children
		//of radio options
		jQuery('.child_of_other').each(function(){
			var parentID = jQuery(this).data('id'),
				parentValue = jQuery(this).data('value');

			var $parent = jQuery('input[name="' + redux_opts.opt_name + '[' + parentID + ']"]:checked');

			if($parent.val() !== parentValue){
				jQuery(this).closest('tr').hide();
			}
		});
	});
});
