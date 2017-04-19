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

        $medias = Media::findAll(
            '',
            array(
                'column' => 'created_at',
                'order' => 'desc'
            )
        );

        $this->render(
            'select',
            array(
                'medias' => $medias,
                'mediaTypes' => $mediaTypes,
                'formSelectMediasAddAction' => '/cockpit/media/selectmedias/add'
            ),
            false
        );
    }

    public function addAction()
    {
        $res = array(
            'error' => false,
            'message' => ''
        );

        $media = new Media();
        $media->type = 'image';
        $media->name = date('YmdHis');

        if ($media->save($this->request->post)) {
        } else {
            $res['error'] = true;
            $res['message'] = $media->errors['image'];
        }

        echo json_encode($res);
    }
}
