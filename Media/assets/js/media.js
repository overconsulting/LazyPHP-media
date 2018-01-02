var SelectMediasDialog = function() {
    this.dialog = null;
    this.selectedMedias = [];
    this.inputId = null;
    this.inputDisplayId = null;
    this.multiple = false;
    this.mediaType = "";
    this.mediaCategory = "";
    this.loadEvent = null;
    this.validEvent = null;
};

SelectMediasDialog.prototype.selectMedias = function(params) {
    this.dialog = null;
    this.selectedMedias = [];

    this.inputId = params.inputId != null ? params.inputId : null;
    this.inputDisplayId = params.inputDisplayId != null ? params.inputDisplayId : null;
    this.multiple = params.multiple != null ? params.multiple : false;
    this.mediaType = params.mediaType != null ? params.mediaType : "";
    this.mediaCategory = params.mediaCategory != null ? params.mediaCategory : "";

    var selectMediasLoadEventFunctions = [];
    if (params.loadEvent != null) {
        if (typeof params.loadEvent === 'function') {
            this.loadEvent = params.loadEvent;
        } else if (typeof window[params.loadEvent] === 'function') {
            this.loadEvent = window[params.loadEvent];
        }
        selectMediasLoadEventFunctions = [this.selectMediasLoadEvent.bind(this), this.loadEvent.bind(this)];
    } else {
        this.loadEvent = null;
        selectMediasLoadEventFunctions = [this.selectMediasLoadEvent.bind(this)];
    }

    var selectMediasValidEventFunctions = [];
    if (params.validEvent != null) {
        if (typeof params.validEvent === 'function') {
            this.validEvent = params.validEvent;
        } else if (typeof window[params.validEvent] === 'function') {
            this.validEvent = window[params.validEvent];
        }
        selectMediasValidEventFunctions = [this.selectMediasValidEvent.bind(this)];
    } else {
        this.validEvent = null;
        selectMediasValidEventFunctions = [this.selectMediasValidEvent.bind(this)];
    }

    var postData = new FormData();
    postData.append("mediaType", this.mediaType);
    postData.append("mediaCategory", this.mediaCategory);

    params = {
        postData: postData,
        id: "select_medias_dialog",
        title: "Medias",
        url: "/media/selectmedias/select",
        actions: {
            load: selectMediasLoadEventFunctions,
//          "cancel": null,
            valid: selectMediasValidEventFunctions
        }
    };

    this.lazyDialog = new LazyDialog();
    this.lazyDialog.open(params);
}

SelectMediasDialog.prototype.selectMediasLoadEvent = function() {
    $(window).on("resize", this.selectMediasDialogResizeEvent.bind(this));
    $(window).trigger("resize");

    $("#select_medias_dialog .media").on("click", this.mediaClickEvent.bind(this));
    $("#select_medias_dialog .media-del").on("click", this.mediaDelEvent.bind(this));
    $("#formSelectMediasAdd").on("submit", this.mediaAddClickEvent.bind(this));
    $($("#select_medias_dialog a[role=tab]")[0]).tab('show');
    uploadInit();
}

SelectMediasDialog.prototype.selectMediasDialogResizeEvent = function(event) {
    $("#select_medias_dialog .tab-content").each(function(index, tabContent) {
        var padding =
            $("#select_medias_dialog .lazy-dialog-body").outerHeight() -
            $("#select_medias_dialog .lazy-dialog-body").height();
        var height =
            $("#select_medias_dialog .lazy-dialog-body").outerHeight() -
            $("#select_medias_dialog .nav-item").outerHeight() -
            padding / 2 - 1;
        $(tabContent).height(height);
    });
}

SelectMediasDialog.prototype.selectMediasValidEvent = function() {
    var $selectedMedias = $("#select_medias_dialog .media.selected");
    if ($selectedMedias.length == 0) {
        alert("Vous devez sélectionner au moins un media.");
    } else {
        var s = "";

        var mediaFormat = $("input[name=media_format]:checked").val();
        var mediaUrl = "";

        this.selectedMedias = [];
        $selectedMedias.each(function(index, element) {
            if ($selectedMedias.length == 1) {
                if (mediaFormat == "") {
                    mediaUrl = $(element).data("mediaUrl");
                } else {
                    var media = JSON.parse(decodeURIComponent($(element).data("media")));
                    mediaUrl = media.infos.formats_urls[mediaFormat];
                }
            }
            mediaId = parseInt($(element).data("mediaId"));
            this.selectedMedias.push(mediaId);
        }.bind(this));

        s = this.selectedMedias.join(",");
        $("#" + this.inputId).val(s).trigger("change");
        $("#" + this.inputId + "_url").val(mediaUrl);
        $("#" + this.inputId + "_format").val(mediaFormat);
        $("#" + this.inputDisplayId).val("[" + s + "]" + (mediaUrl != "" ? " " + mediaUrl : ""));

        return true;
    }
}

SelectMediasDialog.prototype.mediaDelEvent = function(event) {
    if (confirm("Vous confirmer vouloir supprimer ce media?")) {
        var $media = $(event.currentTarget).parents(".media");
        var media = JSON.parse(decodeURIComponent($media.data("media")));

        var postData = new FormData();
        postData.append("id", media.id);

        $.ajax({
            url: "/media/selectmedias/del",
            method: "post",
            data: postData,
            processData: false,
            contentType: false,
            dataType: 'text',
            context: this,
            success: this.mediaDelSuccessEvent,
            error: this.mediaAjaxErrorEvent
        });
    }

    event.stopPropagation();
    event.preventDefault();
    return false;
}

SelectMediasDialog.prototype.mediaDelSuccessEvent = function(data, textStatus, jqXHR) {
    res = JSON.parse(data);
    if (res.error) {
        alert(res.message);
    } else {
        $(".input-media-button").trigger("click");
    }
}

SelectMediasDialog.prototype.mediaClickEvent = function(event) {
    var $media = $(event.currentTarget);

    if (this.multiple) {
        $media.toggleClass("selected");
    } else {
        $(".media").not($media).removeClass("selected");
        $media.toggleClass("selected");
    }

    var media = JSON.parse(decodeURIComponent($media.data("media")));
    var mediaProperties = $("#media_properties")[0];
    var html =
        '<table class="media-properties">'+
            '<tr>'+
                '<td>Type :</td>'+
                '<td>'+media.type+', '+media.infos.mime+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Dimensions image d\'origine (l x h) :</td>'+
                '<td>'+media.infos.width+' x '+media.infos.height+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Résolution (pixels / cm) :</td>'+
                '<td>'+media.infos.resolution_x+' x '+media.infos.resolution_y+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Taille :</td>'+
                '<td>'+media.infos.size+'</td>'+
            '</tr>'+
        '</table>';

    mediaProperties.innerHTML = html;
}

SelectMediasDialog.prototype.mediaAddClickEvent = function(event) {
    var formAdd = document.getElementById("formSelectMediasAdd");

    var postData = new FormData(formAdd);

    $.ajax({
        url: formAdd.action,
        method: "post",
        data: postData,
        processData: false,
        contentType: false,
        dataType: 'text',
        context: this,
        success: this.mediaAddSuccessEvent,
        error: this.mediaAjaxErrorEvent
    });

    event.preventDefault();
    return false;
}

SelectMediasDialog.prototype.mediaAddSuccessEvent = function(data, textStatus, jqXHR) {
    res = JSON.parse(data);
    if (res.error) {
        alert(res.message);
    } else {
        $(".input-media-button").trigger("click");
    }
}

SelectMediasDialog.prototype.mediaAjaxErrorEvent = function(jqXHR, textStatus, errorThrown) {
    console.log(textStatus, errorThrown);
}

function formMediaTypeChange(event) {
    var type = $("select[name=type]")[0];
    if (type != null) {
        $("#formMedia input[type=file].media").parents(".form-group").hide();
        $("#formMedia input[type=file].media.media-"+type.options[type.selectedIndex].value).parents(".form-group").show();
    }
}

function selectMediasShow(event) {
    var $inputMediaButton = $(event.currentTarget);

    var inputId = $inputMediaButton.data("inputId");
    var inputDisplayId = $inputMediaButton.data("inputDisplayId");

    var multiple = $inputMediaButton.data("multiple");
    multiple =  multiple != null && multiple == "1";

    var mediaType = $inputMediaButton.data("mediaType");
    if (mediaType == null) {
        mediaType = "";
    }

    var mediaCategory = $inputMediaButton.data("mediaCategory");
    if (mediaCategory == null) {
        mediaCategory = "";
    }

    var validEvent = $inputMediaButton.data("onValid");

    params = {
        inputId: inputId,
        inputDisplayId: inputDisplayId,
        multiple: multiple,
        mediaType: mediaType,
        mediaCategory: mediaCategory,
        validEvent: validEvent
    };

    var selectMediasDialog = new SelectMediasDialog();
    selectMediasDialog.selectMedias(params);

    event.preventDefault();
    return false;
}

function inputMediaClear(event) {
    var $inputMediaClearButton = $(event.currentTarget);
    var inputId = $inputMediaClearButton.data("inputId");
    $("#"+inputId).val("");
    $("#"+inputId+"_url").val("");
    $("#"+inputId+"_format").val("");
    $("#"+inputId+"_display").val("");

    inputMediaClearEvent = $inputMediaClearButton.data("onClear");
    if (inputMediaClearEvent != null && typeof window[inputMediaClearEvent] === 'function') {
        window[inputMediaClearEvent]();
    }

    event.preventDefault();
    return false;
}

$(document).ready(function() {
    $("#formMedia select[name=type]").on("change", formMediaTypeChange);
    formMediaTypeChange(null);

    // $("#formMedia input[type=file].media").on("change", formMediaTypeChange);
    // mediaTypeChange(null);

    $(".input-media-button").on("click", selectMediasShow);
    $(".input-media-clear-button").on("click", inputMediaClear);
});
