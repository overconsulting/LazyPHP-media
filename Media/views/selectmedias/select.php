<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#medias_medias" role="tab" data-toggle="tab">Medias communs</a></li>
    <li role="presentation"><a href="#medias_products" role="tab" data-toggle="tab">Medias produits</a></li>
    <li role="presentation"><a href="#medias_add" role="tab" data-toggle="tab"><i class="fa fa-plus"></i>&nbsp;Nouveau media</a></li>
</ul>
<div class="tab-content">
    <div id="medias_medias" class="tab-pane active fade in" role="tabpanel">
        <ul class="medias">

<?php

foreach ($params['medias'] as $media) {
	$url = $media->getUrl();

    echo
        '<li class="media" data-media-id="'.$media->id.'" data-media-url="'.$url.'">'.
            '<img class="media-image" src="'.$url.'" width="100" height="100" />'.
            '<div class="media-title">'.htmlspecialchars($media->name).'</div>'.
        '</li>';
}

?>

        </ul>
    </div>
    <div id="medias_products" class="tab-pane fade" role="tabpanel">
    </div>
    <div id="medias_add" class="tab-pane fade" role="tabpanel">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                {% form_open id="formSelectMediasAdd" action="formSelectMediasAddAction" class="form-horizontal" %}
                    {% input_image name="image" label="Choisissez le media à ajouter" class="media media-image" thumbnail="0" %}
                    {% input_submit id="submitSelectMediasAdd" name="submit" value="save" formId="formSelectMediasAdd" class="btn-primary" icon="plus" label="Ajouter" %}
                {% form_close %}
            </div>
        </div>
    </div>
</div>