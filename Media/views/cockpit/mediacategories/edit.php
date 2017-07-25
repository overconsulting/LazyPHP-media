<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-brown">
    <div class="box-header">
        <h3 class="box-title">{{ boxTitle }}</h3>
        <div class="box-tools pull-right">
            {% button url="cockpit_media_mediacategories" type="secondary" size="sm" icon="arrow-left" content="" %}
        </div>
    </div>
    <div class="box-body">
        {% form_open id="formMediaCategory" action="formAction" %}
<?php if ($selectSite): ?>
            {% input_select name="site_id" model="mediaCategory.site_id" label="Site" options="siteOptions" %}
<?php endif; ?>
            {% input_text name="code" model="mediaCategory.code" label="Code" %}
            {% input_text name="label" model="mediaCategory.label" label="Nom" %}
            {% input_submit name="submit" value="save" formId="formMediaCategory" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>
