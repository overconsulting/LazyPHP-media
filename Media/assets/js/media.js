$(document).ready(function() {
	$("#formMedia select[name=type]").on("change", mediaTypeChange);
	mediaTypeChange(null);

	$("#formMedia input[type=file].media").on("change", mediaTypeChange);
	mediaTypeChange(null);

	$(".selectMedias").on("click", selectMedias);
});

function mediaTypeChange(event) {
	var type = $("select[name=type]")[0];
	if (type != null) {
		$("#formMedia input[type=file].media").parents(".form-group").hide();
		$("#formMedia input[type=file].media.media-"+type.options[type.selectedIndex].value).parents(".form-group").show();
	}
}

function selectMedias(event)
{
	var postData = new FormData();
	postData.append("mediaTypes", "image");

	$.ajax({
		url: "/cockpit/media/selectmedias/select",
		method: "post",
		data: postData,
		processData: false,
		contentType: false,
		dataType: 'text',
		success: selectMediasSuccess,
		error: selectMediasError
	});

	event.preventDefault();
	return false;
}

function selectMediasSuccess(data, textStatus, jqXHR)
{
	$("#select_media_dialog").remove();
	
	$("body").append(data);
	selectMediasDialog = $("#select_media_dialog")[0];

	$(".lazy-dialog-close").on("click", lazyDialogCloseClick);

	$("#select_media_dialog .media").on("click", mediaClick);
}

function selectMediasError(jqXHR, textStatus, errorThrown)
{
	hideHourglass();
	console.log(textStatus, errorThrown);
}

function mediaClick(event)
{
	var media = $(event.currentTarget);
	if (media.hasClass("selected")) {
		media.removeClass("selected");
	} else {
		media.addClass("selected");
	}
}

function lazyDialogCloseClick(event)
{
	var close = event.currentTarget;
	var dialog = $(close).parents(".lazy-dialog");
	dialog.remove();
}