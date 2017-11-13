<?php

namespace Media\models;

use Core\Model;

use Media\models\MediaFormat;

class Media extends Model
{
    protected $permittedColumns = array(
        'site_id',
        'type',
        'mediacategory_id',
        'name',
        'description',
        'image',
        'video',
        'audio',
        'url'
    );

    /**
     * Set default properties values
     */
    public function setDefaultProperties()
    {
        parent::setDefaultProperties();

        $this->type = 'image';
    }

    /**
     * Get list of associed table(s)
     *
     * @return mixed
     */
    public function getAssociations()
    {
        return array(
            'site' => array(
                'type' => '1',
                'model' => 'Core\\models\\Site',
                'key' => 'site_id',
            ),
            'mediacategory' => array(
                'type' => '1',
                'model' => 'Media\\models\\MediaCategory',
                'key' => 'mediacategory_id'
            )
        );
    }

    public function getAttachedFiles()
    {
        return array_merge(
            parent::getAttachedFiles(),
            array(
                'image' => array(
                    'type' => 'image'
                ),
                'video' => array(
                    'type' => 'video'
                ),
                'audio' => array(
                    'type' => 'audio'
                )
            )
        );
    }

    public function getValidations()
    {
        $validations = parent::getValidations();

        $validations = array_merge($validations, array(
            'type' => array(
                'type' => 'required',
                'defaultValue' => 'image'
            ),
            'name' => array(
                'type' => 'required',
                'error' => 'Nom obligatoire'
            )
        ));

        return $validations;
    }

    public function valid()
    {
        $res = parent::valid();

        if ($this->mediacategory_id == '') {
            $this->mediacategory_id = null;
        }

        if ($this->image->uploadedFile === null && $this->image->url == '' &&
            $this->video->uploadedFile === null && $this->video->url == '' &&
            $this->audio->uploadedFile === null && $this->audio->url == '' &&
            $this->url === null) {
            $error = 'Vous devez sélectionner un fichier';
            $this->errors['image'] = $error;
            $this->errors['video'] = $error;
            $this->errors['audio'] = $error;
        }

        return empty($this->errors);
    }

    /**
     * Get media type options for a select input
     */
    public static function getTypeOptions()
    {
        return array(
            'image' => array(
                'value' => 'image',
                'label' => 'Image'
            ),
            'video' => array(
                'value' => 'video',
                'label' => 'Video'
            ),
            'audio' => array(
                'value' => 'audio',
                'label' => 'Audio'
            )
        );
    }

    public function getUrl($format = '')
    {
        if ($this->url != "") {
            $url = $this->url;
        } else if ($this->type == 'image') {
            $url = $this->getImageUrlWithFormat($this->image->url, $format);
        } else {
            $url = $this->{$this->type} != '' ? $this->{$this->type}->url : '';
        }
        return $url;
    }

    public function getHtml()
    {
        $html = '';

        switch ($this->type) {
            case 'image':
                $html = '<img src="'.$this->image->url.'" />';
                break;

            case 'video':
                $html = '<img src="" />';
                break;

            case 'audio':
                $html = '<img src="" />';
                break;

            default:
                break;
        }

        return $html;
    }

    public function generateImages()
    {
        $mediaFormats = MediaFormat::findAll();
        foreach ($mediaFormats as $format) {
            $path = PUBLIC_DIR.$this->image->url;
            $img = new \Imagick($path);

            $newPath = $this->getImageUrlWithFormat($path, $format->code);

            $img->cropThumbnailImage($format->width, $format->height);
            $img->writeImage($newPath);
        }
    }

    private function getImageUrlWithFormat($url, $format = '')
    {
        $mediaFormat = $format != '' ? MediaFormat::findByCode($format) : null;
        if ($mediaFormat != null) {
            $pi = pathinfo($url);
            return $pi['dirname'].'/'.$pi['filename'].'_'.$mediaFormat->code.'.'.$pi['extension'];
        }
        return $url;
    }
}
