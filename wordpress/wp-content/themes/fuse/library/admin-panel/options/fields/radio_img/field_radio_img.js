/*global jQuery*/
/*
 *
 * Redux_Options_radio_img function
 * Changes the radio select option, and changes class on images
 *
 */
function redux_radio_img_select(relid, labelclass) {
	var $field = jQuery(this).prev('input[type="radio"]');

    $field.prop('checked');
	var	fieldValue =  jQuery('#'+relid).val();
    jQuery('.redux-radio-img-' + labelclass).removeClass('redux-radio-img-selected');
    jQuery('label[for="' + relid + '"]').addClass('redux-radio-img-selected');
	
	//lets hide the children from harms way
	jQuery('.child_of-'+ labelclass).each(function(){
		var parentID = jQuery(this).data('id'),
			parentValue = jQuery(this).data('value');
		
		if(fieldValue !== parentValue){
			jQuery(this).closest('tr').hide();
		} else {
			jQuery(this).closest('tr').fadeIn('slow');
		}
	});
	
	//now lets make sure that the children that were hidden make their effect
	//lazy version :)
	jQuery('.redux-opts-checkbox-hide-below').each(function(){
		var amount = jQuery(this).data('amount');
		if (jQuery(this).prop('checked') && jQuery(this).is(':visible')) {
			jQuery(this).closest('tr').nextAll('tr').slice(0,amount).fadeIn('slow');
		} else {
			jQuery(this).closest('tr').nextAll('tr').slice(0,amount).fadeOut('slow');
		}
	});
}
