<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_mediaformats" type="secondary" icon="arrow-left" size="sm" hint="Retour" %}
        </div>
    </div>
    <div class="box-body">
        {% form_open id="formMediaFormat" action="formAction" %}
            {% input_text name="code" model="mediaFormat.code" label="Code" %}
            {% input_text name="label" model="mediaFormat.label" label="Nom" %}
            {% input_text name="width" model="mediaFormat.width" label="Largeur" %}
            {% input_text name="height" model="mediaFormat.height" label="Hauteur" %}
            {% input_submit name="submit" value="save" formId="formMediaFormat" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>
