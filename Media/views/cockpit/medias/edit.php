<h1 class="page-title">{{ pageTitle }}</h1>
<div class="actions">
    {% button url="cockpit_media_medias" type="default" icon="arrow-left" content="Retour" %}
</div>
<form id="formMedia" method="post" action="{{ formAction }}" class="form form-horizontal">
    {% input_select name="type" model="media.type" options="typeOptions" label="Type de media" %}
    {% input_text name="name" model="media.name" label="Nom" %}
    {% input_text name="url" model="media.url" label="URL" %}
    {% input_textarea name="description" model="media.description" label="Description" rows="10" %}
    {% input_submit name="submit" value="save" formId="formMedia" class="btn-primary" icon="save" label="Enregistrer" %}
</form>
