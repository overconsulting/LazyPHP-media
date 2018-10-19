<?php

namespace Media\models;

use Core\Model;

class File extends Model
{
    protected $permittedColumns = array(
        'site_id',
        'name',
        'file',
    );

    public function getUrl($format = '')
    {
        if ($this->url != "") {
            $url = $this->url;
        } else {
            $url =  '';
        }
        return $url;
    }

    public function getAttachedFiles()
    {
        return array_merge(
            parent::getAttachedFiles(),
            array(
                'file' => array(
                    'type' => 'file'
                )
            )
        );
    }

    /*public function save ()
    {
        $path = PUBLIC_DIR.DS."files".DS.$this->site_id.DS.$this->name;

        if(!is_dir(PUBLIC_DIR.DS."files".DS.$this->site_id)) {
            if (!mkdir(PUBLIC_DIR.DS."files".DS.$this->site_id, 0644, true)) {
                die('Echec lors de la création des répertoires...');
            }
        }

        var_dump($path, $name);

    }*/
}