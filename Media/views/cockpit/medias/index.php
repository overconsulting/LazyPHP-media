<h1 class="page-title"><i class="fa fa-picture-o"></i> {{ pageTitle }}</h1>
<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Liste des Medias</h3>

        <div class="box-tools pull-right">
            {% button url="cockpit_media_medias_new" type="success" icon="plus" content="" class="btn-xs" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th>Aperçu</th>
                    <th>Type</th>
                    <th>Nom</th>
                    <th>URL</th>
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
                $thumbnail = '<img src="'.$media->image->url.'" width="50" height="50" />';
            }
            break;

        case 'video':
            break;

        case 'audio':
            break;

        default:
            break;
    }

    echo
        '<tr>'.
            '<td>'.$media->id.'</td>'.
            '<td>'.$thumbnail.'</td>'.
            '<td>'.$params['typeOptions'][$media->type]['label'].'</td>'.
            '<td>'.$media->name.'</td>'.
            '<td>'.$media->url.'</td>'.
            '<td>';?>
                {% button url="cockpit_media_medias_edit_<?php echo $media->id ?>" type="primary" size="xs" icon="pencil" content="" %}
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