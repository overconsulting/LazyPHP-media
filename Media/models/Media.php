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
        'url'
    );

    public function setData($data = array())
    {
        if (!is_array($data)) {
            $data = (array)$data;
        }

        if (isset($data['image'])) {
            $this->image = $data['image'];
        } else if (isset($data['video'])) {
            $this->video = $data['video'];
        } else if (isset($data['audio'])) {
            $this->audio = $data['audio'];
        }

        parent::setData($data);
    }

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
        return array_merge(parent::getAttachedFiles(), array(
            array(
                'name' => 'image',
                'type' => 'image'
            ),
            array(
                'name' => 'video',
                'type' => 'video'
            ),
            array(
                'name' => 'audio',
                'type' => 'audio'
            )
        ));
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
            )/*,
            'image' => array(
                'type' => 'required',
                'error' => 'Image obligatoire'
            )*/
        ));

        return $validations;
    }
}
