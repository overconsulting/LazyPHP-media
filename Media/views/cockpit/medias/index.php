<h1 class="page-title">{{ titlePage }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ titleBox }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_medias_new" type="success" icon="plus" content="" class="btn-xs" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover">
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
            if ($media->image->url != '') {
                $thumbnail = '<img src="'.$media->image->url.'" width="25" height="25" />';
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
            '<td>'.$media->image->url.'</td>'.
            '<td>';?>
                {% button url="cockpit_media_medias_edit_<?php echo $media->id ?>" type="info" size="xs" icon="pencil" content="" %}
                {% button url="cockpit_media_medias_delete_<?php echo $media->id ?>" type="danger" size="xs" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce media?" %}
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