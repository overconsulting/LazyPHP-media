<?php

namespace Media\controllers\cockpit;

use app\controllers\cockpit\CockpitController;
use System\Session;
use System\Router;

use Media\models\Media;

class MediasController extends CockpitController
{
    /*
     * @var Media\models\Media
     */
    public $media = null;

    public function indexAction()
    {
        $medias = Media::findAll();

        $typeOptions = Media::getTypeOptions();
        
        $this->render('index', array(
            'medias' => $medias,
            'typeOptions' => $typeOptions,
            'pageTitle' => 'Medias'
        ));
    }

    public function newAction()
    {
        if ($this->media === null) {
            $this->media = new Media();
        }

        $typeOptions = Media::getTypeOptions();

        $this->render('edit', array(
            'id' => 0,
            'media' => $this->media,
            'typeOptions' => $typeOptions,
            'pageTitle' => 'Nouveau media',
            'formAction' => Router::url('cockpit_media_medias_create')
        ));
    }

    public function editAction($id)
    {
        if ($this->media === null) {
            $this->media = Media::findById($id);
        }

        $typeOptions = Media::getTypeOptions();

        $this->render('edit', array(
            'id' => $id,
            'media' => $this->media,
            'typeOptions' => $typeOptions,
            'pageTitle' => 'Modification media n°'.$id,
            'formAction' => Router::url('cockpit_media_medias_update_'.$id)
        ));
    }

    public function createAction()
    {
        $this->media = new Media();

        if ($this->media->save($this->request->post)) {
            Session::addFlash('Media ajouté', 'success');
            $this->redirect('cockpit_media_medias');
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->newAction();
    }

    public function updateAction($id)
    {
        $this->media = Media::findById($id);

        if ($this->media->save($this->request->post)) {
            Session::addFlash('Media modifié', 'success');
            $this->redirect('cockpit_media_medias');
        } else {
            Session::addFlash('Erreur(s) dans le formulaire', 'danger');
        }

        $this->editAction($id);
    }

    public function deleteAction($id)
    {
        $media = Media::findById($id);
        $media->delete();
        Session::addFlash('Media supprimé', 'success');
        $this->redirect('cockpit_media_medias');
    }
}
