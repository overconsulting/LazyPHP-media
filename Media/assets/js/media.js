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
	alert(event);
	event.preventDefault();
	return;
	var postData = new FormData();

	$.ajax({
		url: "/cockpit/media/selectmedias"+event.start.format("YYYY-MM-DD"),
		method: "post",
		data: postData,
		processData: false,
		contentType: false,
		dataType: 'text',
		success: selectMediasSuccess,
		error: selectMediasError
	});

	return false;
}


function selectMediasSuccess(data, textStatus, jqXHR)
{
	var selectMediasDialog = $("select_media_dialog");
	if (selectMediasDialog == null) {
		$("body").append(data);
		selectMediasDialog = $("select_media_dialog");
	}
	console.log(selectMediasDialog);
}

function selectMediasError(jqXHR, textStatus, errorThrown)
{
	hideHourglass();
	console.log(textStatus, errorThrown);
}
