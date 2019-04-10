<div class="row no-gutters">
    <div class="medias-column col-md-8">
        <ul class="nav nav-tabs" role="tablist">
<?php

$activeSet = false;
foreach ($params['mediaGroups'] as $key => $mediaGroup) {
    if (!$activeSet) {
        $classActive = ' active';
        $activeSet = true;
    } else {
        $classActive = '';
    }

    echo
        '<li class="nav-item">'.
            '<a href="#medias_'.$mediaGroup['code'].'" class="nav-link '.$classActive.'" role="tab" data-toggle="tab">'.
                $mediaGroup['label'].'
            </a>'.
        '</li>';
}

if (!$activeSet) {
    $classActive = ' active';
    $activeSet = true;
} else {
    $classActive = '';
}

?>
            <li class="nav-item">
                <a href="#medias_add" class="nav-link<?php echo $classActive; ?>" role="tab" data-toggle="tab">
                    <i class="fa fa-plus"></i>&nbsp;Nouveau média
                </a>
            </li>
<?php
if (!$activeSet) {
    $classActive = ' active';
    $activeSet = true;
} else {
    $classActive = '';
}

?>
            <li class="nav-item">
                <a href="#medias_mass_add" class="nav-link<?php echo $classActive; ?>" role="tab" data-toggle="tab">
                    <i class="fa fa-plus"></i>&nbsp;Ajouter des médias
                </a>
            </li>
        </ul>
        <div class="tab-content">
<?php

$activeSet = false;
foreach ($params['mediaGroups'] as $key => $mediaGroup) {
    if (!$activeSet) {
        $classActive =  ' active';
        $activeSet = true;
    } else {
        $classActive = '';
    }

    echo
            '<div id="medias_'.$mediaGroup['code'].'" class="tab-pane'.$classActive.'" role="tabpanel">'.
                '<a href="" class="btn btn-primary select_all_medias_btn">Tous</a>'.
                '<ul class="medias">';

    foreach ($mediaGroup['items'] as $media) {
        $url = $media->getUrl();

        $mediaJson = rawurlencode(json_encode($media));

        echo
            '<li class="media" data-media-id="'.$media->id.'" data-media-url="'.$url.'" data-media="'.$mediaJson.'">'.
                '<img class="media-image" src="'.$url.'" />'.
                '<div class="media-title">'.htmlspecialchars($media->name).'</div>'.
                '<div class="media-actions">'.
                    '<button type="button" class="media-del btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-remove"></i></button>'.
                '</div>'.
            '</li>';
    }

    echo
                '</ul>'.
            '</div>';
}

if (!$activeSet) {
    $classActive = ' active';
    $activeSet = true;
} else {
    $classActive = '';
}

?>
            <div id="medias_add" class="tab-pane<?php echo $classActive; ?>" role="tabpanel">
                <div>
                    <div class="col-xs-8 col-xs-offset-2">
                        {% form_open id="formSelectMediasAdd" action="formSelectMediasAddAction" %}
                            {% input_hidden name="type" model="mediaType" %}
                            {% input_upload name="image" label="Choisissez le media à ajouter" class="media media-image" type="image"  %}
                            {% input_text name="name" label="Nom" %}
                            {% input_select name="mediacategory_id" model="mediaCategory.id" label="Catégorie" options="mediacategoryOptions" %}
                            {% input_submit id="submitSelectMediasAdd" name="submit" value="save" formId="formSelectMediasAdd" class="btn-primary" icon="plus" label="Ajouter" %}
                        {% form_close %}
                    </div>
                </div>
            </div>


<?php
    if (!$activeSet) {
        $classActive = ' active';
        $activeSet = true;
    } else {
        $classActive = '';
    }
?>
            <div id="medias_mass_add" class="tab-pane<?php echo $classActive; ?>" role="tabpanel">
                <div>
                    <div class="col-xs-8 col-xs-offset-2">
                        {% form_open id="formSelectMediasMassAdd" action="formSelectMediasMassAddAction" %}
                            {% input_hidden name="type" model="mediaType" %}
                            {% input_file name="images[]" multiple="multiple" label="Choisissez les médias" class="media media-image" type="image"  %}
                            {% input_select name="mediacategory_id" model="mediaCategory.id" label="Catégorie" options="mediacategoryOptions" %}
                            {% input_submit id="submitSelectMediasMassAdd" name="submit" value="save" formId="formSelectMediasMassAdd" class="btn-primary" icon="plus" label="Ajouter" %}
                        {% form_close %}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="media-properties-column col-md-4">
        <div class="card card-secondary">
            <div class="card-header">
                Sélectionnez un format
            </div>
            <div class="card-block">
                {% form_open id="formSelectMediasFormat" class="" %}
                    {% input_radiogroup name="media_format" options="mediaFormatOptions" %}
                {% form_close %}
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                Propriétés du media
            </div>
            <div id="media_properties" class="card-block">
            </div>
        </div>
    </div>
</div>