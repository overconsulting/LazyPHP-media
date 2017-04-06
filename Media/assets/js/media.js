$(document).ready(function() {
	$("#formMedia select[name=type]").on("change", mediaTypeChange);
	mediaTypeChange(null);

	$("#formMedia input[type=file].media").on("change", mediaTypeChange);
	mediaTypeChange(null);
});

function mediaTypeChange(event) {
	var type = $("select[name=type]")[0];
	if (type != null) {
		$("#formMedia input[type=file].media").parents(".form-group").hide();
		$("#formMedia input[type=file].media.media-"+type.options[type.selectedIndex].value).parents(".form-group").show();
	}
}