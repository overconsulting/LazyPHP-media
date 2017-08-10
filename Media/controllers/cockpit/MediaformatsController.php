<?php

namespace Media\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use Core\Session;
use Core\Router;

use Media\models\MediaFormat;

class MediaformatsController extends CockpitController
{
    /*
     * @var Media\models\MediaFormat
     */
    public $mediaFormat = null;

    public function indexAction()
    {
        $mediaFormats = MediaFormat::findAll();

        $this->render('media::mediaformats::index', array(
            'mediaFormats' => $mediaFormats,
            'pageTitle' => '<i class="fa fa-picture-o fa-brown"></i> Gestion des formats de media',
            'boxTitle' => 'Liste des formats de media'
        ));
    }

    public function newAction()
    {
        if ($this->mediaFormat === null) {
            $this->mediaFormat = new MediaFormat();
        }

        $this->render('media::mediaformats::edit', array(
            'mediaFormat' => $this->mediaFormat,
            'pageTitle' => '<i class="fa fa-picture-o fa-brown"></i> Gestion des formats de media',
            'boxTitle' => 'Nouveau format',
            'formAction' => Router::url('cockpit_media_mediaformats_create')
        ));
    }

    public function editAction($id)
    {
        if ($this->mediaFormat === null) {
            $this->mediaFormat = MediaFormat::findById($id);
        }

        $this->render('media::mediaformats::edit', array(
            'mediaFormat' => $this->mediaFormat,
            'pageTitle' => '<i class="fa fa-picture-o fa-brown"></i> Gestion des formats de media',
            'boxTitle' => 'Modification format de media n°'.$id,
            'formAction' => Router::url('cockpit_media_mediaformats_update_'.$id)
        ));
    }

    public function createAction()
    {
        $this->mediaFormat = new MediaFormat();

        if ($this->mediaFormat->save($this->request->post)) {
            $this->addFlash('Format de media ajouté', 'success');
            $this->redirect('cockpit_media_mediaformats');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        $this->mediaFormat = MediaFormat::findById($id);

        if ($this->mediaFormat->save($this->request->post)) {
            $this->addFlash('Format de media modifié', 'success');
            $this->redirect('cockpit_media_mediaformats');
        } else {
            $this->addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $mediaFormat = MediaFormat::findById($id);
        $mediaFormat->delete();
        $this->addFlash('Format de media supprimé', 'success');
        $this->redirect('cockpit_media_mediaformats');
    }
}
