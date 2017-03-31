<?php

namespace Media\models;

use System\Model;
use System\Query;

class Gallery extends Model
{
    protected $permittedColumns = array(
        'name',
        'description'
    );

    /**
     * Validate the object and fill $this->errors with error messages
     *
     * @return bool
     */
    public function valid()
    {
        $this->errors = array();

        $this->name = trim($this->name);
        if ($this->name == '') {
            $this->errors['name'] = 'Nom obligatoire';
        }

        return empty($this->errors);
    }
}
