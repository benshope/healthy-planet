jQuery(document).ready(function($){
	$("#prestige_color").ColorPicker({
		onChange: function(hsb, hex, rgb) {
			$("#prestige_color").val(hex);
		},
		onSubmit: function(hsb, hex, rgb, el){
			$(el).val(hex);
			$(el).ColorPickerHide();
		},
		onBeforeShow: function (){
			$(this).ColorPickerSetColor(this.value);
		}
	});
	$("#animation").change(function(){
		$(".animation_expand").css("display", ($(this).val()=="swipe" ? "table-row" : "none"));
		$(".ajax_row").css("display", ($(this).val()=="swipe" ? "none" : "table-row"));
	}).trigger("change");
});