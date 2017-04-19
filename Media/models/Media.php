<?php

namespace Media\models;

use System\Model;
use System\Query;

class Media extends Model
{
    protected $permittedColumns = array(
        'type',
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

        if ($res) {
            if ($this->image->uploadedFile === null && $this->video->uploadedFile === null && $this->audio->uploadedFile === null && $this->url === null) {
                $error = 'Vous devez sélectionner un fichier';
                $this->errors['image'] = $error;
                $this->errors['video'] = $error;
                $this->errors['audio'] = $error;
            }
        }

        return empty($this->errors);
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
}
