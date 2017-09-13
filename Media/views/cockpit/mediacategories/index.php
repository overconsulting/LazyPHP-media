<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_mediacategories_new" type="success" size="sm" icon="plus" hint="Ajouter" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="1%">ID</th>
                    <th>Code</th>
                    <th>Nom</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($params['mediaCategories'] as $mediaCategory) {
    echo
        '<tr>'.
            '<td>'.$mediaCategory->id.'</td>'.
            '<td>'.$mediaCategory->code.'</td>'.
            '<td>'.$mediaCategory->label.'</td>'.
            '<td>';?>
                {% button url="cockpit_media_mediacategories_edit_<?php echo $mediaCategory->id ?>" type="info" size="sm" icon="pencil" hint="Modifier" %}
                {% button url="cockpit_media_mediacategories_delete_<?php echo $mediaCategory->id ?>" type="danger" size="sm" icon="trash-o" confirmation="Vous confirmer vouloir supprimer cette catégorie de media ?" hint="Supprimer" %}
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