<h1 class="page-title"><i class="fa fa-picture-o"></i> {{ pageTitle }}</h1>
<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Liste des catégories de media</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_mediacategories_new" type="success" icon="plus" content="" class="btn-xs" %}
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover">
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
                {% button url="cockpit_media_mediacategories_edit_<?php echo $mediaCategory->id ?>" type="primary" size="xs" icon="pencil" content="" %}
                {% button url="cockpit_media_mediacategories_delete_<?php echo $mediaCategory->id ?>" type="danger" size="xs" icon="trash-o" confirmation="Vous confirmer vouloir supprimer cette catégorie de media?" %}
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