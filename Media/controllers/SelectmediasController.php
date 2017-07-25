<?php

namespace Media\controllers;

use app\controllers\FrontController;
use Core\Session;
use Core\Router;
use Core\Utils;

use Media\models\Media;
use Media\models\MediaCategory;
use Media\models\MediaFormat;

class SelectmediasController extends FrontController
{
    public function selectAction()
    {
        $where = array();

        $mediaType = isset($this->request->post['mediaType']) ? $this->request->post['mediaType'] : '';
        if ($mediaType != '') {
            $where[] = 'type = \''.$mediaType.'\'';
        }

        $mediaCategoryCode = isset($this->request->post['mediaCategory']) ? $this->request->post['mediaCategory'] : '';

        if ($mediaCategoryCode != '') {
            $mediaCategory = MediaCategory::findByCode($mediaCategoryCode);
            if ($mediaCategory->id != null) {
                $where[] = 'mediacategory_id = '.$mediaCategory->id;
            }
        }

        $where = !empty($where) ? implode(' and ', $where) : '';

        $allMedias = Media::findAll(
            $where,
            array(
                'column' => 'created_at',
                'order' => 'desc'
            )
        );

        $mediaFormats = MediaFormat::findAll();

        $active = '';
        $mediaGroups = array();
        foreach ($allMedias as $media) {
            $key = (int)$media->mediacategory_id;

            $url = $media->getUrl();
            $path = PUBLIC_DIR.$url;

            $mediaInfos = array(
                'type' => $media->type,
            );

            if ($media->type == 'image' && file_exists($path)) {
                $img = new \Imagick($path);

                $mediaInfos['width'] = $img->getImageWidth();
                $mediaInfos['height'] = $img->getImageHeight();
                $mediaInfos['size'] = Utils::bytesToHumanReadable($img->getImageLength());

                $mediaInfos['mime'] = $img->getImageMimeType();

                $r = $img->getImageResolution();
                $mediaInfos['resolution_x'] = $r['x'];
                $mediaInfos['resolution_y'] = $r['y'];

                foreach ($mediaFormats as $format) {
                    $mediaInfos['formats_urls'][$format->code] = $media->getUrl($format->code);
                }
            }

            $media->infos = $mediaInfos;

            if (isset($mediaGroups[$key])) {
                $mediaGroups[$key]['items'][] = $media;
            } else {
                if(!isset($media->mediacategory)) {
                  $mediaGroups[$key]['code'] = 'medias';
                  $mediaGroups[$key]['label'] = 'commun';
                } else {
                    $mediaGroups[$key]['code'] = $key != 0 ? $media->mediacategory->code : 'medias';
                    $mediaGroups[$key]['label'] = $key != 0 ? strtolower($media->mediacategory->label) : 'commun';
                }
                $mediaGroups[$key]['items'] = array($media);
                if ($active == '') {
                    $mediaGroups[$key]['active'] = true;
                }
            }
        }
        ksort($mediaGroups);

        $mediaFormatOptions = MediaFormat::getOptions();

        $this->render(
            'media::selectmedias::select',
            array(
                'mediaGroups' => $mediaGroups,
                'mediaType' => $mediaType,
                'mediaCategory' => $mediaCategory,
                'mediaFormats' => $mediaFormats,
                'mediaFormatOptions' => $mediaFormatOptions,
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
        $media->site_id = $this->site->id;

        if ($media->save($this->request->post)) {
            $media->generateImages();
        } else {
            $res['error'] = true;
            $res['message'] = $media->errors['image'];
        }

        echo json_encode($res);
        exit;
    }
}
