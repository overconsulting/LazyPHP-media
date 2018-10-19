<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_files_new" type="success" icon="plus" size="sm" hint="Ajouter" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th>Nom</th>
                    <th width="75%">URL</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($files as $file) {
    echo
        '<tr>'.
            '<td>'.$file->id.'</td>'.
            '<td>'.$file->name.'</td>'.
            '<td><a href="http://'.$this->site->host.$file->file->url.'" target="_blank">http://'.$this->site->host.$file->file->url.'</td>'.
            '<td>';?>
                {% button url="cockpit_media_files_edit_<?php echo $file->id ?>" type="info" size="sm" icon="pencil" hint="Modifier" %}
                {% button url="cockpit_media_files_delete_<?php echo $file->id ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer ce fichier ?" hint="Supprimer" %}
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
