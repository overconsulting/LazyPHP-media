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
