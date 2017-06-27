<?php

namespace Media\models;

use Core\Model;
use Core\Query;

class MediaFormat extends Model
{
    protected $permittedColumns = array(
        'code',
        'label',
        'width',
        'height'
    );

    public static function getTableName()
    {
        return 'mediaformats';
    }

    public function getValidations()
    {
        $validations = parent::getValidations();

        $validations = array_merge($validations, array(
            'code' => array(
                'type' => 'required',
                'error' => 'Code obligatoire'
            ),
            'label' => array(
                'type' => 'required',
                'error' => 'Nom obligatoire'
            ),
            'width' => array(
                array(
                    'type' => 'required',
                    'error' => 'Largeur obligatoire'
                ),
                array(
                    'type' => 'int',
                    'error' => 'La largeur doit être un nombre entier'
                )
            ),
            'height' => array(
                array(
                    'type' => 'required',
                    'error' => 'Hauteur obligatoire'
                ),
                array(
                    'type' => 'int',
                    'error' => 'La hauteur doit être un nombre entier'
                )
            )
        ));

        return $validations;
    }

    public static function getOptions($where = null)
    {
        $options = array(
            0 => array(
                'value' => '',
                'label' => 'Taille originale'
            )
        );

        $mediaFormats = self::findAll();

        foreach ($mediaFormats as $mediaFormat) {
            $options[$mediaFormat->id] = array(
                'value' => $mediaFormat->code,
                'label' => $mediaFormat->label.' '.$mediaFormat->width.'x'.$mediaFormat->height
            );
        }

        return $options;
    }

    /**
     * Get a media format by code
     * @param string $code
     *
     * @return \Media\models\MediaCategory
     */
    public static function findByCode($code)
    {
        $class = get_called_class();

        $query = new Query();
        $query->select('*');
        $query->where('code = :code');
        $query->from($class::getTableName());

        $row = $query->executeAndFetch(array('code' => $code));
        
        $res = new $class($row);

        return $res;
    }
}
