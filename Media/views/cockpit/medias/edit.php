<h1 class="page-title">{{ pageTitle }}</h1>
<div class="actions">
    {% button url="cockpit_media_medias" type="default" icon="arrow-left" content="Retour" %}
</div>
{% form_open id="formMedia" action="formAction" class="form-horizontal" %}
    {% input_select name="type" model="media.type" options="typeOptions" label="Type de media" %}
    {% input_text name="name" model="media.name" label="Nom" %}
    {% input_image name="image" model="media.image" label="Fichier image" class="media media-image" %}
    {% input_video name="video" model="video" label="Fichier video" class="media media-video" %}
    {% input_music name="music" model="music" label="Fichier audio" class="media media-music" %}
    <!-- {% input_text name="url" model="media.url" label="URL" %} -->
    {% input_textarea name="description" model="media.description" label="Description" rows="10" %}
    {% input_submit name="submit" value="save" formId="formMedia" class="btn-primary" icon="save" label="Enregistrer" %}
{% form_close %}
