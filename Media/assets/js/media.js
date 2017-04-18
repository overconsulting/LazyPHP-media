var mediaInputId = null;
var mediaInputDisplayId = null;
var mediaSelectMultiple = false;
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
    mediaOnValid = $inputMediaButton.data("onValid");
    console.log(mediaSelectMultiple);

    if (mediaOnValid != null && typeof window[mediaOnValid] === 'function') {
        selectMediaValidFunctions = [selectMediaValid, window[mediaOnValid]];
    } else {
        selectMediaValidFunctions = [selectMediaValid];
    }

    var postData = new FormData();
    postData.append("mediaTypes", "image");

    options = {
        postData: postData,
        id: "select_media_dialog",
        title: "Medias",
        url: "/cockpit/media/selectmedias/select",
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

function selectMediaValid()
{
    var $selectedMedias = $("#select_media_dialog .media.selected");
    var s = "";

    selectedMedias = [];
    $selectedMedias.each(function(index, element) {
        mediaId = parseInt($(element).data("mediaId"));
        selectedMedias.push(mediaId);
    });

    s = selectedMedias.join(",");
    $("#"+mediaInputId).val(s);
    $("#"+mediaInputDisplayId).val(s);

    return true;
}
