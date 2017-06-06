<?php

namespace Media\controllers;

use app\controllers\FrontController;
use Core\Session;
use Core\Router;

use Media\models\Media;
use Media\models\MediaCategory;

class SelectmediasController extends FrontController
{
    public function selectAction()
    {
        $where = array();

        $mediaType = isset($this->request->post['mediaType']) ? $this->request->post['mediaType'] : '';
        if ($mediaType != '') {
            $where[] = 'type = \''.$mediaType.'\'';
        }

        $mediaCategory = isset($this->request->post['mediaCategory']) ? $this->request->post['mediaCategory'] : '';
        if ($mediaCategory != '') {
            $mediaCategory = MediaCategory::findByCode($mediaCategory);
            $where[] = 'mediacategory_id = '.$mediaCategory->id;
        }

        if (!empty($where)) {
            $where = implode(' and ', $where);
        }

        $allMedias = Media::findAll(
            $where,
            array(
                'column' => 'created_at',
                'order' => 'desc'
            )
        );

        $active = '';
        $mediaGroups = array();
        foreach ($allMedias as $media) {
            $key = (int)$media->mediacategory_id;
            if (isset($mediaGroups[$key])) {
                $mediaGroups[$key]['items'][] = $media;
            } else {
                $mediaGroups[$key]['code'] = $key != 0 ? $media->mediacategory->code : 'medias';
                $mediaGroups[$key]['label'] = $key != 0 ? strtolower($media->mediacategory->label) : 'commun';
                $mediaGroups[$key]['items'] = array($media);
                if ($active == '') {
                    $mediaGroups[$key]['active'] = true;
                }
            }
        }
        ksort($mediaGroups);

        $this->render(
            'select',
            array(
                'mediaGroups' => $mediaGroups,
                'mediaType' => $mediaType,
                'mediaCategory' => $mediaCategory,
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
        $media->name = date('YmdHis');

        if ($media->save($this->request->post)) {
        } else {
            $res['error'] = true;
            $res['message'] = $media->errors['image'];
        }

        echo json_encode($res);
    }
}
