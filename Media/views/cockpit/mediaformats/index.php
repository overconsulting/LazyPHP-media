<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_mediaformats_new" type="success" size="sm" icon="plus" hint="Nouveau format de media" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Largeur</th>
                    <th>Hauteur</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($params['mediaFormats'] as $mediaFormat) {
    echo
        '<tr>'.
            '<td>'.$mediaFormat->id.'</td>'.
            '<td>'.$mediaFormat->code.'</td>'.
            '<td>'.$mediaFormat->label.'</td>'.
            '<td>'.$mediaFormat->width.'</td>'.
            '<td>'.$mediaFormat->height.'</td>'.
            '<td>';?>
                {% button url="cockpit_media_mediaformats_edit_<?php echo $mediaFormat->id ?>" type="info" size="sm" icon="pencil" content="" %}
                {% button url="cockpit_media_mediaformats_delete_<?php echo $mediaFormat->id ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce format de media?" %}
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