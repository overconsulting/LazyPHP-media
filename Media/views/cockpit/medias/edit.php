<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_medias" type="secondary" icon="arrow-left" content="" size="sm" %}
        </div>
    </div>
    <div class="box-body">
        {% form_open id="formMedia" action="formAction" %}
<?php if ($selectSite): ?>
            {% input_select name="site_id" model="media.site_id" label="Site" options="siteOptions" %}
<?php endif; ?>
            {% input_select name="type" model="media.type" options="typeOptions" label="Type de media" %}
            {% input_select name="mediacategory_id" model="media.mediacategory_id" label="Catégorie" options="mediacategoryOptions" %}
            {% input_text name="name" model="media.name" label="Nom" %}
            {% input_upload name="image" model="media.image" label="Fichier image" type="image" class="media media-image" %}
            {% input_video name="video" model="media.video" label="Fichier video" class="media media-video" %}
            {% input_audio name="audio" model="media.audio" label="Fichier audio" class="media media-audio" %}
            <!-- {% input_text name="url" model="media.url" label="URL" %} -->
            {% input_textarea name="description" model="media.description" label="Description" rows="10" %}
            {% input_submit name="submit" value="save" formId="formMedia" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>
