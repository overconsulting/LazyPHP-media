<?php

namespace Media\controllers;

use app\controllers\FrontController;
use Core\Session;
use Core\Router;
use Core\Utils;
use Core\AttachedFile;

use Media\models\Media;
use Media\models\MediaCategory;
use Media\models\MediaFormat;

class SelectmediasController extends FrontController
{
    public function selectAction()
    {
        $where = array();

        if ($this->site !== null) {
            $where[] = 'site_id = '.$this->site->id;
        }

        $mediaType = isset($this->request->post['mediaType']) ? $this->request->post['mediaType'] : '';
        if ($mediaType != '') {
            $where[] = 'type = \''.$mediaType.'\'';
        }

        $mediaCategoryCode = isset($this->request->post['mediaCategory']) ? $this->request->post['mediaCategory'] : '';

        $mediaCategory = null;
        if ($mediaCategoryCode != '') {
            $mediaCategory = MediaCategory::findByCode($mediaCategoryCode);
            if ($mediaCategory != null) {
                // $where[] = 'mediacategory_id = '.$mediaCategory->id;
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
                if($media->mediacategory_id === null) {
                  $mediaGroups[$key]['code'] = 'medias';
                  $mediaGroups[$key]['label'] = 'Commun';
                } else {
                    $mediaGroups[$key]['code'] = $key != 0 ? $media->mediacategory->code : 'medias';
                    $mediaGroups[$key]['label'] = $key != 0 ? $media->mediacategory->label : 'Commun';
                }
                $mediaGroups[$key]['items'] = array($media);
                if ($active == '') {
                    $mediaGroups[$key]['active'] = true;
                }
            }
        }
        ksort($mediaGroups);

        $mediaFormatOptions = MediaFormat::getOptions();

        $mediacategoryOptions = MediaCategory::getOptions();

        $this->render(
            'media::selectmedias::select',
            array(
                'mediaGroups'                   => $mediaGroups,
                'mediaType'                     => $mediaType,
                'mediaCategory'                 => $mediaCategory,
                'mediaFormats'                  => $mediaFormats,
                'mediaFormatOptions'            => $mediaFormatOptions,
                'mediacategoryOptions'          => $mediacategoryOptions,
                'formSelectMediasAddAction'     => '/media/selectmedias/add',
                'formSelectMediasMassAddAction' => '/media/selectmedias/addmass'
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

        if (!isset($this->request->post['name']) || $this->request->post['name'] == '') {
            $this->request->post['name'] = date('YmdHis');
        }

        $media->site_id = $this->site->id;

        if ($media->save($this->request->post)) {
            $media->generateImages();
        } else {
            $res['error'] = true;
            $res['message'] = implode(' | ', $media->errors);
        }

        echo json_encode($res);
        exit;
    }

    public function addmassAction()
    {
        $res = array(
            'error' => false,
            'message' => ''
        );

        $images = $this->request->post['images'];

        foreach($images as $image) {
            $file = new AttachedFile('', $image, $this->request->post['type']);
            $file->valid();
            $file->saveUploadedFile('tmp', 0, $image['name']);
            
            $media = new Media();
            $image['_image_']           = "";
            $image['image']             = $file->url;
            $image['site_id']           = $this->site->id;
            $image['description']       = $image['name'];
            $image['type']              = $this->request->post['type'];
            $image['mediacategory_id']  = $this->request->post['mediacategory_id'];

            $media->save($image);
        }
        echo json_encode($res);
        exit;
    }

    public function delAction()
    {
        $res = array(
            'error' => false,
            'message' => ''
        );

        $id = isset($this->request->post['id']) && $this->request->post['id'] != '' ? $this->request->post['id'] : null;
        if ($id !== null) {
            $media = Media::findById($id);
            $media->delete();
        } else {
            $res['error'] = true;
            $res['message'] = 'Id media invalide';
        }

        echo json_encode($res);
        exit;
    }
}
