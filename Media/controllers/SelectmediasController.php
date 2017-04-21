<?php

namespace Media\controllers;

use app\controllers\FrontController;
use System\Session;
use System\Router;

use Media\models\Media;

class SelectmediasController extends FrontController
{
    public function selectAction()
    {
        $where = '';

        $mediaType = isset($this->request->post['mediaType']) ? $this->request->post['mediaType'] : '';
        if ($mediaType != '') {
            $where = ' type = '.$mediaType;
        }

        $mediaCategory = isset($this->request->post['mediaCategory']) && $this->request->post['mediaCategory'] == '';
        if ($mediaCategory != '') {
            $where = ' category = '.$mediaCategory;
        }

        $medias = Media::findAll(
            $where,
            array(
                'column' => 'created_at',
                'order' => 'desc'
            )
        );

        $this->render(
            'select',
            array(
                'medias' => $medias,
                'mediaType' => $mediaType,
                'formSelectMediasAddAction' => '/media/selectmedias/add'
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
