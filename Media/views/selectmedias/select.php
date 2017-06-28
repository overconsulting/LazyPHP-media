<div class="row">
    <div class="col-md-9">
        <ul class="nav nav-tabs" role="tablist">
<?php

$activeSet = false;
foreach ($params['mediaGroups'] as $key => $mediaGroup) {
    if (!$activeSet) {
        $class =  ' class="active"';
        $activeSet = true;
    } else {
        $class = '';
    }

    echo
        '<li role="presentation">'.
            '<a href="#medias_'.$mediaGroup['code'].'"'.$class.' role="tab" data-toggle="tab">'.
                'Medias '.$mediaGroup['label'].'
            </a>'.
        '</li>';
}

if (!$activeSet) {
    $class =  ' class="active"';
    $activeSet = true;
} else {
    $class = '';
}

?>
            <li role="presentation">
                <a href="#medias_add"<?php echo $class; ?> role="tab" data-toggle="tab">
                    <i class="fa fa-plus"></i>&nbsp;Nouveau media
                </a>
            </li>
        </ul>
        <div class="tab-content">
<?php

$activeSet = false;
foreach ($params['mediaGroups'] as $key => $mediaGroup) {
    if (!$activeSet) {
        $active =  ' in active';
        $activeSet = true;
    } else {
        $active = '';
    }

    echo
            '<div id="medias_'.$mediaGroup['code'].'" class="tab-pane'.$active.'" role="tabpanel">'.
                '<ul class="medias">';

    foreach ($mediaGroup['items'] as $media) {
        $url = $media->getUrl();

        $mediaJson = rawurlencode(json_encode($media));

        echo
                    '<li class="media" data-media-id="'.$media->id.'" data-media-url="'.$url.'" data-media="'.$mediaJson.'">'.
                        '<img class="media-image" src="'.$url.'" width="100" height="100" />'.
                        '<div class="media-title">'.htmlspecialchars($media->name).'</div>'.
                    '</li>';
    }

    echo
                '</ul>'.
            '</div>';
}

if (!$activeSet) {
    $active = ' in active';
    $activeSet = true;
} else {
    $active = '';
}

?>
            <div id="medias_add" class="tab-pane<?php echo $active; ?>" role="tabpanel">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        {% form_open id="formSelectMediasAdd" action="formSelectMediasAddAction" class="form-horizontal" %}
                            {% input_hidden name="type" model="mediaType"  %}
                            {% input_hidden name="mediacategory_id" model="mediaCategory.id" %}
                            {% input_upload name="image" label="Choisissez le media à ajouter" class="media media-image" type="image"  %}
                            {% input_submit id="submitSelectMediasAdd" name="submit" value="save" formId="formSelectMediasAdd" class="btn-primary" icon="plus" label="Ajouter" %}
                        {% form_close %}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Sélectionnez un format
            </div>
            <div class="panel-body">
                {% form_open id="formSelectMediasFormat" class=""%}
                    {% input_radiogroup name="media_format" options="mediaFormatOptions" %}
                {% form_close %}
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Propriétés du media
            </div>
            <div id="media_properties" class="panel-body">
            </div>
        </div>
    </div>
</div>