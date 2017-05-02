var mediaInputId = null;
var mediaInputDisplayId = null;
var mediaSelectMultiple = "0";
var mediaType = "";
var mediaCategory = "";
var mediaOnValid = null;
var selectedMedias = [];

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
    mediaInputDisplayId = $inputMediaButton.data("inputDisplayId");
    mediaSelectMultiple = $inputMediaButton.data("selectMultiple");

    mediaType = $inputMediaButton.data("mediaType");
    if (mediaType == null) {
        mediaType = "";
    }

    mediaCategory = $inputMediaButton.data("mediaCategory");
    if (mediaCategory == null) {
        mediaCategory = "";
    }

    mediaOnValid = $inputMediaButton.data("onValid");
    if (mediaOnValid != null && typeof window[mediaOnValid] === 'function') {
        selectMediaValidFunctions = [selectMediaValid, window[mediaOnValid]];
    } else {
        selectMediaValidFunctions = [selectMediaValid];
    }

    var postData = new FormData();
    postData.append("mediaType", mediaType);
    postData.append("mediaCategory", mediaCategory);

    options = {
        postData: postData,
        id: "select_media_dialog",
        title: "Medias",
        url: "/media/selectmedias/select",
        actions: {
            load: selectMediaLoad,
//          "cancel": null,
            valid: selectMediaValidFunctions
        }
    };

    lazyDialogOpen(options);

    event.preventDefault();
    return false;
}

function selectMediaLoad()
{
    $("#select_media_dialog .media").on("click", mediaClick);
    $("#formSelectMediasAdd").on("submit", mediaAddClick);
}

function mediaClick(event)
{
    var $media = $(event.currentTarget);

    if (mediaSelectMultiple == "1") {
        if ($media.hasClass("selected")) {
            $media.removeClass("selected");
        } else {
            $media.addClass("selected");
        }
    } else {
        $(".media").removeClass("selected");
        $media.addClass("selected");
    }
}

function mediaAddClick(event)
{
    var formAdd = document.getElementById("formSelectMediasAdd");

    var postData = new FormData(formAdd);

    $.ajax({
        url: formAdd.action,
        method: "post",
        data: postData,
        processData: false,
        contentType: false,
        dataType: 'text',
        success: mediaAddSuccess,
        error: mediaAddError
    });

    event.preventDefault();
    return false;
}

function mediaAddSuccess(data, textStatus, jqXHR)
{
    res = JSON.parse(data);
    if (res.error) {
        alert(res.message);
    } else {
        $(".input-media-button").click();
    }
}

function mediaAddError(jqXHR, textStatus, errorThrown)
{
    console.log(textStatus, errorThrown);
}

function selectMediaValid()
{
    var $selectedMedias = $("#select_media_dialog .media.selected");
    var s = "";

    selectedMedias = [];
    $selectedMedias.each(function(index, element) {
        if ($selectedMedias.length == 1) {
            mediaUrl = $(element).data("mediaUrl");
        }
        mediaId = parseInt($(element).data("mediaId"));
        selectedMedias.push(mediaId);
    });

    s = selectedMedias.join(",");
    $("#"+mediaInputId).val(s).trigger('change');
    $("#"+mediaInputId+"_url").val(mediaUrl).trigger('change');
    $("#"+mediaInputDisplayId).val(s).trigger('change');

    return true;
}
