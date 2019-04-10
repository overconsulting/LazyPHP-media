<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_files" type="secondary" icon="arrow-left" size="sm" hint="Retour" %}
        </div>
    </div>
    <div class="box-body">
        {% form_open id="formMedia" action="formAction" %}
<?php if ($selectSite): ?>
            {% input_select name="site_id" model="media.site_id" label="Site" options="siteOptions" %}
<?php endif; ?>
            {% input_text name="name" model="media.name" label="Nom" %}
            {% input_upload name="file" model="media.file" label="Fichier" type="file" class="media media-image" %}
            {% input_submit name="submit" value="save" formId="formMedia" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>
