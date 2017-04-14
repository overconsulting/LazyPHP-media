<?php

namespace Media\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use System\Session;
use System\Router;

use Media\models\Media;

class SelectmediasController extends CockpitController
{
    public function selectAction()
    {
        $mediaTypes = isset($this->request->post['mediaTypes']) ? $this->request->post['mediaTypes'] : '';
        $mediaTypes = explode('|', $mediaTypes);

        $multiple = isset($this->request->post['multiple']) && $this->request->post['multiple'] == '1';

        $medias = Media::findAll();

        $this->render(
            'select',
            array(
                'medias' => $medias,
                'mediaTypes' => $mediaTypes
            ),
            false
        );
    }
}
