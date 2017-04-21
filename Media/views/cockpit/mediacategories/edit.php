<h1 class="page-title">{{ pageTitle }}</h1>
<div class="box box-success">
    <div class="box-header">
        <div class="box-tools pull-right">
            {% button url="cockpit_media_mediacategories" type="default" icon="arrow-left" content="" size="xs" %}
        </div>
    </div>
    <div class="box-body">
        {% form_open id="formMediaCategory" action="formAction" class="form-horizontal" %}
            {% input_text name="code" model="mediaCategory.code" label="Code" %}
            {% input_text name="label" model="mediaCategory.label" label="Nom" %}
            {% input_submit name="submit" value="save" formId="formMediaCategory" class="btn-primary" icon="save" label="Enregistrer" %}
        {% form_close %}
    </div>
</div>
