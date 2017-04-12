<div id="select_media_dialog" class="lazy-dialog lazy-dialog-fullscreen">
    <div id="select_media_dialog_content" class="lazy-dialog-content">
        <div class="lazy-dialog-header">
            <div class="pull-right lazy-dialog-action lazy-dialog-close-button" data-action="close"><i class="fa fa-remove fa-2x"></i></div>
            <div class="clearfix"></div>
        </div>
        <div class="lazy-dialog-body">
            <ul class="medias">
<?php

foreach ($params['medias'] as $media) {
    $type = $media->type;
    if (in_array($type, $params['mediaTypes'])) {
        switch ($type) {
            case 'image':
                $url = $media->image->url;
                break;
            case 'video':
                $url = $media->video->url;
                break;
            case 'audio':
                $url = $media->audio->url;
                break;
        }

        echo
            '<li class="media" data-media-id="'.$media->id.'" data-media-url="'.$url.'">'.
                '<img class="media-image" src="'.$url.'" width="100" height="100" />'.
                '<div class="media-title">'.htmlspecialchars($media->name).'</div>'.
            '</li>';
    }
}

?>
            </ul>
        </div>
        <div class="lazy-dialog-footer">
            <div class="lazy-dialog-buttons">
                <button class="btn btn-success lazy-dialog-action" data-action="valid"><i class="fa fa-check"></i>&nbsp;OK</button>
            </div>
        </div>
    </div>
</div>
