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
            'music' => array(
                'value' => 'music',
                'label' => 'Music'
            )
        );
    }

    /**
     * Validate the object and fill $this->errors with error messages
     *
     * @return bool
     */
    public function valid()
    {
        $this->errors = array();

        if (!isset($this->type) || $this->type == '') {
            $this->type = 'image';
        }

        $this->name = trim($this->name);
        if ($this->name == '') {
            $this->errors['name'] = 'Nom obligatoire';
        }

        return empty($this->errors);
    }
}
