<?php

namespace Media\models;

use System\Model;
use System\Query;

class GalleryMEdia extends Model
{
    protected $permittedColumns = array(
        'gallery_id',
        'media_id'
    );

    /**
     * Validate the object and fill $this->errors with error messages
     *
     * @return bool
     */
    public function valid()
    {
        $this->errors = array();

        return empty($this->errors);
    }
}
