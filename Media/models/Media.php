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
     * Ajout les données dans l'objet
     *
     * Cette fonction est appelé à l'instanciation de la classe pour
     * charger les données dans l'objet
     *
     * @param array $data Contient les données à ajouter àl'objet
     *
     * @return void
     */
    public function setData($data = array())
    {
        if (isset($data['image'])) {
            $this->image = $data['image'][0];
        } else if (isset($data['video'])) {
            $this->video = $data['video'][0];
        } else if (isset($data['music'])) {
            $this->music = $data['music'][0];
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

        if (isset($this->image)) {
            $validFile = $this->validFile($this->image, 'image');
            if ($validFile !== true) {
                $this->errors['image'] = $validFile;
            }
        } else if (isset($this->video)) {
            $validFile = $this->validFile($this->video, 'video');
            if ($validFile !== true) {
                $this->errors['video'] = $validFile;
            }
        } else if (isset($this->music)) {
            $validFile = $this->validFile($this->music, 'music');
            if ($validFile !== true) {
                $this->errors['music'] = $validFile;
            }
        }

        return empty($this->errors);
    }
}
