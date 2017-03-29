<h1 class="page-title">{{ pageTitle }}</h1>
<div class="actions">
    {% button url="cockpit_media_medias_new" type="success" icon="plus" content="Ajouter un media" %}
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th width="1%">ID</th>
            <th>Type</th>
            <th>Nom</th>
            <th>URL</th>
            <th width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($params['medias'] as $media) {
    echo 
        '<tr>'.
            '<td>'.$media->id.'</td>'.
            '<td>'.$params['typeOptions'][$media->type]['label'].'</td>'.
            '<td>'.$media->name.'</td>'.
            '<td>'.$media->url.'</td>'.
            '<td>';?>
                {% button url="cockpit_media_medias_edit_<?php echo $media->id ?>" type="primary" size="xs" icon="pencil" content="" %}
                {% button url="cockpit_media_medias_delete_<?php echo $media->id ?>" type="danger" size="xs" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce media?" %}<?php
    echo 
            '</td>'.
        '</tr>';
}
?>
    </tbody>
</table>