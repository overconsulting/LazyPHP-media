var mediaInputId = null;
var mediaInputDisplay = null;

$(document).ready(function() {
	$("#formMedia select[name=type]").on("change", mediaTypeChange);
	mediaTypeChange(null);

	$("#formMedia input[type=file].media").on("change", mediaTypeChange);
	mediaTypeChange(null);

	$(".input-media-button").on("click", selectMedias);
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
	var $inputMediaButton = $(event.currentTarget);

	mediaInputId = $inputMediaButton.data("inputId");
	mediaInputDisplay = $inputMediaButton.data("inputDisplay");

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

	$("#select_media_dialog .media").on("click", mediaClick);

	$(".lazy-dialog-action").on("click", lazyDialogActionClick);
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

function lazyDialogActionClick(event)
{
	var target = event.currentTarget;
	var action = $(target).data("action");
	var dialog = $(target).parents(".lazy-dialog");

	switch (action) {
		case "cancel":
		case "close":
			dialog.remove();
			break;

		case "valid":
			var selectedMedias = $("#select_media_dialog .media.selected");
			var s = "";
			selectedMedias.each(function(index, element) {
				s = s + $(element).data("mediaId");
				if (index < selectedMedias.length - 1) {
					s = s + ",";
				}
			});
			$(mediaInputId).val(s);
			$(mediaInputDisplay).val(s);
			dialog.remove();
			break;
	}
}
