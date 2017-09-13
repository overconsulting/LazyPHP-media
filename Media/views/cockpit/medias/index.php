<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_medias_new" type="success" icon="plus" size="sm" hint="Ajouter" %}
            {% button url="cockpit_media_medias_generateimages" type="primary" size="sm" icon="refresh" hint="Regénérer toutes les images" onclick="showHourglass();" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th width="5%">Aperçu</th>
                    <th width="7%">Type</th>
                    <th width="10%">Catégorie</th>
                    <th>Nom</th>
                    <th width="25%">URL</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($params['medias'] as $media) {
    $thumbnail = '';
    switch ($media->type) {
        case 'image':
            $url = $media->getUrl();
            if ($url != '') {
                $thumbnail = '<img src="'.$url.'" width="25" height="25" />';
            }
            break;

        case 'video':
            break;

        case 'audio':
            break;

        default:
            break;
    }

    $mediaCategory = $media->mediacategory !== null ? $media->mediacategory->label : '';

    echo
        '<tr>'.
            '<td>'.$media->id.'</td>'.
            '<td>'.$thumbnail.'</td>'.
            '<td>'.$params['typeOptions'][$media->type]['label'].'</td>'.
            '<td>'.$mediaCategory.'</td>'.
            '<td>'.$media->name.'</td>'.
            '<td>'.$url.'</td>'.
            '<td>';?>
                {% button url="cockpit_media_medias_edit_<?php echo $media->id ?>" type="info" size="sm" icon="pencil" hint="Modifier" %}
                {% button url="cockpit_media_medias_delete_<?php echo $media->id ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce media?" hint="Supprimer" %}
<?php
echo
        '</td>'.
    '</tr>';
}
?>
            </tbody>
        </table>
    </div>
</div>
